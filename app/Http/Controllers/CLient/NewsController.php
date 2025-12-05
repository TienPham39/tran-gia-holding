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
        return Inertia::render('client/news/Index', [
            'layout' => 'client',
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
