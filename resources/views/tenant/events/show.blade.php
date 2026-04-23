@extends('layouts.app')

@section('title', $event->title)
@section('page-title', $event->title)

@section('content')
@php
    $typeLabels = [
        'wedding' => 'Свадьба',
        'birthday' => 'День рождения',
        'graduation' => 'Выпускной',
        'corporate' => 'Корпоратив',
        'anniversary' => 'Юбилей',
        'other' => 'Другое',
    ];

    $statusLabels = [
        'planning' => 'Планирование',
        'confirmed' => 'Подтверждено',
        'completed' => 'Завершено',
        'cancelled' => 'Отменено',
    ];

    $invitationUrl = route('invitation.show', ['tenant' => tenant('id'), 'eventToken' => $event->invitation_token]);
@endphp

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Информация</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-5">Клиент</dt>
                    <dd class="col-sm-7">{{ $event->client?->name ?: '-' }}</dd>

                    <dt class="col-sm-5">Тип</dt>
                    <dd class="col-sm-7">{{ $typeLabels[$event->type] ?? $event->type }}</dd>

                    <dt class="col-sm-5">Дата</dt>
                    <dd class="col-sm-7">{{ $event->event_date->format('d.m.Y') }}</dd>

                    @if($event->event_time)
                        <dt class="col-sm-5">Время</dt>
                        <dd class="col-sm-7">{{ $event->event_time }}</dd>
                    @endif

                    @if($event->venue_name)
                        <dt class="col-sm-5">Площадка</dt>
                        <dd class="col-sm-7">{{ $event->venue_name }}</dd>
                    @endif

                    <dt class="col-sm-5">Гостей</dt>
                    <dd class="col-sm-7">{{ $event->expected_guests }}</dd>

                    <dt class="col-sm-5">Бюджет</dt>
                    <dd class="col-sm-7">{{ number_format((float) $event->budget_total, 2) }} ₽</dd>

                    <dt class="col-sm-5">Статус</dt>
                    <dd class="col-sm-7">
                        <span class="badge badge-info">{{ $statusLabels[$event->status] ?? $event->status }}</span>
                    </dd>
                </dl>

                @if($event->description)
                    <hr>
                    <p>{{ $event->description }}</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('tenant.events.edit', $event) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Редактировать</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-envelope-open-text mr-2"></i>Лендинг-приглашение</h3>
            </div>
            <div class="card-body">
                <p class="mb-2">Публичная ссылка для приглашения гостей и сбора RSVP:</p>
                <input type="text" class="form-control mb-3" value="{{ $invitationUrl }}" readonly onclick="this.select();">
                <a href="{{ $invitationUrl }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-external-link-alt mr-1"></i> Открыть приглашение
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $event->guests->count() }}/{{ $event->expected_guests }}</h3>
                        <p>Гостей (подтвердили: {{ $event->guests->where('confirmed', true)->count() }})</p>
                    </div>
                    <a href="{{ route('tenant.guests.index', $event) }}" class="small-box-footer">Управлять <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $event->tasks->where('status', '!=', 'completed')->count() }}</h3>
                        <p>Активные задачи</p>
                    </div>
                    <a href="{{ route('tenant.tasks.index', $event) }}" class="small-box-footer">Управлять <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-wallet mr-2"></i>Бюджет</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.budget.index', $event) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body">
                @php $spent = $event->budget_spent; @endphp
                <div class="progress mb-3" style="height: 25px;">
                    <div class="progress-bar {{ $spent > $event->budget_total ? 'bg-danger' : 'bg-success' }}" role="progressbar"
                        style="width: {{ $event->budget_total > 0 ? ($spent / $event->budget_total * 100) : 0 }}%">
                        {{ number_format($spent, 0) }} / {{ number_format((float) $event->budget_total, 0) }} ₽
                    </div>
                </div>
                <table class="table table-sm">
                    <thead><tr><th>Статья</th><th class="text-right">Сумма</th><th class="text-right">Факт</th></tr></thead>
                    <tbody>
                        @forelse($event->budgetItems->take(5) as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="text-right">{{ number_format((float) $item->estimated_amount, 2) }} ₽</td>
                                <td class="text-right">{{ number_format((float) $item->actual_amount, 2) }} ₽</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Нет статей бюджета</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Задачи</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.tasks.create', $event) }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead><tr><th>Задача</th><th>Дедлайн</th><th>Статус</th></tr></thead>
                    <tbody>
                        @forelse($event->tasks->take(5) as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->due_date ? $task->due_date->format('d.m.Y') : '-' }}</td>
                                <td>
                                    @if($task->status === 'completed')
                                        <span class="badge badge-success">Готово</span>
                                    @elseif($task->status === 'in_progress')
                                        <span class="badge badge-warning">В работе</span>
                                    @else
                                        <span class="badge badge-danger">Ожидание</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Нет задач</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('tenant.events.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Назад к списку</a>
    </div>
</div>
@endsection
