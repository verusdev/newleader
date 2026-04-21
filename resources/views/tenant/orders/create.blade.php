@extends('layouts.app')

@section('title', 'Создать заказ')
@section('nav-title', tenant('name') ?? 'Tenant')

@section('nav-links')
    <a href="{{ route('tenant.dashboard') }}" class="text-gray-600 hover:text-gray-900">Главная</a>
    <a href="{{ route('tenant.products.index') }}" class="text-gray-600 hover:text-gray-900">Товары</a>
    <a href="{{ route('tenant.orders.index') }}" class="text-gray-600 hover:text-gray-900">Заказы</a>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemCount = 1;
            const container = document.getElementById('order-items');
            const addButton = document.getElementById('add-item');
            const productOptions = addButton.closest('form').querySelector('select').innerHTML;

            addButton.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'order-item flex gap-4 mb-3 items-center';
                newItem.innerHTML = `
                    <select name="items[${itemCount}][product_id]" class="shadow border rounded py-2 px-3 text-gray-700 flex-1" required>
                        ${productOptions}
                    </select>
                    <input type="number" name="items[${itemCount}][quantity]" value="1" min="1" class="shadow border rounded py-2 px-3 text-gray-700 w-20" required>
                    <button type="button" class="remove-item text-red-600 hover:text-red-900">&times;</button>
                `;
                container.appendChild(newItem);
                itemCount++;

                newItem.querySelector('.remove-item').addEventListener('click', function() {
                    newItem.remove();
                });
            });
        });
    </script>
        <h1 class="text-2xl font-bold mb-6">Создать заказ</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('tenant.orders.store') }}" method="POST" id="order-form">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_name">ФИО клиента *</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('customer_name') border-red-500 @enderror" required>
                        @error('customer_name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_email">Email *</label>
                        <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('customer_email') border-red-500 @enderror" required>
                        @error('customer_email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="customer_phone">Телефон</label>
                        <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('customer_phone') border-red-500 @enderror">
                        @error('customer_phone')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Товары</h3>
                    <div id="order-items">
                        <div class="order-item flex gap-4 mb-3 items-center">
                            <select name="items[0][product_id]" class="shadow border rounded py-2 px-3 text-gray-700 flex-1" required>
                                <option value="">Выберите товар</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }} — {{ number_format($product->price, 2) }} ₽</option>
                                @endforeach
                            </select>
                            <input type="number" name="items[0][quantity]" value="1" min="1" class="shadow border rounded py-2 px-3 text-gray-700 w-20" required>
                        </div>
                    </div>
                    <button type="button" id="add-item" class="text-blue-600 hover:text-blue-900 text-sm">+ Добавить товар</button>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">Комментарий</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Создать заказ
                    </button>
                    <a href="{{ route('tenant.orders.index') }}" class="text-gray-600 hover:text-gray-900">Отмена</a>
                </div>
            </form>
        </div>
    </div>
@endsection
