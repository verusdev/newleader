<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\Tenant\PaymentController as TenantPaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing.index');

Route::prefix('landing')->name('landing.')->group(function () {
    Route::get('/checkout/{plan}', [LandingController::class, 'checkout'])->name('checkout');
    Route::post('/subscribe', [LandingController::class, 'subscribe'])->name('subscribe');
    Route::get('/subscribe/callback/{subscription}', [LandingController::class, 'subscribeCallback'])->name('subscribe.callback');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');
});

Route::post('/webhooks/yookassa', [TenantPaymentController::class, 'webhook'])->name('webhooks.yookassa');
