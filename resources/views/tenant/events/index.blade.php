@extends('layouts.app')

@section('title', 'Мероприятия')
@section('page-title', 'Мероприятия')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Список мероприятий</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.events.calendar') }}" class="btn btn-outline-info btn-sm mr-2">
                        <i class="fas fa-calendar-week mr-1"></i>Календарь
                    </a>
                    <a href="{{ route('tenant.events.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Новое мероприятие
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Клиент</th>
                            <th>Тип</th>
                            <th>Дата</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td><a href="{{ route('tenant.events.show', $event) }}">{{ $event->title }}</a></td>
                                <td>{{ $event->client?->name ?: '—' }}</td>
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
                                <td>{{ $event->event_date->format('d.m.Y') }}</td>
                                <td>
                                    @php
                                        $statusLabels = [
                                            'planning' => ['badge-warning', 'Планирование'],
                                            'confirmed' => ['badge-success', 'Подтверждено'],
                                            'completed' => ['badge-info', 'Завершено'],
                                            'cancelled' => ['badge-danger', 'Отменено'],
                                        ];
                                        $st = $statusLabels[$event->status] ?? ['badge-secondary', $event->status];
                                    @endphp
                                    <span class="badge {{ $st[0] }}">{{ $st[1] }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('tenant.events.show', $event) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('tenant.events.edit', $event) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('tenant.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить мероприятие?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Мероприятия не найдены</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $events->links() }}</div>
        </div>
    </div>
</div>
@endsection
