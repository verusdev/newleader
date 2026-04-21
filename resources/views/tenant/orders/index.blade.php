@extends('layouts.app')

@section('title', 'Заказы')
@section('page-title', 'Заказы')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-shopping-cart mr-2"></i>Список заказов</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.orders.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Новый заказ
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Клиент</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Оплата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>
                                    <div>{{ $order->customer_name }}</div>
                                    <small class="text-muted">{{ $order->customer_email }}</small>
                                </td>
                                <td>{{ number_format($order->total_amount, 2) }} ₽</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'badge-warning',
                                            'processing' => 'badge-info',
                                            'shipped' => 'badge-primary',
                                            'delivered' => 'badge-success',
                                            'cancelled' => 'badge-danger',
                                        ];
                                        $statusNames = [
                                            'pending' => 'Ожидание',
                                            'processing' => 'В обработке',
                                            'shipped' => 'Отправлен',
                                            'delivered' => 'Доставлен',
                                            'cancelled' => 'Отменён',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusColors[$order->status] ?? 'badge-secondary' }}">
                                        {{ $statusNames[$order->status] ?? $order->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($order->payment_status === 'paid')
                                        <span class="badge badge-success">Оплачен</span>
                                    @else
                                        <span class="badge badge-danger">Не оплачен</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tenant.orders.show', $order) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Заказы не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
