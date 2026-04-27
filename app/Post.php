<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'thumbnail',
        'category_id', 'author_id', 'status', 'published_at'
    ];

    protected $dates = ['published_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeLatestPublished($query)
    {
        return $query->published()->orderBy('published_at', 'desc');
    }

    public function getFormattedDateAttribute()
    {
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        if (!$this->published_at) return '-';
        return $this->published_at->format('d') . ' ' . $months[(int)$this->published_at->format('m')] . ' ' . $this->published_at->format('Y');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/uploads/' . $this->thumbnail);
        }
        return asset('img/default-post.jpg');
    }
}
