<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\EventController;
use App\Http\Controllers\Tenant\ClientController;
use App\Http\Controllers\Tenant\GuestController;
use App\Http\Controllers\Tenant\TaskController;
use App\Http\Controllers\Tenant\BudgetController;
use App\Http\Controllers\Tenant\VendorController;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('tenant.dashboard');

    Route::resource('events', EventController::class);

    Route::resource('clients', ClientController::class);

    Route::prefix('events/{event}')->name('tenant.')->group(function () {
        Route::resource('guests', GuestController::class)->except(['index', 'show']);
        Route::get('guests', [GuestController::class, 'index'])->name('guests.index');
        Route::post('guests/{guest}/toggle', [GuestController::class, 'toggleConfirm'])->name('guests.toggle');

        Route::resource('tasks', TaskController::class)->except(['index', 'show']);
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::post('tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');

        Route::resource('budget', BudgetController::class)->except(['index', 'show']);
        Route::get('budget', [BudgetController::class, 'index'])->name('budget.index');
    });

    Route::resource('vendors', VendorController::class);
});
