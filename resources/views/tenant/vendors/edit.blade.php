@extends('layouts.app')

@section('title', 'Редактировать подрядчика')
@section('page-title', 'Редактировать подрядчика')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('tenant.vendors.update', $vendor) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $vendor->name) }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Тип</label>
                        <input type="text" name="type" id="type" value="{{ old('type', $vendor->type) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $vendor->email) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="phone">Телефон</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $vendor->phone) }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="address">Адрес</label>
                        <textarea name="address" id="address" rows="2" class="form-control">{{ old('address', $vendor->address) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="notes">Заметки</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $vendor->notes) }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_active" value="1" id="is_active" class="custom-control-input" {{ old('is_active', $vendor->is_active) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Активен</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.vendors.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Отмена</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
