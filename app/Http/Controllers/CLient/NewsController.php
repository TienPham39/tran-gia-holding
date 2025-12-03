<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\News\NewsService;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
        return Inertia::render('client/news/Detail', [
            'layout' => 'client',
            'item' => $this->news->detail($slug)
        ]);
    }
}
