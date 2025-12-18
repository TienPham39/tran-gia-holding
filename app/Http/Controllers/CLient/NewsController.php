<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\News\NewsService;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\News;
use App\Services\Product\ProductService;
class NewsController extends Controller
{
    protected $news;
    protected $productService;
    public function __construct(NewsService $news, ProductService $productService)
    {
        $this->news = $news;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        // Đọc số trang của từng block
        $thiTruongPage       = $request->get('thiTruongPage', 1);
        $quyHoachVungPage    = $request->get('quyHoachVungPage', 1);
        $tranGiaHoldingPage  = $request->get('tranGiaHoldingPage', 1);

        // Tin mới nhất
        $latestNews = News::latest()->paginate(5)
            ->appends($request->query());

        // Thị Trường
        $thiTruong = News::where('category_id', 2)
            ->orderByDesc('created_at')
            ->paginate(4, ['*'], 'thiTruongPage', $thiTruongPage)
            ->appends($request->query());

        // Quy Hoạch Vùng
        $quyHoachVung = News::where('category_id', 3)
            ->orderByDesc('created_at')
            ->paginate(4, ['*'], 'quyHoachVungPage', $quyHoachVungPage)
            ->appends($request->query());

        // Trần Gia Holding
        $tranGiaHolding = News::where('category_id', 4)
            ->orderByDesc('created_at')
            ->paginate(4, ['*'], 'tranGiaHoldingPage', $tranGiaHoldingPage)
            ->appends($request->query());
        // Lấy products nổi bật
        $highlightProducts = $this->productService->getHighlightForClient();
        return Inertia::render('client/news/Index', [
            'latestNews'       => $latestNews,
            'thiTruong'        => $thiTruong,
            'quyHoachVung'     => $quyHoachVung,
            'tranGiaHolding'   => $tranGiaHolding,
            'highlightProducts' => $highlightProducts,
        ]);
    }
    public function show($slug)
    {
        $news = News::with('category')->where('slug', $slug)->firstOrFail();

        // Format gallery_base64 từ comma-separated string → array
        $newsData = $news->toArray();
        if (!empty($news->gallery_base64)) {
            // Chuyển từ comma-separated string sang array
            $newsData['gallery_base64'] = array_filter(
                array_map('trim', explode(',', $news->gallery_base64))
            );
        } else {
            $newsData['gallery_base64'] = [];
        }

        // Lấy 2-3 tin cùng category nhưng không trùng ID
        $relatedNews = News::where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        return Inertia::render('client/news/Detail', [
            'news' => $newsData,
            'relatedNews' => $relatedNews
        ]);
    }
}
