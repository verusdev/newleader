@extends('layouts.app')

@section('title', 'Заказ #' . $order->id)
@section('page-title', 'Заказ #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user mr-2"></i>Информация о клиенте</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">ФИО</dt>
                    <dd class="col-sm-8">{{ $order->customer_name }}</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $order->customer_email }}</dd>

                    @if($order->customer_phone)
                        <dt class="col-sm-4">Телефон</dt>
                        <dd class="col-sm-8">{{ $order->customer_phone }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Статус заказа</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('tenant.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label>Изменить статус</label>
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Ожидание</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>В обработке</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Отправлен</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Доставлен</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Отменён</option>
                        </select>
                    </div>
                </form>

                <hr>

                <div class="d-flex justify-content-between align-items-center">
                    <span>Оплата:</span>
                    @if($order->payment_status === 'paid')
                        <span class="badge badge-success badge-lg">Оплачен</span>
                    @else
                        <span class="badge badge-danger badge-lg">Не оплачен</span>
                        @if($order->payment_status === 'unpaid')
                            <form action="{{ route('tenant.orders.pay', $order) }}" method="POST" class="ml-3">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-credit-card mr-1"></i>Оплатить через ЮKassa
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box mr-2"></i>Товары в заказе</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Цена</th>
                            <th>Кол-во</th>
                            <th>Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item['product_name'] }}</td>
                                <td>{{ number_format($item['price'], 2) }} ₽</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['subtotal'], 2) }} ₽</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-right font-weight-bold">Итого:</td>
                            <td class="font-weight-bold">{{ number_format($order->total_amount, 2) }} ₽</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-credit-card mr-2"></i>Платежи</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Метод</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->payments as $payment)
                            <tr>
                                <td>{{ $payment->yookassa_payment_id ?? 'N/A' }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ number_format($payment->amount, 2) }} ₽</td>
                                <td>
                                    <span class="badge {{ $payment->status === 'succeeded' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">Платежи не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <a href="{{ route('tenant.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Назад к списку
        </a>
    </div>
</div>
@endsection
