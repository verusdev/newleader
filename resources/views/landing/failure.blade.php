@extends('layouts.landing')

@section('title', 'Ошибка оплаты')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card shadow">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-times-circle text-danger" style="font-size: 80px;"></i>
                    </div>
                    <h2 class="mb-3">Ошибка оплаты</h2>
                    <p class="text-muted mb-4">К сожалению, не удалось обработать ваш платёж. Пожалуйста, попробуйте снова.</p>
                    <a href="{{ route('landing.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Вернуться к тарифам
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
