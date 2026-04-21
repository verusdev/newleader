<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Client;
use App\Models\Task;
use App\Models\BudgetItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $eventsCount = Event::count();
        $upcomingEvents = Event::where('event_date', '>=', now())->count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $budgetSpent = BudgetItem::sum('actual_amount');
        $budgetTotal = Event::sum('budget_total');

        $upcoming = Event::where('event_date', '>=', now())
            ->orderBy('event_date')
            ->limit(5)
            ->get();

        $urgentTasks = Task::where('priority', 'high')
            ->where('status', 'pending')
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        return view('tenant.dashboard', compact(
            'eventsCount', 'upcomingEvents', 'pendingTasks',
            'budgetSpent', 'budgetTotal', 'upcoming', 'urgentTasks'
        ));
    }
}
