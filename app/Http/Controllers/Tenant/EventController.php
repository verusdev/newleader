<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Client;
use Illuminate\Http\Request;

class EventController extends Controller
{
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
}
