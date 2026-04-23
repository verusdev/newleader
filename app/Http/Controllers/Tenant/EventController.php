<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function calendar()
    {
        return view('tenant.events.calendar');
    }

    public function calendarFeed()
    {
        $events = Event::with('client')
            ->orderBy('event_date')
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => trim($event->event_date->format('Y-m-d') . ' ' . ($event->event_time ?? '00:00:00')),
                    'end' => trim($event->event_date->format('Y-m-d') . ' ' . ($event->event_time ?? '23:59:59')),
                    'url' => route('tenant.events.show', $event),
                    'backgroundColor' => $this->statusColor($event->status),
                    'borderColor' => $this->statusColor($event->status),
                    'extendedProps' => [
                        'client' => $event->client?->name,
                        'status' => $event->status,
                        'type' => $event->type,
                        'venue' => $event->venue_name,
                    ],
                ];
            });

        return response()->json($events);
    }

    public function index()
    {
        $events = Event::with('client')->latest()->paginate(15);

        return view('tenant.events.index', compact('events'));
    }

    public function create()
    {
        $clients = Client::all();
        $types = ['wedding', 'birthday', 'graduation', 'corporate', 'anniversary', 'other'];

        return view('tenant.events.create', compact('clients', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:wedding,birthday,graduation,corporate,anniversary,other',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'expected_guests' => 'nullable|integer|min:0',
            'budget_total' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Event::create($validated);

        return redirect()->route('tenant.events.index')->with('success', 'Мероприятие создано');
    }

    public function show(Event $event)
    {
        $event->load(['client', 'guests', 'tasks', 'budgetItems.vendor']);

        return view('tenant.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $clients = Client::all();
        $types = ['wedding', 'birthday', 'graduation', 'corporate', 'anniversary', 'other'];

        return view('tenant.events.edit', compact('event', 'clients', 'types'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:wedding,birthday,graduation,corporate,anniversary,other',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'expected_guests' => 'nullable|integer|min:0',
            'budget_total' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,confirmed,completed,cancelled',
        ]);

        $event->update($validated);

        return redirect()->route('tenant.events.show', $event)->with('success', 'Мероприятие обновлено');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('tenant.events.index')->with('success', 'Мероприятие удалено');
    }

    private function statusColor(string $status): string
    {
        return match ($status) {
            'confirmed' => '#28a745',
            'completed' => '#17a2b8',
            'cancelled' => '#dc3545',
            default => '#ffc107',
        };
    }
}
