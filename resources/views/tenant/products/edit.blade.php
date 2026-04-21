@extends('layouts.app')

@section('title', 'Редактировать товар')
@section('page-title', 'Редактировать товар')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <form action="{{ route('tenant.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                            class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Цена (₽) *</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                            class="form-control @error('price') is-invalid @enderror" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Изображение</label>
                        <div class="custom-file">
                            <input type="file" name="image" id="image" accept="image/*"
                                class="custom-file-input @error('image') is-invalid @enderror">
                            <label class="custom-file-label" for="image">Выберите файл</label>
                        </div>
                        @if($product->image)
                            <small class="form-text text-muted">Текущее: {{ $product->image }}</small>
                        @endif
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_active" value="1" id="is_active" class="custom-control-input" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Активен</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Отмена
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
