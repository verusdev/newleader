<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\YooKassaService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function webhook(Request $request, YooKassaService $yooKassa)
    {
        $payload = $request->all();

        $payment = $yooKassa->handleWebhook($payload);

        if ($payment) {
            return response('OK', 200);
        }

        return response('Not Found', 404);
    }
}
