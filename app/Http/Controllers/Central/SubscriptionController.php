<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\CentralPayment;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['plan', 'tenant'])->latest()->paginate(15);
        return view('central.subscriptions.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['plan', 'tenant', 'payments']);
        return view('central.subscriptions.show', compact('subscription'));
    }

    public function markAsPaid(Subscription $subscription, SubscriptionService $subscriptionService)
    {
        $subscription->status = 'active';
        $subscription->starts_at = now();
        $subscription->ends_at = now()->addMonth();
        $subscription->save();

        if (!$subscription->tenant) {
            $subscriptionService->createTenant($subscription);
        }

        $subscription->payments()->create([
            'payment_method' => 'manual',
            'amount' => $subscription->plan->price,
            'status' => 'succeeded',
        ]);

        return redirect()->route('admin.subscriptions.show', $subscription)
            ->with('success', 'Подписка активирована');
    }

    public function cancel(Subscription $subscription)
    {
        $subscription->status = 'cancelled';
        $subscription->ends_at = now();
        $subscription->save();

        return redirect()->route('admin.subscriptions.show', $subscription)
            ->with('success', 'Подписка отменена');
    }
}
