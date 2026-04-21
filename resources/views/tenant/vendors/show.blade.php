@extends('layouts.app')

@section('title', $vendor->name)
@section('page-title', $vendor->name)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Информация</h3></div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Тип</dt><dd class="col-sm-8">{{ $vendor->type ?? '—' }}</dd>
                    <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $vendor->email ?? '—' }}</dd>
                    <dt class="col-sm-4">Телефон</dt><dd class="col-sm-8">{{ $vendor->phone ?? '—' }}</dd>
                    <dt class="col-sm-4">Статус</dt><dd class="col-sm-8">@if($vendor->is_active)<span class="badge badge-success">Активен</span>@else<span class="badge badge-secondary">Неактивен</span>@endif</dd>
                </dl>
                @if($vendor->address)<hr><p><strong>Адрес:</strong> {{ $vendor->address }}</p>@endif
                @if($vendor->notes)<hr><p>{{ $vendor->notes }}</p>@endif
            </div>
            <div class="card-footer">
                <a href="{{ route('tenant.vendors.edit', $vendor) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Редактировать</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Платежи подрядчику</h3></div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead><tr><th>Мероприятие</th><th>Сумма</th><th>Статус</th></tr></thead>
                    <tbody>
                        @forelse($vendor->budgetItems as $item)
                            <tr>
                                <td>{{ $item->event->title }}</td>
                                <td>{{ number_format($item->actual_amount, 2) }} ₽</td>
                                <td><span class="badge badge-{{ $item->status === 'paid' ? 'success' : 'warning' }}">{{ $item->status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Нет платежей</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
