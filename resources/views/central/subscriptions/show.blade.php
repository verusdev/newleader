@extends('layouts.admin')

@section('title', 'Подписка #' . $subscription->id)
@section('page-title', 'Подписка #' . $subscription->id)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Информация о подписке</h3></div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-5">Клиент</dt>
                    <dd class="col-sm-7">{{ $subscription->name }}</dd>

                    <dt class="col-sm-5">Email</dt>
                    <dd class="col-sm-7">{{ $subscription->email }}</dd>

                    <dt class="col-sm-5">Тариф</dt>
                    <dd class="col-sm-7">{{ $subscription->plan->name }} ({{ $subscription->plan->price }} ₽/мес)</dd>

                    <dt class="col-sm-5">Домен</dt>
                    <dd class="col-sm-7">{{ $subscription->tenant_domain }}</dd>

                    <dt class="col-sm-5">Статус</dt>
                    <dd class="col-sm-7">
                        @php
                            $statusColors = ['pending'=>'badge-warning','active'=>'badge-success','cancelled'=>'badge-danger'];
                            $statusNames = ['pending'=>'Ожидание','active'=>'Активна','cancelled'=>'Отменена'];
                        @endphp
                        <span class="badge {{ $statusColors[$subscription->status] ?? 'badge-secondary' }}">
                            {{ $statusNames[$subscription->status] ?? $subscription->status }}
                        </span>
                    </dd>

                    <dt class="col-sm-5">Начало</dt>
                    <dd class="col-sm-7">{{ $subscription->starts_at ? $subscription->starts_at->format('d.m.Y H:i') : '—' }}</dd>

                    <dt class="col-sm-5">Окончание</dt>
                    <dd class="col-sm-7">{{ $subscription->ends_at ? $subscription->ends_at->format('d.m.Y H:i') : '—' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        @if($subscription->tenant)
            <div class="card bg-success">
                <div class="card-header"><h3 class="card-title">Тенант создан</h3></div>
                <div class="card-body">
                    <p><strong>ID тенанта:</strong> {{ $subscription->tenant->id }}</p>
                    <p><strong>Домен:</strong> {{ $subscription->tenant_domain }}</p>
                    <a href="http://{{ $subscription->tenant_domain }}.localhost:8000" target="_blank" class="btn btn-light">
                        <i class="fas fa-external-link-alt mr-1"></i>Открыть магазин
                    </a>
                </div>
            </div>
        @else
            <div class="card bg-warning">
                <div class="card-header"><h3 class="card-title">Тенант не создан</h3></div>
                <div class="card-body">
                    <p>Тенант ещё не создан. Активируйте подписку для создания.</p>
                </div>
            </div>
        @endif

        @if($subscription->status === 'pending')
            <div class="card">
                <div class="card-header"><h3 class="card-title">Действия</h3></div>
                <div class="card-body">
                    <p class="text-muted">Подписка ещё не оплачена. Вы можете активировать её вручную (для разработки).</p>
                    <form action="{{ route('admin.subscriptions.mark-as-paid', $subscription) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check mr-1"></i>Активировать подписку
                        </button>
                    </form>
                    <form action="{{ route('admin.subscriptions.cancel', $subscription) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Отменить подписку?')">
                            <i class="fas fa-times mr-1"></i>Отменить
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

@if($subscription->payments->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Платежи</h3></div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead><tr><th>Метод</th><th>Сумма</th><th>Статус</th><th>Дата</th></tr></thead>
                        <tbody>
                            @foreach($subscription->payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>{{ number_format($payment->amount, 2) }} ₽</td>
                                    <td><span class="badge badge-{{ $payment->status === 'succeeded' ? 'success' : 'warning' }}">{{ $payment->status }}</span></td>
                                    <td>{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Назад к списку</a>
    </div>
</div>
@endsection
