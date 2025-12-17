<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_type_id',
        'name',
        'short_description',
        'solugon',
        'status',
        'is_highlight',
        'is_hot',
        'total_area',
    ];

    protected $casts = [
        'is_highlight' => 'boolean',
        'is_hot' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship với ProductType
     */
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    /**
     * Relationship với ProductHighlight
     */
    public function highlights()
    {
        return $this->hasMany(ProductHighlight::class, 'product_id')->orderBy('sort_order');
    }

    /**
     * Relationship với ProductImage
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }

    /**
     * Lấy thumbnail image
     */
    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class, 'product_id')
            ->where('is_thumbnail', true)
            ->where('image_type', '1');
    }

    /**
     * Lấy gallery images
     */
    public function galleryImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id')
            ->where('image_type', '1')
            ->where('is_thumbnail', false)
            ->orderBy('sort_order');
    }

    /**
     * Lấy floor plan images
     */
    public function floorPlanImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id')
            ->where('image_type', '2')
            ->orderBy('sort_order');
    }
}

