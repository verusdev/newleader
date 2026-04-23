@extends('layouts.app')

@section('title', 'Лиды и клиенты')
@section('page-title', 'Лиды и клиенты')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-users mr-2"></i>Воронка клиентов</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.clients.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Новый лид
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Статус</th>
                            <th>Текущий этап</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Мероприятий</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            @php
                                $currentStep = $client->timelineSteps->firstWhere('code', $client->pipeline_stage);
                                $leadEvent = $client->events->sortByDesc('event_date')->first();
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('tenant.clients.show', $client) }}">{{ $client->name }}</a>
                                    @if($leadEvent)
                                        <div class="text-muted small mt-1">{{ $leadEvent->title }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $client->type === 'client' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $client->typeLabel() }}
                                    </span>
                                </td>
                                <td>{{ $currentStep?->title ?? 'Сделка завершена' }}</td>
                                <td>{{ $client->email ?: '—' }}</td>
                                <td>{{ $client->phone ?: '—' }}</td>
                                <td><span class="badge badge-info">{{ $client->events_count }}</span></td>
                                <td>
                                    <a href="{{ route('tenant.clients.show', $client) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('tenant.clients.edit', $client) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('tenant.clients.destroy', $client) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить контакт?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Лиды и клиенты пока не добавлены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $clients->links() }}</div>
        </div>
    </div>
</div>
@endsection
