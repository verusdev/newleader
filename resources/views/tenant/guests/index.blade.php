@extends('layouts.app')

@section('title', 'Гости: ' . $event->title)
@section('page-title', 'Гости мероприятия: ' . $event->title)

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('tenant.events.show', $event) }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Назад к мероприятию</a>
        <a href="{{ route('tenant.guests.create', $event) }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i>Добавить гостя</a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Список гостей ({{ $guests->total() }})</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Категория</th>
                            <th>RSVP</th>
                            <th>+1</th>
                            <th>Персональная ссылка</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guests as $guest)
                            @php
                                $guestInvitationUrl = route('invitation.show', [
                                    'tenant' => tenant('id'),
                                    'eventToken' => $event->invitation_token,
                                    'guestToken' => $guest->invitation_token,
                                ]);
                            @endphp
                            <tr>
                                <td>{{ $guest->name }}</td>
                                <td>{{ $guest->email ?: '-' }}</td>
                                <td>{{ $guest->phone ?: '-' }}</td>
                                <td>{{ $guest->category ?: '-' }}</td>
                                <td>
                                    @if($guest->rsvp_status === 'confirmed')
                                        <span class="badge badge-success">Будет</span>
                                    @elseif($guest->rsvp_status === 'declined')
                                        <span class="badge badge-danger">Не сможет</span>
                                    @elseif($guest->confirmed)
                                        <span class="badge badge-success">Подтверждён</span>
                                    @else
                                        <span class="badge badge-secondary">Нет ответа</span>
                                    @endif
                                </td>
                                <td>{{ $guest->plus_one }}</td>
                                <td style="min-width: 240px;">
                                    <input type="text" class="form-control form-control-sm" value="{{ $guestInvitationUrl }}" readonly onclick="this.select();">
                                </td>
                                <td>
                                    <a href="{{ $guestInvitationUrl }}" target="_blank" class="btn btn-sm btn-info"><i class="fas fa-external-link-alt"></i></a>
                                    <a href="{{ route('tenant.guests.edit', [$event, $guest]) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('tenant.guests.destroy', [$event, $guest]) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить гостя?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Гости не найдены</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $guests->links() }}</div>
        </div>
    </div>
</div>
@endsection
