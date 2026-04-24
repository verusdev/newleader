@extends('layouts.app')

@section('title', 'Редактировать мероприятие')
@section('page-title', 'Редактировать мероприятие')

@section('content')
@php
    $typeLabels = [
        'wedding' => 'Свадьба',
        'birthday' => 'День рождения',
        'graduation' => 'Выпускной',
        'corporate' => 'Корпоратив',
        'anniversary' => 'Юбилей',
        'other' => 'Другое',
    ];

    $statusLabels = [
        'planning' => 'Планирование',
        'confirmed' => 'Подтверждено',
        'completed' => 'Завершено',
        'cancelled' => 'Отменено',
    ];
@endphp

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <form action="{{ route('tenant.events.update', $event) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Название *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Тип *</label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" @selected(old('type', $event->type) === $type)>{{ $typeLabels[$type] ?? $type }}</option>
                                    @endforeach
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">Клиент</label>
                                <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror">
                                    <option value="">Без клиента</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" @selected((string) old('client_id', $event->client_id) === (string) $client->id)>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_date">Дата мероприятия *</label>
                                <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" class="form-control @error('event_date') is-invalid @enderror" required>
                                @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_time">Время</label>
                                <input type="time" name="event_time" id="event_time" value="{{ old('event_time', $event->event_time) }}" class="form-control @error('event_time') is-invalid @enderror">
                                @error('event_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="venue_name">Место проведения</label>
                                <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="form-control @error('venue_name') is-invalid @enderror">
                                @error('venue_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expected_guests">Ожидаемое количество гостей</label>
                                <input type="number" name="expected_guests" id="expected_guests" value="{{ old('expected_guests', $event->expected_guests) }}" min="0" class="form-control @error('expected_guests') is-invalid @enderror">
                                @error('expected_guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue_address">Адрес</label>
                        <textarea name="venue_address" id="venue_address" rows="2" class="form-control @error('venue_address') is-invalid @enderror">{{ old('venue_address', $event->venue_address) }}</textarea>
                        @error('venue_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="budget_total">Общий бюджет (₽)</label>
                        <input type="number" name="budget_total" id="budget_total" value="{{ old('budget_total', $event->budget_total) }}" step="0.01" min="0" class="form-control @error('budget_total') is-invalid @enderror">
                        @error('budget_total')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Статус *</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                            @foreach($statusLabels as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $event->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $event->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.events.show', $event) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Назад</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
