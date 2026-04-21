<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\YooKassaService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('payments')->latest()->paginate(15);
        return view('tenant.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('payments');
        return view('tenant.orders.show', compact('order'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('tenant.orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $items = [];
        $totalAmount = 0;

        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $items[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $item['quantity'],
                'subtotal' => $product->price * $item['quantity'],
            ];
            $totalAmount += $product->price * $item['quantity'];
        }

        $order = Order::create([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'items' => $items,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('tenant.orders.show', $order)
            ->with('success', 'Заказ успешно создан');
    }

    public function pay(Order $order, YooKassaService $yooKassa)
    {
        $payment = $order->payments()->create([
            'payment_method' => 'yookassa',
            'amount' => $order->total_amount,
            'status' => 'pending',
        ]);

        $returnUrl = route('tenant.orders.payment.callback', $order);

        $result = $yooKassa->createPayment(
            $payment,
            "Оплата заказа #{$order->id}",
            $returnUrl
        );

        if (!$result) {
            return redirect()->route('tenant.orders.show', $order)
                ->with('error', 'Не удалось создать платёж');
        }

        return redirect($result['confirmation_url']);
    }

    public function paymentCallback(Order $order, Request $request, YooKassaService $yooKassa)
    {
        $paymentId = $request->get('payment_id');

        if ($paymentId) {
            $paymentInfo = $yooKassa->getPaymentInfo($paymentId);
            if ($paymentInfo && $paymentInfo->getPaid()) {
                $payment = $order->payments()->where('yookassa_payment_id', $paymentId)->first();
                if ($payment) {
                    $payment->status = 'succeeded';
                    $payment->save();
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                    $order->save();
                }
            }
        }

        return redirect()->route('tenant.orders.show', $order)
            ->with('success', 'Статус оплаты обновлён');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('tenant.orders.show', $order)
            ->with('success', 'Статус заказа обновлёn');
    }
}
