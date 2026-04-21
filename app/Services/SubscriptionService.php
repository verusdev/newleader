<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\CentralPayment;
use App\Models\CentralSubscriptionPlan;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;
use YooKassa\Client;
use YooKassa\Configuration;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    protected Client $client;

    public function __construct()
    {
        $shopId = config('services.yookassa.shop_id');
        $secretKey = config('services.yookassa.secret_key');

        Configuration::configure(
            shopId: $shopId,
            secretKey: $secretKey
        );

        $this->client = new Client();
    }

    public function createSubscriptionPayment(Subscription $subscription, string $returnUrl): ?array
    {
        try {
            $payment = $this->client->createPayment([
                'amount' => [
                    'value' => $subscription->plan->price,
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => $returnUrl,
                ],
                'capture' => true,
                'description' => "Оплата подписки '{$subscription->plan->name}' для {$subscription->tenant_domain}",
                'metadata' => [
                    'subscription_id' => $subscription->id,
                    'payment_type' => 'subscription',
                ],
                'payment_method_data' => [
                    'type' => 'bank_card',
                ],
            ]);

            $centralPayment = $subscription->payments()->create([
                'payment_method' => 'yookassa',
                'yookassa_payment_id' => $payment->getId(),
                'amount' => $subscription->plan->price,
                'status' => 'pending',
            ]);

            return [
                'payment_id' => $payment->getId(),
                'confirmation_url' => $payment->getConfirmation()->getConfirmationUrl(),
            ];
        } catch (\Exception $e) {
            Log::error('Subscription payment error: ' . $e->getMessage());
            return null;
        }
    }

    public function getPaymentInfo(string $paymentId): ?object
    {
        try {
            return $this->client->getPaymentInfo($paymentId);
        } catch (\Exception $e) {
            Log::error('Get payment info error: ' . $e->getMessage());
            return null;
        }
    }

    public function handlePaymentCallback(string $paymentId): ?Subscription
    {
        try {
            $paymentInfo = $this->getPaymentInfo($paymentId);

            if (!$paymentInfo || !$paymentInfo->getPaid()) {
                return null;
            }

            $metadata = $paymentInfo->getMetadata();
            $subscriptionId = $metadata['subscription_id'] ?? null;

            if (!$subscriptionId) {
                return null;
            }

            $subscription = Subscription::find($subscriptionId);
            if (!$subscription) {
                return null;
            }

            $centralPayment = CentralPayment::where('yookassa_payment_id', $paymentId)->first();
            if ($centralPayment) {
                $centralPayment->status = 'succeeded';
                $centralPayment->response_data = json_encode($paymentInfo);
                $centralPayment->save();
            }

            $subscription->status = 'active';
            $subscription->starts_at = now();
            $subscription->ends_at = now()->addMonth();
            $subscription->yookassa_subscription_id = $paymentId;
            $subscription->save();

            $this->createTenant($subscription);

            return $subscription;
        } catch (\Exception $e) {
            Log::error('Payment callback error: ' . $e->getMessage());
            return null;
        }
    }

    protected function createTenant(Subscription $subscription): Tenant
    {
        $tenant = Tenant::create([
            'name' => $subscription->name,
            'email' => $subscription->email,
        ]);

        $tenant->domains()->create([
            'domain' => $subscription->tenant_domain,
        ]);

        $subscription->tenant_id = $tenant->id;
        $subscription->save();

        return $tenant;
    }

    public function handleWebhook(array $payload): ?CentralPayment
    {
        try {
            $paymentId = $payload['object']['id'] ?? null;

            if (!$paymentId) {
                return null;
            }

            $centralPayment = CentralPayment::where('yookassa_payment_id', $paymentId)->first();

            if (!$centralPayment) {
                return null;
            }

            $paymentInfo = $this->getPaymentInfo($paymentId);

            if ($paymentInfo) {
                $centralPayment->status = $paymentInfo->getPaid() ? 'succeeded' : 'failed';
                $centralPayment->response_data = json_encode($paymentInfo);
                $centralPayment->save();

                if ($centralPayment->status === 'succeeded' && $centralPayment->subscription->status === 'pending') {
                    $this->handlePaymentCallback($paymentId);
                }
            }

            return $centralPayment;
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return null;
        }
    }
}
