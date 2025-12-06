<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\News\NewsService;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    protected $news;

    public function __construct(NewsService $news)
    {
        $this->news = $news;
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

        return Inertia::render('client/news/Index', [
            'latestNews'       => $latestNews,
            'thiTruong'        => $thiTruong,
            'quyHoachVung'     => $quyHoachVung,
            'tranGiaHolding'   => $tranGiaHolding,
        ]);
    }
    public function show($slug)
    {
        $news = News::with('category')->where('slug', $slug)->firstOrFail();

        // Lấy 2-3 tin cùng category nhưng không trùng ID
        $relatedNews = News::where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(3)
            ->get();

        return Inertia::render('client/news/Detail', [
            'news' => $news,
            'relatedNews' => $relatedNews
        ]);
    }
}
