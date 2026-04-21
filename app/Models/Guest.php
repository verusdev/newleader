<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'event_id', 'name', 'email', 'phone', 'category',
        'confirmed', 'plus_one', 'notes',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
