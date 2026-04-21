@extends('layouts.app')

@section('title', 'Бюджет: ' . $event->title)
@section('page-title', 'Бюджет мероприятия: ' . $event->title)

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('tenant.events.show', $event) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Назад</a>
        <a href="{{ route('tenant.budget.create', $event) }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Добавить статью</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Обзор бюджета</h3></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-blue"><i class="fas fa-calculator"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">План</span>
                                <span class="info-box-number">{{ number_format($totalEstimated, 2) }} ₽</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon {{ $totalActual > $totalEstimated ? 'bg-danger' : 'bg-green' }}">
                                <i class="fas fa-ruble-sign"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Факт</span>
                                <span class="info-box-number">{{ number_format($totalActual, 2) }} ₽</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($totalEstimated > 0)
                    <div class="progress mb-3" style="height: 30px;">
                        <div class="progress-bar {{ $totalActual > $totalEstimated ? 'bg-danger' : 'bg-success' }}"
                            role="progressbar" style="width: {{ min(100, ($totalActual / $totalEstimated * 100)) }}%">
                            {{ number_format(min(100, ($totalActual / $totalEstimated * 100)), 1) }}%
                        </div>
                    </div>
                    <p class="text-muted text-center">
                        @if($totalActual > $totalEstimated)
                            <span class="text-danger">Перерасход: {{ number_format($totalActual - $totalEstimated, 2) }} ₽</span>
                        @else
                            <span class="text-success">Экономия: {{ number_format($totalEstimated - $totalActual, 2) }} ₽</span>
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">По статьям</h3></div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead><tr><th>Статья</th><th class="text-right">План</th><th class="text-right">Факт</th></tr></thead>
                    <tbody>
                        @forelse($items->take(8) as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td class="text-right">{{ number_format($item->estimated_amount, 2) }} ₽</td>
                                <td class="text-right">{{ number_format($item->actual_amount, 2) }} ₽</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Нет статей</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Все статьи бюджета</h3></div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead><tr><th>Название</th><th>План</th><th>Факт</th><th>Статус</th><th>Подрядчик</th><th>Действия</th></tr></thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format($item->estimated_amount, 2) }} ₽</td>
                                <td>{{ number_format($item->actual_amount, 2) }} ₽</td>
                                <td>
                                    @php $st = ['pending'=>['badge-warning','Ожидание'],'paid'=>['badge-success','Оплачено'],'overdue'=>['badge-danger','Просрочено']];
                                    $s = $st[$item->status] ?? ['badge-secondary', $item->status]; @endphp
                                    <span class="badge {{ $s[0] }}">{{ $s[1] }}</span>
                                </td>
                                <td>{{ $item->vendor?->name ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('tenant.budget.edit', [$event, $item]) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('tenant.budget.destroy', [$event, $item]) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Статьи не найдены</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $items->links() }}</div>
        </div>
    </div>
</div>
@endsection
