@extends('layouts.app')

@section('title', $client->name)
@section('page-title', $client->name)

@section('content')
@php
    $primaryEvent = $client->events->sortByDesc('event_date')->first();
    $eventTypeLabels = [
        'wedding' => 'Свадьба',
        'birthday' => 'День рождения',
        'graduation' => 'Выпускной',
        'corporate' => 'Корпоратив',
        'anniversary' => 'Юбилей',
        'other' => 'Другое',
    ];
@endphp
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Карточка контакта</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-5">Статус</dt>
                    <dd class="col-sm-7">
                        <span class="badge {{ $client->type === 'client' ? 'badge-success' : 'badge-warning' }}">
                            {{ $client->typeLabel() }}
                        </span>
                    </dd>

                    <dt class="col-sm-5">Email</dt>
                    <dd class="col-sm-7">{{ $client->email ?: '—' }}</dd>

                    <dt class="col-sm-5">Телефон</dt>
                    <dd class="col-sm-7">{{ $client->phone ?: '—' }}</dd>

                    <dt class="col-sm-5">Договор</dt>
                    <dd class="col-sm-7">{{ $client->contract_signed_at?->format('d.m.Y H:i') ?: 'Не заключён' }}</dd>
                </dl>

                @if($client->notes)
                    <hr>
                    <p class="mb-0">{{ $client->notes }}</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('tenant.clients.edit', $client) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Редактировать
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Бриф по мероприятию</h3>
            </div>
            <div class="card-body">
                @if($primaryEvent)
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Название</dt>
                        <dd class="col-sm-7">{{ $primaryEvent->title }}</dd>

                        <dt class="col-sm-5">Тип</dt>
                        <dd class="col-sm-7">{{ $eventTypeLabels[$primaryEvent->type] ?? $primaryEvent->type }}</dd>

                        <dt class="col-sm-5">Дата</dt>
                        <dd class="col-sm-7">{{ $primaryEvent->event_date->format('d.m.Y') }}</dd>

                        <dt class="col-sm-5">Время</dt>
                        <dd class="col-sm-7">{{ $primaryEvent->event_time ?: '—' }}</dd>

                        <dt class="col-sm-5">Площадка</dt>
                        <dd class="col-sm-7">{{ $primaryEvent->venue_name ?: '—' }}</dd>

                        <dt class="col-sm-5">Гостей</dt>
                        <dd class="col-sm-7">{{ $primaryEvent->expected_guests }}</dd>

                        <dt class="col-sm-5">Бюджет</dt>
                        <dd class="col-sm-7">{{ number_format((float) $primaryEvent->budget_total, 0, '.', ' ') }} ₽</dd>
                    </dl>

                    @if($primaryEvent->description)
                        <hr>
                        <p class="mb-3">{{ $primaryEvent->description }}</p>
                    @endif

                    <a href="{{ route('tenant.events.show', $primaryEvent) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-calendar-alt mr-1"></i> Открыть карточку мероприятия
                    </a>
                @else
                    <p class="text-muted mb-0">Информация о мероприятии пока не заполнена.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Таймлайн сделки</h3>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($client->timelineSteps as $step)
                        <div class="time-label mb-2">
                            <span class="bg-{{ $step->completed_at ? 'success' : 'secondary' }}">
                                Этап {{ $step->position }}
                            </span>
                        </div>
                        <div>
                            <i class="fas {{ $step->completed_at ? 'fa-check bg-success' : 'fa-clock bg-secondary' }}"></i>
                            <div class="timeline-item">
                                <span class="time">
                                    @if($step->completed_at)
                                        <i class="fas fa-calendar-alt"></i> {{ $step->completed_at->format('d.m.Y H:i') }}
                                    @endif
                                </span>
                                <h3 class="timeline-header">{{ $step->title }}</h3>
                                <div class="timeline-body">
                                    @if($step->code === 'contract_signed')
                                        После завершения этого этапа лид автоматически становится клиентом.
                                    @elseif($step->code === 'equipment_prep')
                                        Подготовка техники, реквизита и оборудования под мероприятие.
                                    @else
                                        Рабочий этап сопровождения сделки.
                                    @endif
                                </div>
                                <div class="timeline-footer">
                                    <form action="{{ route('tenant.clients.timeline.toggle', [$client, $step]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $step->completed_at ? 'btn-outline-secondary' : 'btn-success' }}">
                                            <i class="fas {{ $step->completed_at ? 'fa-undo' : 'fa-check' }} mr-1"></i>
                                            {{ $step->completed_at ? 'Вернуть в работу' : 'Завершить этап' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('tenant.clients.timeline.notes', [$client, $step]) }}" method="POST" class="mt-3">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group mb-2">
                                            <label for="timeline-notes-{{ $step->id }}" class="small text-muted mb-1">Примечание к этапу</label>
                                            <textarea
                                                name="notes"
                                                id="timeline-notes-{{ $step->id }}"
                                                class="form-control form-control-sm @error('notes') is-invalid @enderror"
                                                rows="2"
                                                placeholder="Добавьте комментарий, договорённости или следующий шаг"
                                            >{{ old('notes', $step->notes) }}</textarea>
                                            @error('notes')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-save mr-1"></i> Сохранить примечание
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <i class="far fa-flag bg-gray"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Мероприятия клиента</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Тип</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($client->events as $event)
                            <tr>
                                <td><a href="{{ route('tenant.events.show', $event) }}">{{ $event->title }}</a></td>
                                <td>{{ $eventTypeLabels[$event->type] ?? $event->type }}</td>
                                <td>{{ $event->event_date->format('d.m.Y') }}</td>
                                <td><a href="{{ route('tenant.events.show', $event) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Мероприятий пока нет</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
