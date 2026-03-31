<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;

class PaymentController extends Controller
{
    /**
     * Create Mollie payment
     */
    public function create(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Order already paid',
            ], 400);
        }

        try {
            $payment = Mollie::api()->payments->create([
                'amount' => [
                    'currency' => 'EUR',
                    'value' => number_format($order->total, 2, '.', ''),
                ],
                'description' => "Order {$order->order_number} - Malbi's Kitchen",
                'redirectUrl' => route('payment.return', ['order' => $order->id]),
                'webhookUrl' => route('payment.webhook'),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ],
            ]);

            $order->update([
                'mollie_payment_id' => $payment->id,
                'payment_method' => 'mollie',
            ]);

            return response()->json([
                'success' => true,
                'payment_url' => $payment->getCheckoutUrl(),
            ]);
        } catch (\Exception $e) {
            Log::error('Mollie payment creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Payment creation failed. Please try again.',
            ], 500);
        }
    }

    /**
     * Handle payment return
     */
    public function return(Request $request, $order)
    {
        $order = Order::findOrFail($order);
        
        if (!$order->mollie_payment_id) {
            return redirect()->to('/')->with('error', 'Payment not found.');
        }

        try {
            $payment = Mollie::api()->payments->get($order->mollie_payment_id);
            
            if ($payment->isPaid()) {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'paid',
                ]);
                
                return redirect()->to('/')->with('success', 'Payment successful! Order #' . $order->order_number);
            } elseif ($payment->isPending()) {
                return redirect()->to('/')->with('info', 'Payment is pending. Order #' . $order->order_number);
            } else {
                $order->update([
                    'payment_status' => 'failed',
                ]);
                
                return redirect()->to('/')->with('error', 'Payment failed. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Mollie payment check failed: ' . $e->getMessage());
            
            return redirect()->to('/')->with('error', 'Unable to verify payment. Please contact support.');
        }
    }

    /**
     * Handle payment webhook
     */
    public function webhook(Request $request)
    {
        try {
            $paymentId = $request->input('id');
            $payment = Mollie::api()->payments->get($paymentId);
            
            $order = Order::where('mollie_payment_id', $paymentId)->first();
            
            if (!$order) {
                Log::warning("Order not found for payment: {$paymentId}");
                return response()->json(['error' => 'Order not found'], 404);
            }
            
            if ($payment->isPaid() && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'paid',
                ]);
                
                // Here you could send order confirmation email
                Log::info("Order {$order->order_number} payment confirmed via webhook");
            } elseif ($payment->isCancelled() || $payment->isExpired() || $payment->isFailed()) {
                $order->update([
                    'payment_status' => 'failed',
                ]);
                
                Log::info("Order {$order->order_number} payment failed via webhook");
            }
            
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Mollie webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }
}
