<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Event;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index(Event $event)
    {
        $guests = $event->guests()->latest()->paginate(15);
        return view('tenant.guests.index', compact('event', 'guests'));
    }

    public function create(Event $event)
    {
        return view('tenant.guests.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:100',
            'confirmed' => 'boolean',
            'plus_one' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $event->guests()->create($validated);
        return redirect()->route('tenant.guests.index', $event)->with('success', 'Гость добавлен');
    }

    public function edit(Event $event, Guest $guest)
    {
        return view('tenant.guests.edit', compact('event', 'guest'));
    }

    public function update(Request $request, Event $event, Guest $guest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:100',
            'confirmed' => 'boolean',
            'plus_one' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $guest->update($validated);
        return redirect()->route('tenant.guests.index', $event)->with('success', 'Гость обновлён');
    }

    public function destroy(Event $event, Guest $guest)
    {
        $guest->delete();
        return redirect()->route('tenant.guests.index', $event)->with('success', 'Гость удалён');
    }

    public function toggleConfirm(Guest $guest)
    {
        $guest->update(['confirmed' => !$guest->confirmed]);
        return back()->with('success', 'Статус подтверждён');
    }
}
