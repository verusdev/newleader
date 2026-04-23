<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicHostLandingController;
use App\Http\Controllers\Central\TenantController;
use App\Http\Controllers\Central\SubscriptionController;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/hosts/{tenant}', [PublicHostLandingController::class, 'show'])->name('hosts.show');

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
    Route::patch('/tenants/{tenant}/landing', [TenantController::class, 'updateLanding'])->name('tenants.landing.update');
    Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');

    Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])->name('subscriptions.show');
    Route::post('/subscriptions/{subscription}/mark-as-paid', [SubscriptionController::class, 'markAsPaid'])->name('subscriptions.mark-as-paid');
    Route::post('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
});

Route::post('/webhooks/yookassa', function () {
    $service = new SubscriptionService();
    $service->handleWebhook(request()->all());
    return response('OK', 200);
})->name('webhooks.yookassa');
