@extends('layouts.admin')

@section('title', 'Создать тенанта')
@section('page-title', 'Создать тенанта')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-2"></i>Новый тенант</h3>
            </div>
            <form action="{{ route('admin.tenants.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="domain">Домен</label>
                        <input type="text" name="domain" id="domain" value="{{ old('domain') }}"
                            placeholder="myshop.localhost"
                            class="form-control @error('domain') is-invalid @enderror" required>
                        @error('domain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Пример: myshop.localhost</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Отмена
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Создать
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
