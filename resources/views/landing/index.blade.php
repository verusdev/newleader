@extends('layouts.landing')

@section('title', 'CRM для организаторов мероприятий')

@section('content')
<div class="landing-hero text-center">
    <div class="container">
        <h1 class="display-4 font-weight-bold mb-3">CRM для организаторов мероприятий</h1>
        <p class="lead mb-4">Управляйте свадьбами, юбилеями, выпускными и корпоративами в единой системе</p>
        <a href="#plans" class="btn btn-light btn-lg px-5">
            <i class="fas fa-rocket mr-2"></i>Начать бесплатно
        </a>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <div class="bg-white rounded-circle shadow p-4 d-inline-block mb-3">
                <i class="fas fa-calendar-alt fa-3x text-primary"></i>
            </div>
            <h4>Управление событиями</h4>
            <p class="text-muted">Планируйте тайминг, задачи и дедлайны для каждого мероприятия</p>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="bg-white rounded-circle shadow p-4 d-inline-block mb-3">
                <i class="fas fa-users fa-3x text-primary"></i>
            </div>
            <h4>Клиенты и гости</h4>
            <p class="text-muted">Ведите базу клиентов, списки гостей и рассадку</p>
        </div>
        <div class="col-md-4 text-center mb-4">
            <div class="bg-white rounded-circle shadow p-4 d-inline-block mb-3">
                <i class="fas fa-wallet fa-3x text-primary"></i>
            </div>
            <h4>Бюджет и оплата</h4>
            <p class="text-muted">Контролируйте расходы, платежи и счета от подрядчиков</p>
        </div>
    </div>
</div>

<div class="bg-light py-5" id="plans">
    <div class="container">
        <h2 class="text-center mb-5">Тарифные планы</h2>
        <div class="row">
            @foreach($plans as $plan)
                <div class="col-md-4 mb-4">
                    <div class="card pricing-card h-100 shadow-sm">
                        <div class="card-header text-center bg-primary text-white">
                            <h3 class="card-title mb-0">{{ $plan->name }}</h3>
                        </div>
                        <div class="card-body text-center">
                            <h2 class="mb-2">
                                <span class="display-4 font-weight-bold">{{ number_format($plan->price, 0) }}</span>
                                <span class="text-muted">₽/{{ $plan->interval === 'month' ? 'мес' : 'год' }}</span>
                            </h2>
                            <p class="text-muted mb-4">{{ $plan->description }}</p>
                            <ul class="list-unstyled text-left mb-4">
                                @if(is_array($plan->features))
                                    @foreach($plan->features as $feature)
                                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i>{{ $feature }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('landing.checkout', $plan) }}" class="btn btn-primary btn-lg btn-block">
                                Выбрать тариф
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
