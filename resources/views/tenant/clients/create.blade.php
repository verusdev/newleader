@extends('layouts.app')

@section('title', 'Новый лид')
@section('page-title', 'Новый лид')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <form action="{{ route('tenant.clients.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="alert alert-light border">
                        Лид создаётся сразу вместе с брифом по мероприятию. После этапа «Заключение договора» он автоматически станет клиентом.
                    </div>

                    <h5 class="mb-3">Контакт</h5>

                    <div class="form-group">
                        <label for="name">Имя *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Телефон</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Заметки</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    <hr>
                    <h5 class="mb-3">Мероприятие</h5>

                    <div class="form-group">
                        <label for="event_title">Название мероприятия *</label>
                        <input type="text" name="event_title" id="event_title" value="{{ old('event_title') }}" class="form-control @error('event_title') is-invalid @enderror" required>
                        @error('event_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_type">Тип *</label>
                                <select name="event_type" id="event_type" class="form-control @error('event_type') is-invalid @enderror" required>
                                    <option value="">Выберите тип</option>
                                    @foreach($eventTypes as $value => $label)
                                        <option value="{{ $value }}" @selected(old('event_type') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('event_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_date">Дата *</label>
                                <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" class="form-control @error('event_date') is-invalid @enderror" required>
                                @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="event_time">Время</label>
                                <input type="time" name="event_time" id="event_time" value="{{ old('event_time') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expected_guests">Ожидаемое число гостей</label>
                                <input type="number" name="expected_guests" id="expected_guests" value="{{ old('expected_guests', 0) }}" min="0" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="venue_name">Площадка</label>
                        <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name') }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="venue_address">Адрес</label>
                        <textarea name="venue_address" id="venue_address" rows="2" class="form-control">{{ old('venue_address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="budget_total">Плановый бюджет</label>
                        <input type="number" name="budget_total" id="budget_total" value="{{ old('budget_total', 0) }}" step="0.01" min="0" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="event_description">Комментарий по мероприятию</label>
                        <textarea name="event_description" id="event_description" rows="3" class="form-control">{{ old('event_description') }}</textarea>
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
