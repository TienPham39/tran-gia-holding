<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBDS extends Model
{
    use HasFactory;
    protected $table = 'productbds';

    protected $fillable = [
        'title',
        'image',
        'description',
        'price',
        'location',
        'status',
    ];
}
