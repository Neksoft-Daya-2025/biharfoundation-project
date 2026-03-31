<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Dashboard home with real stats
     */
    public function index()
    {
        $visitorsLast30 = Visitor::where('visited_at', '>=', now()->subDays(30))->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::whereIn('status', ['pending'])->count();
        $revenueThisMonth = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $productsCount = Product::count();

        return view('dashboard', [
            'visitors_last_30' => $visitorsLast30,
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'revenue_this_month' => $revenueThisMonth,
            'products_count' => $productsCount,
        ]);
    }
}
