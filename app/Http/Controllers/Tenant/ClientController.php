<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientTimelineStep;
use App\Models\Event;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('events')
            ->with(['timelineSteps', 'events'])
            ->latest()
            ->paginate(15);

        return view('tenant.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('tenant.clients.create', [
            'eventTypes' => $this->eventTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'event_title' => 'required|string|max:255',
            'event_type' => 'required|in:' . implode(',', array_keys($this->eventTypes())),
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'expected_guests' => 'nullable|integer|min:0',
            'budget_total' => 'nullable|numeric|min:0',
            'event_description' => 'nullable|string',
        ]);

        $client = Client::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);
        $client->ensureTimelineSteps();
        $client->refreshPipelineState();

        $client->events()->create([
            'title' => $validated['event_title'],
            'type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'] ?? null,
            'venue_name' => $validated['venue_name'] ?? null,
            'venue_address' => $validated['venue_address'] ?? null,
            'expected_guests' => $validated['expected_guests'] ?? 0,
            'budget_total' => $validated['budget_total'] ?? 0,
            'description' => $validated['event_description'] ?? null,
            'status' => 'planning',
        ]);

        return redirect()->route('tenant.clients.show', $client)->with('success', 'Лид и мероприятие созданы');
    }

    public function show(Client $client)
    {
        $client->load(['events', 'timelineSteps']);

        return view('tenant.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $client->load('timelineSteps');

        return view('tenant.clients.edit', [
            'client' => $client,
            'primaryEvent' => $client->events()->latest('event_date')->first(),
            'eventTypes' => $this->eventTypes(),
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'event_title' => 'nullable|string|max:255',
            'event_type' => 'nullable|in:' . implode(',', array_keys($this->eventTypes())),
            'event_date' => 'nullable|date',
            'event_time' => 'nullable',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string',
            'expected_guests' => 'nullable|integer|min:0',
            'budget_total' => 'nullable|numeric|min:0',
            'event_description' => 'nullable|string',
        ]);

        $client->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);
        $client->ensureTimelineSteps();
        $client->refreshPipelineState();

        $primaryEvent = $client->events()->latest('event_date')->first();

        if ($primaryEvent && ($validated['event_title'] ?? null)) {
            $primaryEvent->update([
                'title' => $validated['event_title'],
                'type' => $validated['event_type'],
                'event_date' => $validated['event_date'],
                'event_time' => $validated['event_time'] ?? null,
                'venue_name' => $validated['venue_name'] ?? null,
                'venue_address' => $validated['venue_address'] ?? null,
                'expected_guests' => $validated['expected_guests'] ?? 0,
                'budget_total' => $validated['budget_total'] ?? 0,
                'description' => $validated['event_description'] ?? null,
            ]);
        }

        return redirect()->route('tenant.clients.index')->with('success', 'Карточка обновлена');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('tenant.clients.index')->with('success', 'Контакт удалён');
    }

    public function toggleTimelineStep(Client $client, ClientTimelineStep $step)
    {
        abort_unless($step->client_id === $client->id, 404);

        $step->update([
            'completed_at' => $step->completed_at ? null : now(),
        ]);

        $client->refreshPipelineState();

        return redirect()->route('tenant.clients.show', $client)
            ->with('success', 'Этап обновлён');
    }

    public function updateTimelineStepNotes(Request $request, Client $client, ClientTimelineStep $step)
    {
        abort_unless($step->client_id === $client->id, 404);

        $validated = $request->validate([
            'notes' => 'nullable|string|max:5000',
        ]);

        $step->update([
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('tenant.clients.show', $client)
            ->with('success', 'Примечание к этапу сохранено');
    }

    private function eventTypes(): array
    {
        return [
            'wedding' => 'Свадьба',
            'birthday' => 'День рождения',
            'graduation' => 'Выпускной',
            'corporate' => 'Корпоратив',
            'anniversary' => 'Юбилей',
            'other' => 'Другое',
        ];
    }
}
