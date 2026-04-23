@extends('layouts.admin')

@section('title', 'Создать тенанта')
@section('page-title', 'Создать тенанта')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-2"></i>Новый ведущий / tenant</h3>
            </div>
            <form action="{{ route('admin.tenants.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название / имя ведущего</label>
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
                        <label for="domain">Домен tenant-а</label>
                        <input type="text" name="domain" id="domain" value="{{ old('domain') }}"
                            placeholder="host.localhost"
                            class="form-control @error('domain') is-invalid @enderror" required>
                        @error('domain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Для CRM используется path-URL, но домен сохраняется в карточке tenant-а.</small>
                    </div>

                    <div class="form-group">
                        <label for="landing_template">Дизайн рекламного лендинга</label>
                        <select name="landing_template" id="landing_template"
                            class="form-control @error('landing_template') is-invalid @enderror" required>
                            @foreach($landingTemplates as $value => $label)
                                <option value="{{ $value }}" @selected(old('landing_template', 'classic') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('landing_template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Этот шаблон будет использоваться на публичной странице ведущего.</small>
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
