@extends('layouts.app')

@section('title', 'Редактировать статью бюджета')
@section('page-title', 'Редактировать статью бюджета')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('tenant.budget.update', [$event, $budgetItem]) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Название *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $budgetItem->name) }}" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estimated_amount">Плановая сумма (₽)</label>
                                <input type="number" name="estimated_amount" id="estimated_amount" value="{{ old('estimated_amount', $budgetItem->estimated_amount) }}" step="0.01" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="actual_amount">Фактическая сумма (₽)</label>
                                <input type="number" name="actual_amount" id="actual_amount" value="{{ old('actual_amount', $budgetItem->actual_amount) }}" step="0.01" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Статус</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ $budgetItem->status === 'pending' ? 'selected' : '' }}>Ожидание</option>
                                    <option value="paid" {{ $budgetItem->status === 'paid' ? 'selected' : '' }}>Оплачено</option>
                                    <option value="overdue" {{ $budgetItem->status === 'overdue' ? 'selected' : '' }}>Просрочено</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="due_date">Дата оплаты</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $budgetItem->due_date?->format('Y-m-d')) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="vendor_id">Подрядчик</label>
                        <select name="vendor_id" id="vendor_id" class="form-control">
                            <option value="">Без подрядчика</option>
                            @foreach($vendors as $vendor)
                                <option value="{{ $vendor->id }}" {{ old('vendor_id', $budgetItem->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notes">Заметки</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control">{{ old('notes', $budgetItem->notes) }}</textarea>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.budget.index', $event) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Отмена</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
