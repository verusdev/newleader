<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientTimelineStep extends Model
{
    protected $fillable = [
        'client_id',
        'code',
        'title',
        'position',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }
}
