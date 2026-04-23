<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'client_id', 'title', 'type', 'event_date', 'event_time',
        'venue_name', 'venue_address', 'expected_guests', 'budget_total',
        'description', 'status', 'invitation_token',
    ];

    protected $casts = [
        'event_date' => 'date',
        'budget_total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Event $event) {
            if (! $event->invitation_token) {
                $event->invitation_token = Str::random(32);
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class);
    }

    public function getBudgetSpentAttribute()
    {
        return $this->budgetItems()->sum('actual_amount');
    }
}
