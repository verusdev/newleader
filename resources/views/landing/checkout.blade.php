@extends('layouts.landing')

@section('title', 'Оформление подписки')

@section('content')
    <div class="py-16">
        <div class="max-w-2xl mx-auto px-4">
            <h1 class="text-3xl font-bold mb-8 text-center">Оформление подписки</h1>

            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold">{{ $plan->name }}</h2>
                        <p class="text-gray-500">{{ $plan->description }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold">{{ number_format($plan->price, 0) }} ₽</span>
                        <span class="text-gray-500">/{{ $plan->interval === 'month' ? 'мес' : 'год' }}</span>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('landing.subscribe') }}" method="POST" class="bg-white shadow rounded-lg p-6">
                @csrf
                <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Ваше имя</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tenant_domain">
                        Домен вашего магазина
                    </label>
                    <div class="flex items-center">
                        <input type="text" name="tenant_domain" id="tenant_domain" value="{{ old('tenant_domain') }}"
                            placeholder="myshop"
                            class="shadow appearance-none border rounded-l py-2 px-3 text-gray-700 flex-1 @error('tenant_domain') border-red-500 @enderror" required>
                        <span class="bg-gray-100 border border-l-0 border-gray-300 rounded-r py-2 px-3 text-gray-500">.localhost</span>
                    </div>
                    @error('tenant_domain')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Для локальной разработки добавьте домен в hosts файл</p>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('landing.index') }}" class="text-gray-600 hover:text-gray-900">← Назад к тарифам</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                        Перейти к оплате
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
