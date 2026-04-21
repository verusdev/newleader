<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BudgetItem;
use App\Models\Vendor;
use App\Models\Event;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Event $event)
    {
        $items = $event->budgetItems()->with('vendor')->latest()->paginate(15);
        $totalEstimated = $event->budgetItems()->sum('estimated_amount');
        $totalActual = $event->budgetItems()->sum('actual_amount');
        return view('tenant.budget.index', compact('event', 'items', 'totalEstimated', 'totalActual'));
    }

    public function create(Event $event)
    {
        $vendors = Vendor::all();
        return view('tenant.budget.create', compact('event', 'vendors'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'estimated_amount' => 'nullable|numeric|min:0',
            'actual_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,overdue',
            'due_date' => 'nullable|date',
            'vendor_id' => 'nullable|exists:vendors,id',
            'notes' => 'nullable|string',
        ]);

        $event->budgetItems()->create($validated);
        return redirect()->route('tenant.budget.index', $event)->with('success', 'Статья бюджета добавлена');
    }

    public function edit(Event $event, BudgetItem $budgetItem)
    {
        $vendors = Vendor::all();
        return view('tenant.budget.edit', compact('event', 'budgetItem', 'vendors'));
    }

    public function update(Request $request, Event $event, BudgetItem $budgetItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'estimated_amount' => 'nullable|numeric|min:0',
            'actual_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,paid,overdue',
            'due_date' => 'nullable|date',
            'vendor_id' => 'nullable|exists:vendors,id',
            'notes' => 'nullable|string',
        ]);

        $budgetItem->update($validated);
        return redirect()->route('tenant.budget.index', $event)->with('success', 'Статья обновлена');
    }

    public function destroy(Event $event, BudgetItem $budgetItem)
    {
        $budgetItem->delete();
        return redirect()->route('tenant.budget.index', $event)->with('success', 'Статья удалена');
    }
}
