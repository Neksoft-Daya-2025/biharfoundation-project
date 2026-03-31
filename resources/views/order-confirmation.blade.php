@extends('layouts.app')

@section('title', 'Order Confirmation | Malbi\'s Kitchen')

@section('content')
<div class="min-h-screen py-20" style="padding-top: 180px;">
  <div class="container max-w-2xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
      @if(session('success'))
        <div class="mb-6">
          <svg class="w-16 h-16 mx-auto text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
          <p class="text-gray-600">Thank you for your order. We'll prepare it right away!</p>
        </div>
      @elseif(session('info'))
        <div class="mb-6">
          <svg class="w-16 h-16 mx-auto text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Pending</h1>
          <p class="text-gray-600">{{ session('info') }}</p>
        </div>
      @endif

      <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Details</h2>
        <div class="space-y-2">
          <div class="flex justify-between">
            <span class="text-gray-600">Order Number:</span>
            <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Status:</span>
            <span class="font-semibold text-gray-900 capitalize">{{ $order->status }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Payment Status:</span>
            <span class="font-semibold text-gray-900 capitalize">{{ $order->payment_status }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Total:</span>
            <span class="font-bold text-[#937237]">€{{ number_format($order->total, 2) }}</span>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Order Items</h2>
        <div class="space-y-3">
          @foreach($order->items as $item)
            <div class="flex justify-between">
              <span>{{ $item->product_name }} x{{ $item->quantity }}</span>
              <span class="font-semibold">€{{ number_format($item->subtotal, 2) }}</span>
            </div>
          @endforeach
        </div>
      </div>

      <div class="flex gap-4 justify-center">
        <a href="{{ route('theme.preview') }}" class="px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
          Continue Shopping
        </a>
        <a href="{{ route('home') }}" class="px-6 py-3 bg-[#937237] text-white font-semibold rounded-lg hover:bg-[#7a5d2e] transition-colors">
          Back to Home
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
