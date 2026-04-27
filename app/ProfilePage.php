<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilePage extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
