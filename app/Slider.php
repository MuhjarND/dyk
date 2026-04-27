<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'post_id', 'title', 'description', 'image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getDisplayTitleAttribute()
    {
        return optional($this->post)->title ?: $this->title;
    }

    public function getDisplayDescriptionAttribute()
    {
        return optional($this->post)->excerpt ?: $this->description;
    }

    public function getDisplayUrlAttribute()
    {
        if ($this->post && $this->post->slug) {
            return route('berita.detail', $this->post->slug);
        }

        return route('berita');
    }

    public function getImageUrlAttribute()
    {
        if ($this->post && $this->post->thumbnail) {
            return asset('uploads/' . $this->post->thumbnail);
        }

        if ($this->image) {
            return asset('uploads/' . $this->image);
        }

        return asset('logo_web.png');
    }
}
