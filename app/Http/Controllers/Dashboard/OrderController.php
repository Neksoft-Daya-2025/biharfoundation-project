<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * List orders (dashboard page)
     */
    public function index()
    {
        return view('dashboard.orders');
    }

    /**
     * Show single order
     */
    public function show(Order $order)
    {
        $order->load('items');
        return view('dashboard.order-show', ['order' => $order]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $status = $request->input('status') ?? $request->query('status') ?? $request->request->get('status');
        if (!$status || !in_array($status, ['pending', 'paid', 'processing', 'completed', 'cancelled'], true)) {
            return response()->json(['success' => false, 'message' => 'Invalid or missing status. Use: pending, paid, processing, completed, cancelled.'], 422);
        }
        $order->update(['status' => $status]);
        return response()->json(['success' => true, 'message' => 'Order status updated.']);
    }

    /**
     * API: list orders with filters and pagination
     */
    public function api(Request $request)
    {
        $query = Order::withCount('items')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'like', "%{$s}%")
                    ->orWhere('customer_name', 'like', "%{$s}%")
                    ->orWhere('customer_email', 'like', "%{$s}%");
            });
        }

        $perPage = max(5, min(50, (int) $request->get('per_page', 15)));
        $orders = $query->paginate($perPage);

        $items = $orders->getCollection()->map(function ($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'customer_email' => $order->customer_email,
                'customer_phone' => $order->customer_phone,
                'order_type' => $order->order_type,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'total' => (float) $order->total,
                'items_count' => $order->items_count,
                'created_at' => $order->created_at->format('Y-m-d H:i'),
                'created_at_human' => $order->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $items,
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ]);
    }
}
