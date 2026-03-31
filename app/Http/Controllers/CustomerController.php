<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Show customers dashboard page
     */
    public function index(Request $request)
    {
        return view('dashboard.customers');
    }

    /**
     * Get all customers API (combined from reservations and orders)
     * Note: Requires Reservation and Order models
     */
    public function getAll(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $customers = $this->getAllCustomers();

        return response()->json([
            'success' => true,
            'data' => $customers,
            'total' => count($customers)
        ]);
    }

    /**
     * Export customers to CSV
     */
    public function exportCSV(Request $request)
    {
        // Auth check (session only)
        if (!Session::has('admin_logged_in')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $customers = $this->getAllCustomers();

        $filename = 'malbis_customers_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 (helps Excel display special characters correctly)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // CSV Headers
            fputcsv($file, [
                'Email',
                'Name',
                'Phone',
                'Customer Type',
                'Reservation Count',
                'Order Count',
                'Total Orders Value',
                'First Reservation Date',
                'Last Reservation Date',
                'First Order Date',
                'Last Order Date',
                'Address',
                'Status',
                'Last Activity'
            ]);

            // CSV Data
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer['email'],
                    $customer['name'],
                    $customer['phone'] ?? '',
                    $customer['customer_type'],
                    $customer['reservation_count'] ?? 0,
                    $customer['order_count'] ?? 0,
                    number_format($customer['total_orders_value'] ?? 0, 2),
                    $customer['first_reservation_date'] ?? '',
                    $customer['last_reservation_date'] ?? '',
                    $customer['first_order_date'] ?? '',
                    $customer['last_order_date'] ?? '',
                    $customer['address'] ?? '',
                    $customer['status'] ?? '',
                    $customer['last_activity'] ?? ''
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Get all customers from reservations and orders, deduplicated by email
     * Note: Requires Reservation and Order models
     */
    private function getAllCustomers()
    {
        $customersMap = [];

        // Get reservations if model exists
        if (class_exists('App\Models\Reservation')) {
            $reservations = \App\Models\Reservation::select('name', 'email', 'phone', 'date', 'status', 'created_at')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($reservations as $reservation) {
            $email = strtolower(trim($reservation->email));
            
            if (empty($email)) continue;

            if (!isset($customersMap[$email])) {
                $customersMap[$email] = [
                    'email' => $reservation->email,
                    'name' => $reservation->name,
                    'phone' => $reservation->phone,
                    'customer_type' => 'Reservation',
                    'reservation_count' => 0,
                    'order_count' => 0,
                    'total_orders_value' => 0,
                    'first_reservation_date' => null,
                    'last_reservation_date' => null,
                    'first_order_date' => null,
                    'last_order_date' => null,
                    'address' => null,
                    'status' => $reservation->status,
                    'last_activity' => $reservation->created_at ? $reservation->created_at->format('Y-m-d H:i:s') : null,
                ];
            }

            // Update reservation data
            $customersMap[$email]['reservation_count']++;
            
            $reservationDateStr = $reservation->date ? (is_string($reservation->date) ? $reservation->date : $reservation->date->format('Y-m-d')) : null;
            
            if ($reservationDateStr) {
                if (!$customersMap[$email]['first_reservation_date'] || 
                    $reservationDateStr < $customersMap[$email]['first_reservation_date']) {
                    $customersMap[$email]['first_reservation_date'] = $reservationDateStr;
                }
                
                if (!$customersMap[$email]['last_reservation_date'] || 
                    $reservationDateStr > $customersMap[$email]['last_reservation_date']) {
                    $customersMap[$email]['last_reservation_date'] = $reservationDateStr;
                }
            }

            // Update last activity
            if ($reservation->created_at && 
                (!$customersMap[$email]['last_activity'] || 
                 $reservation->created_at->gt(\Carbon\Carbon::parse($customersMap[$email]['last_activity'])))) {
                $customersMap[$email]['last_activity'] = $reservation->created_at->format('Y-m-d H:i:s');
            }

            // Update customer type if needed
            if ($customersMap[$email]['order_count'] > 0) {
                $customersMap[$email]['customer_type'] = 'Both';
            }
        }
        }

        // Get all orders (Order model always exists in this app)
        if (!class_exists('App\Models\Order')) {
            return array_values($customersMap);
        }
        $orders = \App\Models\Order::select('customer_name', 'customer_email', 'customer_phone', 'customer_address',
                                'total', 'status', 'created_at')
            ->whereNotNull('customer_email')
            ->where('customer_email', '!=', '')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($orders as $order) {
            $email = strtolower(trim($order->customer_email));
            
            if (empty($email)) continue;

            if (!isset($customersMap[$email])) {
                $customersMap[$email] = [
                    'email' => $order->customer_email,
                    'name' => $order->customer_name,
                    'phone' => $order->customer_phone,
                    'customer_type' => 'Order',
                    'reservation_count' => 0,
                    'order_count' => 0,
                    'total_orders_value' => 0,
                    'first_reservation_date' => null,
                    'last_reservation_date' => null,
                    'first_order_date' => null,
                    'last_order_date' => null,
                    'address' => $order->customer_address,
                    'status' => $order->status,
                    'last_activity' => $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : null,
                ];
            }

            // Update order data
            $customersMap[$email]['order_count']++;
            $customersMap[$email]['total_orders_value'] += floatval($order->total);
            
            $orderDate = $order->created_at ? $order->created_at->format('Y-m-d') : null;
            
            if ($orderDate) {
                if (!$customersMap[$email]['first_order_date'] || 
                    $orderDate < $customersMap[$email]['first_order_date']) {
                    $customersMap[$email]['first_order_date'] = $orderDate;
                }
                
                if (!$customersMap[$email]['last_order_date'] || 
                    $orderDate > $customersMap[$email]['last_order_date']) {
                    $customersMap[$email]['last_order_date'] = $orderDate;
                }
            }

            // Update last activity
            if ($order->created_at && 
                (!$customersMap[$email]['last_activity'] || 
                 $order->created_at->gt(\Carbon\Carbon::parse($customersMap[$email]['last_activity'])))) {
                $customersMap[$email]['last_activity'] = $order->created_at->format('Y-m-d H:i:s');
            }

            // Update customer type if needed
            if ($customersMap[$email]['reservation_count'] > 0) {
                $customersMap[$email]['customer_type'] = 'Both';
            }

            // Update address if order has one and reservation doesn't
            if ($order->customer_address && !$customersMap[$email]['address']) {
                $customersMap[$email]['address'] = $order->customer_address;
            }

            // Update name/phone if order has more complete data
            if (!$customersMap[$email]['name'] && $order->customer_name) {
                $customersMap[$email]['name'] = $order->customer_name;
            }
            if (!$customersMap[$email]['phone'] && $order->customer_phone) {
                $customersMap[$email]['phone'] = $order->customer_phone;
            }
        }

        // Convert to array and sort by last activity (most recent first)
        $customers = array_values($customersMap);
        usort($customers, function($a, $b) {
            $dateA = $a['last_activity'] ? \Carbon\Carbon::parse($a['last_activity']) : \Carbon\Carbon::minValue();
            $dateB = $b['last_activity'] ? \Carbon\Carbon::parse($b['last_activity']) : \Carbon\Carbon::minValue();
            return $dateB->gt($dateA) ? 1 : -1;
        });

        return $customers;
    }
}
