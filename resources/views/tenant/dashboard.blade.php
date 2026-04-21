@extends('layouts.app')

@section('title', 'Панель управления')
@section('page-title', 'Панель управления')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $productsCount }}</h3>
                <p>Товары</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="{{ route('tenant.products.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $ordersCount }}</h3>
                <p>Заказы</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('tenant.orders.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($revenue, 0) }} ₽</h3>
                <p>Выручка</p>
            </div>
            <div class="icon">
                <i class="fas fa-ruble-sign"></i>
            </div>
            <a href="{{ route('tenant.orders.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $pendingOrders }}</h3>
                <p>В ожидании</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('tenant.orders.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection
