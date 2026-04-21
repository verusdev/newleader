@extends('layouts.app')

@section('title', 'Редактировать гостя')
@section('page-title', 'Редактировать гостя')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('tenant.guests.update', [$event, $guest]) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Имя *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $guest->name) }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $guest->email) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $guest->phone) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="category">Категория</label>
                        <input type="text" name="category" id="category" value="{{ old('category', $guest->category) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="confirmed" value="1" id="confirmed" class="custom-control-input" {{ old('confirmed', $guest->confirmed) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="confirmed">Подтвердил посещение</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="plus_one">+1</label>
                        <input type="number" name="plus_one" id="plus_one" value="{{ old('plus_one', $guest->plus_one) }}" min="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="notes">Zаметки</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes', $guest->notes) }}</textarea>
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
