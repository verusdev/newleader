<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('events')->latest()->paginate(15);
        return view('tenant.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('tenant.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        Client::create($validated);
        return redirect()->route('tenant.clients.index')->with('success', 'Клиент создан');
    }

    public function show(Client $client)
    {
        $client->load('events');
        return view('tenant.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('tenant.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);
        return redirect()->route('tenant.clients.index')->with('success', 'Клиент обновлёn');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('tenant.clients.index')->with('success', 'Клиент удалён');
    }
}
