@extends('layouts.admin')

@section('title', 'Тенант: ' . $tenant->name)
@section('page-title', 'Тенант: ' . $tenant->name)

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Информация</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">ID</dt>
                    <dd class="col-sm-8">{{ $tenant->id }}</dd>

                    <dt class="col-sm-4">Название</dt>
                    <dd class="col-sm-8">{{ $tenant->name }}</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $tenant->email }}</dd>

                    <dt class="col-sm-4">Создан</dt>
                    <dd class="col-sm-8">{{ $tenant->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-4">Домены</dt>
                    <dd class="col-sm-8">
                        @foreach($tenant->domains as $domain)
                            <span class="badge badge-info">{{ $domain->domain }}</span>
                        @endforeach
                    </dd>
                </dl>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Назад
                </a>
                <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Удалить тенанта?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Удалить
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
