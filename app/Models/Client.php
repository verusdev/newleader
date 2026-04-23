<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public const TYPES = [
        'lead' => 'Лид',
        'client' => 'Клиент',
    ];

    public const TIMELINE_TEMPLATES = [
        ['code' => 'incoming_call', 'title' => 'Первичный звонок', 'position' => 1],
        ['code' => 'meeting', 'title' => 'Встреча / бриф', 'position' => 2],
        ['code' => 'contract_signed', 'title' => 'Заключение договора', 'position' => 3],
        ['code' => 'equipment_prep', 'title' => 'Подготовка оборудования', 'position' => 4],
        ['code' => 'event_prep', 'title' => 'Финальная подготовка', 'position' => 5],
        ['code' => 'event_day', 'title' => 'День мероприятия', 'position' => 6],
        ['code' => 'follow_up', 'title' => 'Постконтакт / обратная связь', 'position' => 7],
    ];

    protected $fillable = [
        'name',
        'type',
        'pipeline_stage',
        'contract_signed_at',
        'email',
        'phone',
        'notes',
    ];

    protected $casts = [
        'contract_signed_at' => 'datetime',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function timelineSteps()
    {
        return $this->hasMany(ClientTimelineStep::class)->orderBy('position');
    }

    public function ensureTimelineSteps(): void
    {
        foreach (self::TIMELINE_TEMPLATES as $step) {
            $this->timelineSteps()->firstOrCreate(
                ['code' => $step['code']],
                [
                    'title' => $step['title'],
                    'position' => $step['position'],
                ]
            );
        }
    }

    public function refreshPipelineState(): void
    {
        $this->loadMissing('timelineSteps');

        $contractStep = $this->timelineSteps->firstWhere('code', 'contract_signed');

        if ($contractStep?->completed_at) {
            $this->type = 'client';
            $this->contract_signed_at = $contractStep->completed_at;
        } else {
            $this->type = 'lead';
            $this->contract_signed_at = null;
        }

        $nextStep = $this->timelineSteps
            ->sortBy('position')
            ->first(fn (ClientTimelineStep $step) => ! $step->isCompleted());

        $this->pipeline_stage = $nextStep?->code ?? 'completed';
        $this->save();
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
