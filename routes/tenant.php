<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\ProductController;
use App\Http\Controllers\Tenant\OrderController;
use App\Http\Controllers\Tenant\PaymentController;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('tenant.dashboard');

    Route::resource('products', ProductController::class);

    Route::prefix('orders')->name('tenant.orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/{order}/pay', [OrderController::class, 'pay'])->name('pay');
        Route::get('/{order}/payment/callback', [OrderController::class, 'paymentCallback'])->name('payment.callback');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
    });

    Route::post('/webhooks/yookassa', [PaymentController::class, 'webhook'])->name('webhooks.yookassa');
});
