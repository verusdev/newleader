@extends('layouts.app')

@section('title', 'Задачи: ' . $event->title)
@section('page-title', 'Задачи мероприятия: ' . $event->title)

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('tenant.events.show', $event) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Назад</a>
        <a href="{{ route('tenant.tasks.create', $event) }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Добавить задачу</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Задачи ({{ $tasks->total() }})</h3></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead><tr><th>Задача</th><th>Дедлайн</th><th>Приоритет</th><th>Статус</th><th>Стоимость</th><th>Действия</th></tr></thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->due_date ? $task->due_date->format('d.m.Y') : '—' }}</td>
                                <td>
                                    @php $pColors = ['low'=>'badge-secondary','medium'=>'badge-warning','high'=>'badge-danger']; @endphp
                                    <span class="badge {{ $pColors[$task->priority] ?? 'badge-secondary' }}">
                                        @php $pNames = ['low'=>'Низкий','medium'=>'Средний','high'=>'Высокий']; @endphp
                                        {{ $pNames[$task->priority] ?? $task->priority }}
                                    </span>
                                </td>
                                <td>
                                    @php $sColors = ['pending'=>'badge-danger','in_progress'=>'badge-warning','completed'=>'badge-success'];
                                       $sNames = ['pending'=>'Ожидание','in_progress'=>'В работе','completed'=>'Готово']; @endphp
                                    <span class="badge {{ $sColors[$task->status] ?? 'badge-secondary' }}">{{ $sNames[$task->status] ?? $task->status }}</span>
                                </td>
                                <td>{{ number_format($task->estimated_cost, 2) }} ₽</td>
                                <td>
                                    <a href="{{ route('tenant.tasks.edit', [$event, $task]) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('tenant.tasks.destroy', [$event, $task]) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Задачи не найдены</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $tasks->links() }}</div>
        </div>
    </div>
</div>
@endsection
