<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $fillable = [
        'event_id', 'name', 'email', 'phone', 'category',
        'confirmed', 'rsvp_status', 'responded_at', 'plus_one', 'notes', 'invitation_token',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
        'responded_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Guest $guest) {
            if (! $guest->invitation_token) {
                $guest->invitation_token = Str::random(32);
            }
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
