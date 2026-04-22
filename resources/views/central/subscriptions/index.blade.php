@extends('layouts.admin')

@section('title', 'Подписки')
@section('page-title', 'Подписки')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-crown mr-2"></i>Подписки</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Клиент</th>
                            <th>Тариф</th>
                            <th>Домен</th>
                            <th>Статус</th>
                            <th>Начало</th>
                            <th>Окончание</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $sub)
                            <tr>
                                <td>{{ $sub->id }}</td>
                                <td>
                                    <div>{{ $sub->name }}</div>
                                    <small class="text-muted">{{ $sub->email }}</small>
                                </td>
                                <td>{{ $sub->plan->name }} ({{ $sub->plan->price }} ₽)</td>
                                <td>{{ $sub->tenant_domain }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'badge-warning',
                                            'active' => 'badge-success',
                                            'cancelled' => 'badge-danger',
                                        ];
                                        $statusNames = [
                                            'pending' => 'Ожидание',
                                            'active' => 'Активна',
                                            'cancelled' => 'Отменена',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusColors[$sub->status] ?? 'badge-secondary' }}">
                                        {{ $statusNames[$sub->status] ?? $sub->status }}
                                    </span>
                                </td>
                                <td>{{ $sub->starts_at ? $sub->starts_at->format('d.m.Y') : '—' }}</td>
                                <td>{{ $sub->ends_at ? $sub->ends_at->format('d.m.Y') : '—' }}</td>
                                <td>
                                    <a href="{{ route('admin.subscriptions.show', $sub) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($sub->tenant)
                                        <a href="http://{{ $sub->tenant_domain }}.localhost:8000" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Подписки не найдены</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $subscriptions->links() }}</div>
        </div>
    </div>
</div>
@endsection
