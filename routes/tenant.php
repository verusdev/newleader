<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use App\Http\Middleware\SetTenantRouteParameter;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\EventController;
use App\Http\Controllers\Tenant\ClientController;
use App\Http\Controllers\Tenant\GuestController;
use App\Http\Controllers\Tenant\TaskController;
use App\Http\Controllers\Tenant\BudgetController;
use App\Http\Controllers\Tenant\VendorController;

Route::middleware([
    'web',
    InitializeTenancyByPath::class,
    SetTenantRouteParameter::class,
])->prefix('tenant/{tenant}')->name('tenant.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('events-calendar', [EventController::class, 'calendar'])->name('events.calendar');
    Route::get('events-calendar/feed', [EventController::class, 'calendarFeed'])->name('events.calendar.feed');
    Route::resource('events', EventController::class);

    Route::resource('clients', ClientController::class);
    Route::post('clients/{client}/timeline/{step}/toggle', [ClientController::class, 'toggleTimelineStep'])
        ->name('clients.timeline.toggle');

    Route::prefix('events/{event}')->group(function () {
        Route::resource('guests', GuestController::class)->except(['index', 'show']);
        Route::get('guests', [GuestController::class, 'index'])->name('guests.index');
        Route::post('guests/{guest}/toggle', [GuestController::class, 'toggleConfirm'])->name('guests.toggle');

        Route::resource('tasks', TaskController::class)->except(['index', 'show']);
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');

        Route::resource('budget', BudgetController::class)
            ->parameters(['budget' => 'budgetItem'])
            ->except(['index', 'show']);
        Route::get('budget', [BudgetController::class, 'index'])->name('budget.index');
    });

    Route::resource('vendors', VendorController::class);
});
