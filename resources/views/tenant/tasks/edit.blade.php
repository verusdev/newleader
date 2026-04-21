@extends('layouts.app')

@section('title', 'Редактировать задачу')
@section('page-title', 'Редактировать задачу')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('tenant.tasks.update', [$event, $task]) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Название *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $task->description) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="due_date">Дедлайн</label>
                                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="priority">Приоритет</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Низкий</option>
                                    <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Средний</option>
                                    <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>Высокий</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Статус</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Ожидание</option>
                                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>В работе</option>
                                    <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Готово</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estimated_cost">Оценочная стоимость (₽)</label>
                                <input type="number" name="estimated_cost" id="estimated_cost" value="{{ old('estimated_cost', $task->estimated_cost) }}" step="0.01" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.tasks.index', $event) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Отмена</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
