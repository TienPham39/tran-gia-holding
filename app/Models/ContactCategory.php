<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCategory extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
