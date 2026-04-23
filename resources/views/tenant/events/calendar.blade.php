@extends('layouts.app')

@section('title', 'Календарь мероприятий')
@section('page-title', 'Календарь мероприятий')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-calendar-week mr-2"></i>Календарный обзор</h3>
                <div>
                    <a href="{{ route('tenant.events.index') }}" class="btn btn-outline-secondary btn-sm mr-2">
                        <i class="fas fa-list mr-1"></i>Список
                    </a>
                    <a href="{{ route('tenant.events.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Новое мероприятие
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="tenant-events-calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('tenant-events-calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ru',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        buttonText: {
            today: 'Сегодня',
            month: 'Месяц',
            week: 'Неделя',
            list: 'Список'
        },
        events: '{{ route('tenant.events.calendar.feed') }}',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        eventDidMount: function(info) {
            const props = info.event.extendedProps;
            const bits = [];

            if (props.client) bits.push('Клиент: ' + props.client);
            if (props.venue) bits.push('Площадка: ' + props.venue);
            if (props.type) bits.push('Тип: ' + props.type);

            if (bits.length) {
                info.el.title = bits.join('\n');
            }
        }
    });

    calendar.render();
});
</script>
<style>
    #tenant-events-calendar .fc-toolbar-title {
        font-size: 1.2rem;
        font-weight: 600;
    }

    #tenant-events-calendar .fc-event {
        border-radius: 8px;
        padding: 2px 4px;
        font-size: 0.85rem;
        border-width: 0;
    }
</style>
@endsection
