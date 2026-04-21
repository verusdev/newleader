@extends('layouts.app')

@section('title', 'Заказ #' . $order->id)
@section('nav-title', tenant('name') ?? 'Tenant')

@section('nav-links')
    <a href="{{ route('tenant.dashboard') }}" class="text-gray-600 hover:text-gray-900">Главная</a>
    <a href="{{ route('tenant.products.index') }}" class="text-gray-600 hover:text-gray-900">Товары</a>
    <a href="{{ route('tenant.orders.index') }}" class="text-gray-600 hover:text-gray-900">Заказы</a>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Заказ #{{ $order->id }}</h1>
            <a href="{{ route('tenant.orders.index') }}" class="text-gray-600 hover:text-gray-900">← Назад к списку</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Информация о клиенте</h2>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ФИО</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->customer_email }}</dd>
                    </div>
                    @if($order->customer_phone)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Телефон</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->customer_phone }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Статус заказа</h2>
                <form action="{{ route('tenant.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 mb-3" onchange="this.form.submit()">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Ожидание</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>В обработке</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Отправлен</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Доставлен</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Отменён</option>
                    </select>
                </form>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Оплата</dt>
                    <dd class="mt-1">
                        @if($order->payment_status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Оплачен</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Не оплачен</span>
                            @if($order->payment_status === 'unpaid')
                                <form action="{{ route('tenant.orders.pay', $order) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-1 px-3 rounded">
                                        Оплатить через ЮKassa
                                    </button>
                                </form>
                            @endif
                        @endif
                    </dd>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Товары в заказе</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Товар</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Цена</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Кол-во</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Сумма</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item['product_name'] }}</td>
                            <td class="px-4 py-2">{{ number_format($item['price'], 2) }} ₽</td>
                            <td class="px-4 py-2">{{ $item['quantity'] }}</td>
                            <td class="px-4 py-2">{{ number_format($item['subtotal'], 2) }} ₽</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-right font-bold">Итого:</td>
                        <td class="px-4 py-2 font-bold">{{ number_format($order->total_amount, 2) }} ₽</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($order->payments->count() > 0)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Платежи</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Метод</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Сумма</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->payments as $payment)
                            <tr>
                                <td class="px-4 py-2">{{ $payment->yookassa_payment_id ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $payment->payment_method }}</td>
                                <td class="px-4 py-2">{{ number_format($payment->amount, 2) }} ₽</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payment->status === 'succeeded' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
