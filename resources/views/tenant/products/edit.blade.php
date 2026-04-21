@extends('layouts.app')

@section('title', 'Редактировать товар')
@section('nav-title', tenant('name') ?? 'Tenant')

@section('nav-links')
    <a href="{{ route('tenant.dashboard') }}" class="text-gray-600 hover:text-gray-900">Главная</a>
    <a href="{{ route('tenant.products.index') }}" class="text-gray-600 hover:text-gray-900">Товары</a>
@endsection

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-6">Редактировать товар</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('tenant.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Название</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Описание</label>
                    <textarea name="description" id="description" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="price">Цена (₽)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('price') border-red-500 @enderror" required>
                    @error('price')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Изображение</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 @error('image') border-red-500 @enderror">
                    @if($product->image)
                        <p class="text-sm text-gray-500 mt-1">Текущее: {{ $product->image }}</p>
                    @endif
                    @error('image')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            class="form-checkbox h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">Активен</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Сохранить
                    </button>
                    <a href="{{ route('tenant.products.index') }}" class="text-gray-600 hover:text-gray-900">Отмена</a>
                </div>
            </form>
        </div>
    </div>
@endsection
