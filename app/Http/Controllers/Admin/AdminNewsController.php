<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\News\AdminNewsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class AdminNewsController extends Controller
{
    protected $newsService;

    public function __construct(AdminNewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Danh sách tin tức
     */
    public function index()
    {
        $news = News::with('category')->latest()->paginate(5);
        return Inertia::render('admin/news/Index', [
            'news' => $news,
        ]);
    }

    /**
     * Form tạo tin tức
     */
    public function create()
    {
        return Inertia::render('admin/news/Create');
    }

    /**
     * Lưu tin tức vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'category_id' => 'required|integer|exists:news_categories,id',
            'thumbnail' => 'nullable|image|max:20480', // 20MB
            'gallery' => 'nullable|array|max:20',
            'gallery.*' => 'image|max:20480', // 20MB mỗi ảnh
        ]);

        // Upload thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('news/thumbnails', 'public');
            $thumbnailPath = "/storage/$path";
        }

        // Upload gallery
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('news/gallery', 'public');
                $galleryPaths[] = "/storage/$path";
            }
        }

        $news = News::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title) . '-' . \Str::random(5),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'thumbnail_base64' => $thumbnailPath,  // Lưu URL path
            'gallery_base64' => !empty($galleryPaths) ? implode(',', $galleryPaths) : null,  // Comma-separated paths
            'author' => $request->author ?? 'Admin',
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Đã tạo tin tức thành công!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        
        // Chuyển gallery từ comma-separated → array cho frontend
        $newsData = $news->toArray();
        if (!empty($news->gallery_base64)) {
            $newsData['gallery_base64'] = explode(',', $news->gallery_base64);
        } else {
            $newsData['gallery_base64'] = [];
        }
        
        return Inertia::render("admin/news/Edit", [
            "news" => $newsData
        ]);
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'category_id' => 'required|integer|exists:news_categories,id',
            'thumbnail' => 'nullable|image|max:20480', // 20MB
            'gallery' => 'nullable|array|max:6',
            'gallery.*' => 'image|max:20480', // 10MB mỗi ảnh
        ]);

        $data = [
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ];

        // Thumbnail: Nếu có file mới → upload và xóa file cũ
        if ($request->hasFile('thumbnail')) {
            // Xóa file cũ nếu có
            if ($news->thumbnail_base64 && str_starts_with($news->thumbnail_base64, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $news->thumbnail_base64);
                Storage::disk('public')->delete($oldPath);
            }
            // Upload file mới
            $path = $request->file('thumbnail')->store('news/thumbnails', 'public');
            $data['thumbnail_base64'] = "/storage/$path";
        }

        // Gallery: Nếu có files mới → upload và xóa files cũ
        if ($request->hasFile('gallery')) {
            // Xóa files cũ nếu có
            if ($news->gallery_base64) {
                $oldPaths = explode(',', $news->gallery_base64);
                foreach ($oldPaths as $oldPath) {
                    $path = str_replace('/storage/', '', trim($oldPath));
                    Storage::disk('public')->delete($path);
                }
            }
            // Upload files mới
            $galleryPaths = [];
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('news/gallery', 'public');
                $galleryPaths[] = "/storage/$path";
            }
            $data['gallery_base64'] = !empty($galleryPaths) ? implode(',', $galleryPaths) : null;
        }

        $news->update($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Đã cập nhật tin tức thành công!');
    }




    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $path = $request->file('file')->store('news', 'public');

        return response()->json([
            'location' => asset('storage/' . $path)
        ]);
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Đã xóa tin tức!');
    }
}
