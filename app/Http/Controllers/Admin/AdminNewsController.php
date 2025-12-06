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

            // Base64
            'thumbnail_base64' => 'nullable|string',
            'gallery_base64'   => 'nullable|array|max:6',
            'gallery_base64.*' => 'string',
        ]);

        $news = News::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title) . '-' . \Str::random(5),

            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'category_id' => $request->category_id,

            // ⬅️ LƯU BASE64 TRỰC TIẾP VÀO DB
            'thumbnail_base64' => $request->thumbnail_base64,
            'gallery_base64'   => $request->gallery_base64,

            'author' => $request->author ?? 'Admin',
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Đã tạo tin tức thành công!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return Inertia::render("admin/news/Edit", [
            "news" => $news
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

            'thumbnail_base64' => 'nullable|string',
            'gallery_base64' => 'nullable|array|max:6',
            'gallery_base64.*' => 'string',
        ]);
        // Thumbnail: nếu có thì cập nhật, nếu không thì giữ nguyên
        $thumbnail = $request->thumbnail_base64 ?: $news->thumbnail;

        if ($request->has('gallery_base64')) {
            $gallery = $request->gallery_base64; 
        } else {
            $gallery = $news->gallery_base64;
        }

        // Update DB
        $news->update([
            'title'       => $request->title,
            'excerpt'     => $request->excerpt,
            'content'     => $request->content,
            'category_id' => $request->category_id,
            'thumbnail_base64'   => $thumbnail,
            'gallery_base64'     => $gallery,
        ]);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Đã cập nhật tin tức thành công!');
    }


    private function saveBase64($base64, $folder)
    {
        if (!$base64) return null;

        // Tách phần header
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
            $extension = strtolower($type[1]);
        } else {
            return null;
        }

        // Decode
        $imageData = base64_decode($base64);
        if ($imageData === false) return null;

        // Tên file
        $fileName = uniqid() . '.' . $extension;

        Storage::disk('public')->put("$folder/$fileName", $imageData);

        return "storage/$folder/$fileName";
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
