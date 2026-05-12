<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'sort_order', 'name', 'position', 'photo', 'membership_status', 'quote',
    ];

    public static function statusOptions()
    {
        return [
            'anggota' => 'Anggota',
            'istimewa' => 'Istimewa',
            'luar_biasa' => 'Luar Biasa',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::statusOptions()[$this->membership_status] ?? $this->membership_status;
    }

    public function getInitialsAttribute()
    {
        $words = preg_split('/\s+/', trim($this->name));

        return collect($words)
            ->filter()
            ->take(2)
            ->map(function ($word) {
                return strtoupper(substr($word, 0, 1));
            })
            ->implode('');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('uploads/' . $this->photo);
        }

        return null;
    }
}
