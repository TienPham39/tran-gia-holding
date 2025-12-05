<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'excerpt',
        'content',
        'author',
        'gallery',
        'category_id',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    // Tự generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    // Quan hệ category
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    // Lấy danh sách tin tức liên quan
    public function related($limit = 4)
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
