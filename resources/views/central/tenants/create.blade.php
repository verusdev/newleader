@extends('layouts.app')

@section('title', 'Создать тенанта')
@section('nav-title', 'Admin Panel')

@section('nav-links')
    <a href="{{ route('admin.tenants.index') }}" class="text-gray-600 hover:text-gray-900">Тенанты</a>
@endsection

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-6">Создать тенанта</h1>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('admin.tenants.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Название
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                        required>
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="domain">
                        Домен (например: myshop.localhost)
                    </label>
                    <input type="text" name="domain" id="domain" value="{{ old('domain') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('domain') border-red-500 @enderror"
                        required>
                    @error('domain')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Создать
                    </button>
                    <a href="{{ route('admin.tenants.index') }}" class="text-gray-600 hover:text-gray-900">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
