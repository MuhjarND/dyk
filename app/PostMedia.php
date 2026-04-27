<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    protected $fillable = [
        'post_id', 'media_type', 'file_path', 'sort_order',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getFileUrlAttribute()
    {
        return asset('uploads/' . $this->file_path);
    }

    public function isImage()
    {
        return $this->media_type === 'image';
    }

    public function isVideo()
    {
        return $this->media_type === 'video';
    }
}
