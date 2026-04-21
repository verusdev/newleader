<?php

namespace App\Http\Controllers;

use App\Models\CentralSubscriptionPlan;
use App\Models\Subscription;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $plans = CentralSubscriptionPlan::where('is_active', true)->get();
        return view('landing.index', compact('plans'));
    }

    public function checkout(CentralSubscriptionPlan $plan)
    {
        return view('landing.checkout', compact('plan'));
    }

    public function subscribe(Request $request, SubscriptionService $subscriptionService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tenant_domain' => 'required|string|max:255|unique:domains,domain',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = CentralSubscriptionPlan::find($validated['subscription_plan_id']);

        $subscription = Subscription::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'tenant_domain' => $validated['tenant_domain'],
            'subscription_plan_id' => $plan->id,
            'status' => 'pending',
        ]);

        $returnUrl = route('landing.subscribe.callback', ['subscription' => $subscription]);

        $result = $subscriptionService->createSubscriptionPayment($subscription, $returnUrl);

        if (!$result) {
            return redirect()->route('landing.checkout', $plan)
                ->with('error', 'Не удалось создать платёж');
        }

        session(['pending_subscription_id' => $subscription->id]);

        return redirect($result['confirmation_url']);
    }

    public function subscribeCallback(Subscription $subscription, Request $request, SubscriptionService $subscriptionService)
    {
        $paymentId = $request->get('payment_id');

        if ($paymentId) {
            $result = $subscriptionService->handlePaymentCallback($paymentId);

            if ($result) {
                session()->forget('pending_subscription_id');
                return view('landing.success', ['subscription' => $subscription]);
            }
        }

        return view('landing.failure', ['subscription' => $subscription]);
    }
}
