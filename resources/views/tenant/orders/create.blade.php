@extends('layouts.app')

@section('title', 'Создать заказ')
@section('page-title', 'Создать заказ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <form action="{{ route('tenant.orders.store') }}" method="POST" id="order-form">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_name">ФИО клиента *</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                                    class="form-control @error('customer_name') is-invalid @enderror" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_email">Email *</label>
                                <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}"
                                    class="form-control @error('customer_email') is-invalid @enderror" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_phone">Телефон</label>
                                <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}"
                                    class="form-control @error('customer_phone') is-invalid @enderror">
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3"><i class="fas fa-box mr-2"></i>Товары</h5>
                    <div id="order-items">
                        <div class="order-item row mb-3">
                            <div class="col-md-10">
                                <select name="items[0][product_id]" class="form-control" required>
                                    <option value="">Выберите товар</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} — {{ number_format($product->price, 2) }} ₽
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="items[0][quantity]" value="1" min="1" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-item" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus mr-1"></i>Добавить товар
                    </button>

                    <hr>

                    <div class="form-group">
                        <label for="notes">Комментарий</label>
                        <textarea name="notes" id="notes" rows="3"
                            class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.orders.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Отмена
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Создать заказ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemCount = 1;
        const container = document.getElementById('order-items');
        const addButton = document.getElementById('add-item');
        const productOptions = addButton.closest('form').querySelector('select').innerHTML;

        addButton.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'order-item row mb-3';
            newItem.innerHTML = `
                <div class="col-md-10">
                    <select name="items[${itemCount}][product_id]" class="form-control" required>
                        ${productOptions}
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${itemCount}][quantity]" value="1" min="1" class="form-control" required>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-1 remove-item">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(newItem);
            itemCount++;

            newItem.querySelector('.remove-item').addEventListener('click', function() {
                newItem.remove();
            });
        });
    });
</script>
@endsection
