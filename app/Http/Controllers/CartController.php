<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Get or create cart for current session
     */
    private function getCart()
    {
        $sessionId = Session::getId();
        $cart = Cart::where('session_id', $sessionId)->first();
        
        if (!$cart) {
            $cart = Cart::create([
                'session_id' => $sessionId,
                'items' => [],
                'subtotal' => 0,
                'delivery_fee' => 0,
                'total' => 0,
            ]);
        }
        
        return $cart;
    }

    /**
     * Calculate cart totals
     */
    private function calculateTotals($items)
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        // Delivery fee: free for orders over €50
        $deliveryFee = $subtotal >= 50 ? 0 : 5.00;
        $total = $subtotal + $deliveryFee;
        
        return [
            'subtotal' => round($subtotal, 2),
            'delivery_fee' => round($deliveryFee, 2),
            'total' => round($total, 2),
        ];
    }

    /**
     * Get cart contents
     */
    public function index(Request $request)
    {
        $cart = $this->getCart();
        $items = $cart->items ?? [];
        
        // Get product details for each item
        $cartItems = [];
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $cartItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'image' => $product->image,
                    'subtotal' => $product->price * $item['quantity'],
                ];
            }
        }
        
        $totals = $this->calculateTotals($items);
        
        return response()->json([
            'success' => true,
            'items' => $cartItems,
            'subtotal' => $totals['subtotal'],
            'delivery_fee' => $totals['delivery_fee'],
            'total' => $totals['total'],
            'item_count' => count($cartItems),
        ]);
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cart = $this->getCart();
        $items = $cart->items ?? [];
        
        // Check if product already in cart
        $found = false;
        foreach ($items as &$item) {
            if ($item['product_id'] == $product->id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $items[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        }
        
        $totals = $this->calculateTotals($items);
        
        $cart->update([
            'items' => $items,
            'subtotal' => $totals['subtotal'],
            'delivery_fee' => $totals['delivery_fee'],
            'total' => $totals['total'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'cart' => [
                'item_count' => count($items),
                'total' => $totals['total'],
            ],
        ]);
    }

    /**
     * Update item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart();
        $items = $cart->items ?? [];
        
        foreach ($items as &$item) {
            if ($item['product_id'] == $request->product_id) {
                $item['quantity'] = $request->quantity;
                break;
            }
        }
        
        $totals = $this->calculateTotals($items);
        
        $cart->update([
            'items' => $items,
            'subtotal' => $totals['subtotal'],
            'delivery_fee' => $totals['delivery_fee'],
            'total' => $totals['total'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cart' => [
                'item_count' => count($items),
                'total' => $totals['total'],
            ],
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = $this->getCart();
        $items = $cart->items ?? [];
        
        $items = array_filter($items, function($item) use ($request) {
            return $item['product_id'] != $request->product_id;
        });
        
        $items = array_values($items); // Re-index array
        
        $totals = $this->calculateTotals($items);
        
        $cart->update([
            'items' => $items,
            'subtotal' => $totals['subtotal'],
            'delivery_fee' => $totals['delivery_fee'],
            'total' => $totals['total'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart' => [
                'item_count' => count($items),
                'total' => $totals['total'],
            ],
        ]);
    }

    /**
     * Clear cart
     */
    public function clear(Request $request)
    {
        $cart = $this->getCart();
        $cart->update([
            'items' => [],
            'subtotal' => 0,
            'delivery_fee' => 0,
            'total' => 0,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }
}
