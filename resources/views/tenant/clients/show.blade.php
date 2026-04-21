@extends('layouts.app')

@section('title', $client->name)
@section('page-title', $client->name)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Информация</h3></div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Email</dt><dd class="col-sm-8">{{ $client->email ?? '—' }}</dd>
                    <dt class="col-sm-4">Телефон</dt><dd class="col-sm-8">{{ $client->phone ?? '—' }}</dd>
                </dl>
                @if($client->notes)<hr><p>{{ $client->notes }}</p>@endif
            </div>
            <div class="card-footer">
                <a href="{{ route('tenant.clients.edit', $client) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Редактировать</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Мероприятия клиента</h3></div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead><tr><th>Название</th><th>Тип</th><th>Дата</th><th>Действия</th></tr></thead>
                    <tbody>
                        @forelse($client->events as $event)
                            <tr>
                                <td><a href="{{ route('tenant.events.show', $event) }}">{{ $event->title }}</a></td>
                                <td>{{ $event->type }}</td>
                                <td>{{ $event->event_date->format('d.m.Y') }}</td>
                                <td><a href="{{ route('tenant.events.show', $event) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Нет мероприятий</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
