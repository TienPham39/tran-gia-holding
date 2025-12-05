<?php

namespace App\Repositories\News;

use App\Models\News;

class NewsRepository
{
    /**
     * Lấy danh sách tin tức (client)
     */
    public function list($categoryId = null)
    {
        return News::with('category')
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->orderByDesc('created_at')
            ->paginate(6);
    }

    /**
     * Lấy chi tiết tin theo slug
     */
    public function findBySlug($slug)
    {
        return News::with(['category'])
            ->where('slug', $slug)
            ->firstOrFail();
    }
}
