@extends('layouts.app')

@section('title', 'Редактировать контакт')
@section('page-title', 'Редактировать контакт')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <form action="{{ route('tenant.clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge {{ $client->type === 'client' ? 'badge-success' : 'badge-warning' }}">
                            {{ $client->typeLabel() }}
                        </span>
                        @if($client->contract_signed_at)
                            <small class="text-muted ml-2">Договор: {{ $client->contract_signed_at->format('d.m.Y H:i') }}</small>
                        @endif
                    </div>

                    <h5 class="mb-3">Контакт</h5>

                    <div class="form-group">
                        <label for="name">Имя *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $client->name) }}" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $client->email) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Телефон</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $client->phone) }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Заметки</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes', $client->notes) }}</textarea>
                    </div>

                    <hr>
                    <h5 class="mb-3">Мероприятие</h5>

                    @if($primaryEvent)
                        <div class="form-group">
                            <label for="event_title">Название мероприятия</label>
                            <input type="text" name="event_title" id="event_title" value="{{ old('event_title', $primaryEvent->title) }}" class="form-control">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_type">Тип</label>
                                    <select name="event_type" id="event_type" class="form-control">
                                        @foreach($eventTypes as $value => $label)
                                            <option value="{{ $value }}" @selected(old('event_type', $primaryEvent->type) === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_date">Дата</label>
                                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $primaryEvent->event_date->format('Y-m-d')) }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_time">Время</label>
                                    <input type="time" name="event_time" id="event_time" value="{{ old('event_time', $primaryEvent->event_time) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expected_guests">Гостей</label>
                                    <input type="number" name="expected_guests" id="expected_guests" value="{{ old('expected_guests', $primaryEvent->expected_guests) }}" min="0" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="venue_name">Площадка</label>
                            <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name', $primaryEvent->venue_name) }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="venue_address">Адрес</label>
                            <textarea name="venue_address" id="venue_address" rows="2" class="form-control">{{ old('venue_address', $primaryEvent->venue_address) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="budget_total">Бюджет</label>
                            <input type="number" name="budget_total" id="budget_total" value="{{ old('budget_total', $primaryEvent->budget_total) }}" step="0.01" min="0" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="event_description">Описание мероприятия</label>
                            <textarea name="event_description" id="event_description" rows="3" class="form-control">{{ old('event_description', $primaryEvent->description) }}</textarea>
                        </div>

                        <a href="{{ route('tenant.events.show', $primaryEvent) }}" class="btn btn-outline-info btn-sm mb-3">
                            <i class="fas fa-calendar-alt mr-1"></i> Открыть мероприятие
                        </a>
                    @else
                        <div class="alert alert-light border mb-0">
                            У этого контакта пока нет связанного мероприятия.
                        </div>
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.clients.show', $client) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Назад</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
