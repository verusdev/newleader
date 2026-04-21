<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'event_id', 'title', 'description', 'due_date',
        'priority', 'status', 'assigned_to', 'estimated_cost',
    ];

    protected $casts = [
        'due_date' => 'date',
        'estimated_cost' => 'decimal:2',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
