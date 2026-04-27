<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'title', 'description', 'location', 'agenda_date',
        'start_time', 'end_time', 'is_active',
    ];

    protected $casts = [
        'agenda_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
