<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Event;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Event $event)
    {
        $tasks = $event->tasks()->latest()->paginate(15);
        return view('tenant.tasks.index', compact('event', 'tasks'));
    }

    public function create(Event $event)
    {
        return view('tenant.tasks.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'estimated_cost' => 'nullable|numeric|min:0',
        ]);

        $event->tasks()->create($validated);
        return redirect()->route('tenant.tasks.index', $event)->with('success', 'Задача создана');
    }

    public function edit(Event $event, Task $task)
    {
        return view('tenant.tasks.edit', compact('event', 'task'));
    }

    public function update(Request $request, Event $event, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'estimated_cost' => 'nullable|numeric|min:0',
        ]);

        $task->update($validated);
        return redirect()->route('tenant.tasks.index', $event)->with('success', 'Задача обновлена');
    }

    public function destroy(Event $event, Task $task)
    {
        $task->delete();
        return redirect()->route('tenant.tasks.index', $event)->with('success', 'Задача удалена');
    }

    public function toggleStatus(Task $task)
    {
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update(['status' => $newStatus]);
        return back()->with('success', 'Статус изменён');
    }
}
