<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $sessionId = Session::getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        
        if (!$cart || empty($cart->items)) {
            return redirect()->route('theme.preview')->with('error', 'Your cart is empty.');
        }
        
        return view('checkout', [
            'cart' => $cart,
        ]);
    }

    /**
     * Create order
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'order_type' => 'required|in:delivery,pickup',
            'delivery_address' => 'required_if:order_type,delivery|nullable|string',
            'delivery_time' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $sessionId = Session::getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        
        if (!$cart || empty($cart->items)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.',
            ], 400);
        }

        // Create order
        $order = Order::create([
            'session_id' => $sessionId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->delivery_address,
            'order_type' => $request->order_type,
            'delivery_address' => $request->delivery_address,
            'delivery_time' => $request->delivery_time ? now()->parse($request->delivery_time) : null,
            'notes' => $request->notes,
            'subtotal' => $cart->subtotal,
            'delivery_fee' => $cart->delivery_fee,
            'total' => $cart->total,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Create order items
        foreach ($cart->items as $item) {
            $product = Product::find($item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id ?? null,
                'product_name' => $product->name ?? 'Unknown Product',
                'product_description' => $product->description ?? null,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        // Clear cart
        $cart->update([
            'items' => [],
            'subtotal' => 0,
            'delivery_fee' => 0,
            'total' => 0,
        ]);

        // Notify admin of new order
        Notification::createForAdmin('order', 'New order #' . $order->order_number, $order->customer_name . ' placed an order (' . format_money((float) $order->total) . ').', [
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'link' => route('dashboard.orders.show', $order),
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'message' => 'Order created successfully',
        ]);
    }

    /**
     * Show order confirmation
     */
    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        
        return view('order-confirmation', [
            'order' => $order,
        ]);
    }
}
