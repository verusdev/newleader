@extends('layouts.app')

@section('title', 'Тенант: ' . $tenant->name)
@section('nav-title', 'Admin Panel')

@section('nav-links')
    <a href="{{ route('admin.tenants.index') }}" class="text-gray-600 hover:text-gray-900">Тенанты</a>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Тенант: {{ $tenant->name }}</h1>

        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <dl class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Создан</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $tenant->created_at->format('d.m.Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Домены</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @foreach($tenant->domains as $domain)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-1">
                                {{ $domain->domain }}
                            </span>
                        @endforeach
                    </dd>
                </div>
            </dl>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('admin.tenants.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Назад к списку
            </a>
            <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Удалить тенанта?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Удалить
                </button>
            </form>
        </div>
    </div>
@endsection
