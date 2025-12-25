<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_category_id',
        'name',
        'phone',
        'email',
        'message',
        'ip_address',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(ContactCategory::class, 'contact_category_id');
    }
}
