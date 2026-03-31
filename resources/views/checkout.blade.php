@extends('layouts.app')

@section('title', 'Checkout | Malbi\'s Kitchen')
@section('description', 'Complete your order')

@push('styles')
<style>
  body { background-color: #f9fafb; }
</style>
@endpush

@section('content')
<div class="min-h-screen py-20" style="padding-top: 180px;">
  <div class="container max-w-4xl mx-auto px-4">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    <div id="checkout-message" class="hidden mb-6 p-4 rounded-lg"></div>

    <form id="checkout-form" class="grid md:grid-cols-2 gap-8">
      @csrf
      
      <!-- Customer Information -->
      <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900">Customer Information</h2>
        
        <div>
          <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
          <input type="text" id="customer_name" name="customer_name" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
          <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
          <input type="email" id="customer_email" name="customer_email" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
          <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
          <input type="tel" id="customer_phone" name="customer_phone" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
          <label for="order_type" class="block text-sm font-medium text-gray-700 mb-2">Order Type *</label>
          <select id="order_type" name="order_type" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
            <option value="delivery">Delivery</option>
            <option value="pickup">Pickup</option>
          </select>
        </div>

        <div id="delivery-address-group">
          <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">Delivery Address *</label>
          <textarea id="delivery_address" name="delivery_address" rows="3"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"></textarea>
        </div>

        <div>
          <label for="delivery_time" class="block text-sm font-medium text-gray-700 mb-2">Preferred Delivery Time</label>
          <input type="datetime-local" id="delivery_time" name="delivery_time"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
          <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Special Instructions</label>
          <textarea id="notes" name="notes" rows="3"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none"></textarea>
        </div>
      </div>

      <!-- Order Summary -->
      <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900">Order Summary</h2>
        
        <div class="bg-white rounded-lg shadow-md p-6">
          <div id="order-items-summary" class="space-y-4 mb-6">
            <!-- Items will be loaded dynamically -->
          </div>
          
          <div class="border-t border-gray-200 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Subtotal</span>
              <span class="text-gray-900 font-semibold" id="summary-subtotal">€0.00</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Delivery Fee</span>
              <span class="text-gray-900 font-semibold" id="summary-delivery-fee">€0.00</span>
            </div>
            <div class="flex justify-between text-lg pt-3 border-t border-gray-200">
              <span class="font-bold text-gray-900">Total</span>
              <span class="font-bold text-[#937237]" id="summary-total">€0.00</span>
            </div>
          </div>
        </div>

        <button type="submit" id="checkout-submit-btn" class="w-full px-6 py-3 bg-[#937237] text-white font-semibold rounded-lg hover:bg-[#7a5d2e] transition-colors">
          <span id="submit-text">Proceed to Payment</span>
          <span id="submit-loading" class="hidden">Processing...</span>
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  const orderTypeSelect = document.getElementById('order_type');
  const deliveryAddressGroup = document.getElementById('delivery-address-group');
  const checkoutForm = document.getElementById('checkout-form');
  
  // Toggle delivery address requirement
  orderTypeSelect.addEventListener('change', function() {
    const deliveryAddress = document.getElementById('delivery_address');
    if (this.value === 'delivery') {
      deliveryAddressGroup.classList.remove('hidden');
      deliveryAddress.required = true;
    } else {
      deliveryAddressGroup.classList.add('hidden');
      deliveryAddress.required = false;
    }
  });

  // Load cart summary
  fetch('/cart')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        updateOrderSummary(data);
      }
    });

  function updateOrderSummary(data) {
    const itemsHtml = data.items.map(item => `
      <div class="flex justify-between">
        <span>${item.name} x${item.quantity}</span>
        <span>€${parseFloat(item.subtotal).toFixed(2)}</span>
      </div>
    `).join('');
    
    document.getElementById('order-items-summary').innerHTML = itemsHtml;
    document.getElementById('summary-subtotal').textContent = '€' + parseFloat(data.subtotal).toFixed(2);
    document.getElementById('summary-delivery-fee').textContent = '€' + parseFloat(data.delivery_fee).toFixed(2);
    document.getElementById('summary-total').textContent = '€' + parseFloat(data.total).toFixed(2);
  }

  // Handle form submission
  checkoutForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('checkout-submit-btn');
    const submitText = document.getElementById('submit-text');
    const submitLoading = document.getElementById('submit-loading');
    const messageDiv = document.getElementById('checkout-message');
    
    submitBtn.disabled = true;
    submitText.classList.add('hidden');
    submitLoading.classList.remove('hidden');
    messageDiv.classList.add('hidden');

    const formData = new FormData(checkoutForm);
    
    fetch('/order', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Create payment
        return fetch('/payment/create', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({ order_id: data.order_id })
        });
      } else {
        throw new Error(data.message || 'Order creation failed');
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success && data.payment_url) {
        window.location.href = data.payment_url;
      } else {
        throw new Error('Payment creation failed');
      }
    })
    .catch(error => {
      messageDiv.textContent = error.message || 'An error occurred. Please try again.';
      messageDiv.classList.remove('hidden');
      messageDiv.className = 'mb-6 p-4 rounded-lg bg-red-100 text-red-700';
      submitBtn.disabled = false;
      submitText.classList.remove('hidden');
      submitLoading.classList.add('hidden');
    });
  });
});
</script>
@endpush
@endsection
