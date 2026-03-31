<!-- Cart Overlay -->
<div id="cart-overlay" class="hidden"></div>

<!-- Cart Sidebar -->
<div id="cart-sidebar" class="translate-x-full">
  <div style="display: flex; flex-direction: column; height: 100%;">
    <!-- Cart Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
      <h2 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin: 0;">Your Cart</h2>
      <button id="cart-close-btn" style="padding: 0.5rem; border: none; background: transparent; cursor: pointer; border-radius: 9999px; transition: background 0.2s;">
        <svg style="width: 1.5rem; height: 1.5rem; color: #4b5563;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Cart Items -->
    <div id="cart-items-container" style="flex: 1; overflow-y: auto; padding: 1.5rem;">
      <div id="cart-empty" style="text-align: center; padding: 3rem 0;">
        <svg style="width: 96px; height: 96px; margin: 0 auto 1rem; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <p style="color: #6b7280; font-size: 1.125rem; margin: 0 0 1rem;">Your cart is empty</p>
        <a href="{{ route('theme.preview') }}" style="display: inline-block; margin-top: 1rem; padding: 0.5rem 1.5rem; background-color: #937237; color: white; border-radius: 0.5rem; text-decoration: none; transition: background 0.2s;">
          Browse Menu
        </a>
      </div>
      <div id="cart-items-list" style="display: none;">
        <!-- Cart items will be dynamically inserted here -->
      </div>
    </div>

    <!-- Cart Footer -->
    <div id="cart-footer" style="display: none; border-top: 1px solid #e5e7eb; padding: 1.5rem; background-color: #f9fafb;">
      <div style="margin-bottom: 1rem;">
        <div style="display: flex; justify-content: space-between; font-size: 0.875rem; margin-bottom: 0.75rem;">
          <span style="color: #4b5563;">Subtotal</span>
          <span style="font-weight: 600; color: #111827;" id="cart-subtotal">€0.00</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.875rem; margin-bottom: 0.75rem;">
          <span style="color: #4b5563;">Delivery Fee</span>
          <span style="font-weight: 600; color: #111827;" id="cart-delivery-fee">€0.00</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 1.125rem; padding-top: 0.75rem; border-top: 1px solid #e5e7eb;">
          <span style="font-weight: 700; color: #111827;">Total</span>
          <span style="font-weight: 700; color: #937237;" id="cart-total">€0.00</span>
        </div>
      </div>
      <a href="{{ route('theme.preview') }}" id="cart-checkout-btn" style="display: block; width: 100%; padding: 0.75rem 1.5rem; background-color: #937237; color: white; text-align: center; font-weight: 600; border-radius: 0.5rem; text-decoration: none; transition: background 0.2s;">
        Proceed to Checkout
      </a>
    </div>
  </div>
</div>
