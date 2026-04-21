@extends('layouts.app')

@section('title', 'Редактировать клиента')
@section('page-title', 'Редактировать клиента')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('tenant.clients.update', $client) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Имя *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="notes">Заметки</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $client->notes) }}</textarea>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.clients.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Отмена</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
