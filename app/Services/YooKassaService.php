<?php

namespace App\Services;

use YooKassa\Client;
use YooKassa\Configuration;
use YooKassa\Helpers\Recipient;
use YooKassa\Model\Confirmation\ConfirmationRedirect;
use YooKassa\Model\PaymentMethodType;
use YooKassa\Model\PaymentMethodData;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class YooKassaService
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

    public function createPayment(Payment $paymentModel, string $description, string $returnUrl): ?array
    {
        try {
            $payment = $this->client->createPayment([
                'amount' => [
                    'value' => $paymentModel->amount,
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => $returnUrl,
                ],
                'capture' => true,
                'description' => $description,
                'metadata' => [
                    'order_id' => $paymentModel->order_id,
                    'payment_id' => $paymentModel->id,
                ],
                'payment_method_data' => [
                    'type' => PaymentMethodType::BANK_CARD,
                ],
            ]);

            $paymentModel->yookassa_payment_id = $payment->getId();
            $paymentModel->status = 'pending';
            $paymentModel->save();

            return [
                'payment_id' => $payment->getId(),
                'confirmation_url' => $payment->getConfirmation()->getConfirmationUrl(),
            ];
        } catch (\Exception $e) {
            Log::error('YooKassa create payment error: ' . $e->getMessage());
            return null;
        }
    }

    public function getPaymentInfo(string $paymentId): ?object
    {
        try {
            return $this->client->getPaymentInfo($paymentId);
        } catch (\Exception $e) {
            Log::error('YooKassa get payment info error: ' . $e->getMessage());
            return null;
        }
    }

    public function handleWebhook(array $payload): ?Payment
    {
        try {
            $paymentId = $payload['object']['id'] ?? null;
            $status = $payload['event'] ?? null;

            if (!$paymentId) {
                return null;
            }

            $paymentModel = Payment::where('yookassa_payment_id', $paymentId)->first();

            if (!$paymentModel) {
                return null;
            }

            $paymentInfo = $this->getPaymentInfo($paymentId);

            if ($paymentInfo) {
                $paymentModel->status = $paymentInfo->getPaid() ? 'succeeded' : 'failed';
                $paymentModel->response_data = json_encode($paymentInfo);
                $paymentModel->save();

                if ($paymentModel->status === 'succeeded') {
                    $paymentModel->order->payment_status = 'paid';
                    $paymentModel->order->save();
                }
            }

            return $paymentModel;
        } catch (\Exception $e) {
            Log::error('YooKassa webhook error: ' . $e->getMessage());
            return null;
        }
    }
}
