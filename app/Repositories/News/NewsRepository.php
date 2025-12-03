<?php

namespace App\Repositories\News;

use App\Models\News;

class NewsRepository
{
    public function list($category = null)
    {
        $query = News::query()->orderBy('created_at', 'desc');

        if ($category) {
            $query->where('category', $category);
        }

        return $query->paginate(6);
    }

    public function findBySlug($slug)
    {
        return News::where('slug', $slug)->firstOrFail();
    }
}
