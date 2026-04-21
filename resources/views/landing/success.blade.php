@extends('layouts.landing')

@section('title', 'Оплата успешна!')

@section('content')
    <div class="py-20">
        <div class="max-w-md mx-auto px-4 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Оплата успешна!</h1>
            <p class="text-gray-600 mb-8">
                Ваша подписка активирована. Магазин создан по адресу:
                <br>
                <a href="http://{{ $subscription->tenant_domain }}:8000" class="text-blue-600 font-bold hover:underline">
                    http://{{ $subscription->tenant_domain }}.localhost:8000
                </a>
            </p>
            <div class="bg-gray-50 rounded-lg p-4 mb-8 text-left">
                <p class="text-sm text-gray-500">Не забудьте добавить запись в hosts файл:</p>
                <code class="text-sm bg-gray-200 px-2 py-1 rounded">127.0.0.1 {{ $subscription->tenant_domain }}.localhost</code>
            </div>
            <a href="http://{{ $subscription->tenant_domain }}:8000" class="inline-block bg-blue-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-blue-700 transition">
                Перейти в магазин
            </a>
        </div>
    </div>
@endsection
