@extends('layouts.app')

@section('title', 'Добавить гостя')
@section('page-title', 'Добавить гостя')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('tenant.guests.store', $event) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Имя *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="category">Категория</label>
                        <input type="text" name="category" id="category" value="{{ old('category') }}" class="form-control" placeholder="Например: Родственники, Друзья">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="confirmed" value="1" id="confirmed" class="custom-control-input" {{ old('confirmed') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="confirmed">Подтвердил посещение</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="plus_one">Количество сопровождающих (+1)</label>
                        <input type="number" name="plus_one" id="plus_one" value="{{ old('plus_one', 0) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="notes">Заметки</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.guests.index', $event) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Отмена</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
