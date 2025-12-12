<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHighlight extends Model
{
    use HasFactory;

    protected $table = 'products_highlight';

    protected $fillable = [
        'product_id',
        'content',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship với Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

