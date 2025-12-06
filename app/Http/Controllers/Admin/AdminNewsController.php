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

            'thumbnail' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:4096',

            'gallery' => 'nullable|array|size:6',
            'gallery.*' => 'file|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'title.string' => 'Tiêu đề không hợp lệ',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',

            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',

            'thumbnail.mimes' => 'Chỉ cho phép ảnh JPG, JPEG, PNG hoặc WebP',
            'thumbnail.max' => 'Ảnh thumbnail tối đa 4MB',

            'gallery.required' => 'Vui lòng upload đầy đủ 6 ảnh',
            'gallery.array' => 'Dữ liệu gallery không hợp lệ',
            'gallery.size' => 'Gallery phải bao gồm đúng 6 ảnh',
            'gallery.*.mimes' => 'Ảnh trong gallery không đúng định dạng',
            'gallery.*.max' => 'Mỗi ảnh trong gallery tối đa 4MB',
        ]);


        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')
                ->store('news/thumbnails', 'public');
        }

        $galleryPaths = [];

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $galleryPaths[] = $file->store('news/gallery', 'public');
            }
        }

        $news = News::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title) . '-' . \Str::random(5),
            'excerpt' => $request->excerpt,
            'content' => $request->input('content'),
            'category_id' => $request->category_id,

            'thumbnail' => $thumbnailPath,
            'gallery' => $galleryPaths,

            'author' => $request->author ?? 'Admin',
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Đã tạo tin tức thành công!');
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

        // XÓA THUMBNAIL
        if (!empty($news->thumbnail)) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        // XÓA GALLERY (MẢNG)
        if (is_array($news->gallery)) {
            foreach ($news->gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        // XÓA RECORD
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Đã xóa tin tức!');
    }


}
