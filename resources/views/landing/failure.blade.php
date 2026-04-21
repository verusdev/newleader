@extends('layouts.landing')

@section('title', 'Ошибка оплаты')

@section('content')
    <div class="py-20">
        <div class="max-w-md mx-auto px-4 text-center">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Ошибка оплаты</h1>
            <p class="text-gray-600 mb-8">
                К сожалению, не удалось обработать ваш платёж. Пожалуйста, попробуйте снова.
            </p>
            <a href="{{ route('landing.index') }}" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition">
                Вернуться к тарифам
            </a>
        </div>
    </div>
@endsection
