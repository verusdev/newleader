@extends('layouts.app')

@section('title', 'Новое мероприятие')
@section('page-title', 'Новое мероприятие')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <form action="{{ route('tenant.events.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Название *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Тип *</label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">Выберите тип</option>
                                    @foreach($types as $t)
                                        @php
                                            $labels = ['wedding'=>'Свадьба','birthday'=>'День рождения','graduation'=>'Выпускной','corporate'=>'Корпоратив','anniversary'=>'Юбилей','other'=>'Другое'];
                                        @endphp
                                        <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>{{ $labels[$t] }}</option>
                                    @endforeach
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="client_id">Клиент</label>
                                <select name="client_id" id="client_id" class="form-control">
                                    <option value="">Без клиента</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_date">Дата мероприятия *</label>
                                <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" class="form-control @error('event_date') is-invalid @enderror" required>
                                @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_time">Время</label>
                                <input type="time" name="event_time" id="event_time" value="{{ old('event_time') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="venue_name">Место проведения</label>
                                <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expected_guests">Ожидаемое количество гостей</label>
                                <input type="number" name="expected_guests" id="expected_guests" value="{{ old('expected_guests', 0) }}" min="0" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue_address">Адрес</label>
                        <textarea name="venue_address" id="venue_address" rows="2" class="form-control">{{ old('venue_address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="budget_total">Общий бюджет (₽)</label>
                        <input type="number" name="budget_total" id="budget_total" value="{{ old('budget_total', 0) }}" step="0.01" min="0" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('tenant.events.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Отмена</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
