@extends('layouts.landing')

@section('title', 'Оплата успешна!')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card shadow">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                    </div>
                    <h2 class="mb-3">Оплата успешна!</h2>
                    <p class="text-muted mb-4">Ваша подписка активирована.</p>
                    <div class="alert alert-info">
                        <p class="mb-2">Ваш магазин доступен по адресу:</p>
                        <a href="http://{{ $subscription->tenant_domain }}.localhost:8000" class="h5">
                            http://{{ $subscription->tenant_domain }}.localhost:8000
                        </a>
                    </div>
                    <div class="alert alert-warning text-left">
                        <p class="mb-1"><strong>Не забудьте добавить запись в hosts файл:</strong></p>
                        <code>127.0.0.1 {{ $subscription->tenant_domain }}.localhost</code>
                    </div>
                    <a href="http://{{ $subscription->tenant_domain }}.localhost:8000" class="btn btn-primary btn-lg mt-3">
                        <i class="fas fa-store mr-2"></i>Перейти в магазин
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
