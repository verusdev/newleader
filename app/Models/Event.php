<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'client_id', 'title', 'type', 'event_date', 'event_time',
        'venue_name', 'venue_address', 'expected_guests', 'budget_total',
        'description', 'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'budget_total' => 'decimal:2',
    ];

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
