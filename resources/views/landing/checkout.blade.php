@extends('layouts.landing')

@section('title', 'Оформление подписки')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-credit-card mr-2"></i>Оформление подписки</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $plan->name }}</strong>
                            <p class="mb-0 text-muted">{{ $plan->description }}</p>
                        </div>
                        <div class="text-right">
                            <span class="h4 mb-0">{{ number_format($plan->price, 0) }} ₽</span>
                            <small class="text-muted">/{{ $plan->interval === 'month' ? 'мес' : 'год' }}</small>
                        </div>
                    </div>

                    <form action="{{ route('landing.subscribe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">

                        <div class="form-group">
                            <label for="name"><i class="fas fa-user mr-1"></i>Ваше имя</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope mr-1"></i>Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tenant_domain"><i class="fas fa-globe mr-1"></i>Домен вашего магазина</label>
                            <div class="input-group">
                                <input type="text" name="tenant_domain" id="tenant_domain" value="{{ old('tenant_domain') }}"
                                    placeholder="myshop"
                                    class="form-control @error('tenant_domain') is-invalid @enderror" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">.localhost</span>
                                </div>
                            </div>
                            @error('tenant_domain')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Для локальной разработки добавьте домен в hosts файл:
                                <code>127.0.0.1 yourdomain.localhost</code>
                            </small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('landing.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Назад
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock mr-2"></i>Перейти к оплате
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
