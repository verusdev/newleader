@extends('layouts.app')

@section('title', 'Панель управления')
@section('page-title', 'Панель управления')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $eventsCount }}</h3>
                <p>Мероприятия</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="{{ route('tenant.events.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $upcomingEvents }}</h3>
                <p>Предстоящие</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="{{ route('tenant.events.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingTasks }}</h3>
                <p>Задачи в работе</p>
            </div>
            <div class="icon">
                <i class="fas fa-tasks"></i>
            </div>
            <a href="{{ route('tenant.tasks.index', $upcoming->first() ?? 1) }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ number_format($budgetSpent, 0) }} ₽</h3>
                <p>Бюджет потрачено</p>
            </div>
            <div class="icon">
                <i class="fas fa-ruble-sign"></i>
            </div>
            <a href="{{ route('tenant.budget.index', $upcoming->first() ?? 1) }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Предстоящие мероприятия</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Дата</th>
                            <th>Тип</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcoming as $event)
                            <tr>
                                <td><a href="{{ route('tenant.events.show', $event) }}">{{ $event->title }}</a></td>
                                <td>{{ $event->event_date->format('d.m.Y') }}</td>
                                <td>
                                    @php
                                        $typeLabels = [
                                            'wedding' => ['Свадьба', 'badge-danger'],
                                            'birthday' => ['День рождения', 'badge-info'],
                                            'graduation' => ['Выпускной', 'badge-success'],
                                            'corporate' => ['Корпоратив', 'badge-warning'],
                                            'anniversary' => ['Юбилей', 'badge-primary'],
                                            'other' => ['Другое', 'badge-secondary'],
                                        ];
                                        $type = $typeLabels[$event->type] ?? ['Другое', 'badge-secondary'];
                                    @endphp
                                    <span class="badge {{ $type[1] }}">{{ $type[0] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Нет предстоящих мероприятий</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-exclamation-triangle mr-2"></i>Срочные задачи</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Задача</th>
                            <th>Дедлайн</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($urgentTasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->due_date ? $task->due_date->format('d.m.Y') : '—' }}</td>
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
                            <tr><td colspan="3" class="text-center text-muted">Нет срочных задач</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
