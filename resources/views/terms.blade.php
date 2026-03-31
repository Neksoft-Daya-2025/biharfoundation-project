@extends('layouts.app')

@section('title', "Terms of Service | Malbi's Kitchen - Terms & Conditions")
@section('description', "Read Malbi's Kitchen's Terms of Service to understand the rules and guidelines for using our website and ordering services. Learn about ordering, delivery, cancellation, and refund policies.")
@section('keywords', "terms of service, terms and conditions, Malbi's Kitchen terms, ordering policy, delivery terms, cancellation policy, refund policy")
@section('og_title', "Terms of Service | Malbi's Kitchen - Terms & Conditions")
@section('og_description', "Read Malbi's Kitchen's Terms of Service to understand the rules and guidelines for using our website and ordering services.")
@section('og_image', asset('assets/images/terms/og-terms.jpg'))
@section('robots', 'index, follow')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden" style="padding-top: 128px; min-height: calc(50vh + 128px);">
  <div class="absolute inset-0">
    <img
      src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?q=80&w=2070&auto=format&fit=crop"
      alt="Terms of Service background"
      class="w-full h-full object-cover"
      loading="lazy"
      title="Terms of Service"
    />
    <div class="absolute inset-0 bg-gradient-to-br from-[#937237]/80 via-[#7a5d2e]/70 to-[#937237]/80"></div>
  </div>
  <div class="relative z-10 flex h-full items-center justify-center text-center text-white px-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="font-heading text-4xl md:text-6xl mb-6 text-white">Terms of Service</h1>
      <p class="text-xl text-white/90 max-w-2xl mx-auto">
        Please read these terms carefully before using our services. By using our website, you agree to these terms.
      </p>
    </div>
  </div>
</section>

<!-- Terms of Service Content -->
<section class="py-16 bg-white">
  <div class="container">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-12">
        <p class="text-gray-600 text-lg">
          Last updated: {{ date('F j, Y') }}
        </p>
      </div>

      <!-- Introduction -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Agreement to Terms</h2>
        </div>
        <p class="text-gray-700 leading-relaxed mb-4">
          These Terms of Service ("Terms") govern your use of Malbi's Kitchen's website and services. By accessing or using our website, placing an order, or using our services, you agree to be bound by these Terms.
        </p>
        <p class="text-gray-700 leading-relaxed">
          If you do not agree to these Terms, please do not use our services.
        </p>
      </div>

      <!-- Service Description -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Our Services</h2>
        </div>
        
        <div class="space-y-6">
          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Restaurant Services</h3>
            <p class="text-gray-700 leading-relaxed mb-4">
              Malbi's Kitchen provides authentic Surinamese cuisine through delivery and pickup services. We offer a variety of traditional dishes made with fresh ingredients and traditional recipes.
            </p>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Online Ordering</h3>
            <p class="text-gray-700 leading-relaxed">
              Our website allows you to browse our menu, place orders, and arrange for delivery or pickup. All orders are subject to availability and our operating hours.
            </p>
          </div>
        </div>
      </div>

      <!-- Ordering Terms -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Ordering and Payment</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Order Process</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 text-sm">
              <li>Browse our menu and select items</li>
              <li>Add items to your cart</li>
              <li>Provide delivery/pickup information</li>
              <li>Review and confirm your order</li>
              <li>Complete payment securely</li>
            </ul>
          </div>

          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Payment Terms</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 text-sm">
              <li>Payment is required at the time of ordering</li>
              <li>We accept major credit cards and digital payments</li>
              <li>All prices include applicable taxes</li>
              <li>Delivery fees apply as specified</li>
              <li>Minimum order amounts may apply</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Delivery and Pickup -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Delivery and Pickup</h2>
        </div>
        
        <div class="space-y-6">
          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Delivery Service</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
              <li>Delivery is available within our service area</li>
              <li>Delivery times are estimates and may vary</li>
              <li>Minimum order amount: €25.00</li>
              <li>Delivery fee: €3.50 (free for orders over €50.00)</li>
              <li>We are not responsible for delays due to weather or traffic</li>
            </ul>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Pickup Service</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
              <li>Pickup is available during our operating hours</li>
              <li>Please arrive at the scheduled pickup time</li>
              <li>Bring a valid ID for order verification</li>
              <li>Orders not picked up within 30 minutes may be cancelled</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Cancellation and Refunds -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Cancellation and Refunds</h2>
        </div>
        
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg">
          <h3 class="text-lg font-semibold text-gray-900 mb-3">Cancellation Policy</h3>
          <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>Orders can be cancelled within 15 minutes of placement</li>
            <li>Contact us immediately at 0626685252 to cancel</li>
            <li>Orders already in preparation cannot be cancelled</li>
            <li>Refunds will be processed within 3-5 business days</li>
          </ul>
        </div>

        <div class="mt-6 bg-red-50 border-l-4 border-red-400 p-6 rounded-lg">
          <h3 class="text-lg font-semibold text-gray-900 mb-3">Quality Issues</h3>
          <p class="text-gray-700 leading-relaxed">
            If you experience any issues with your order quality, please contact us within 2 hours of delivery/pickup. We will work to resolve the issue promptly, including offering replacements or refunds when appropriate.
          </p>
        </div>
      </div>

      <!-- User Responsibilities -->
      <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">User Responsibilities</h2>
        
        <div class="space-y-4">
          <div class="border-l-4 border-[#937237] pl-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Accurate Information</h3>
            <p class="text-gray-700">You must provide accurate and complete information when placing orders, including delivery address and contact details.</p>
          </div>
          
          <div class="border-l-4 border-[#937237] pl-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Age Requirements</h3>
            <p class="text-gray-700">You must be at least 18 years old to place orders. Minors may order with adult supervision.</p>
          </div>
          
          <div class="border-l-4 border-[#937237] pl-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Prohibited Uses</h3>
            <p class="text-gray-700">You may not use our services for any unlawful purpose or in any way that could damage our reputation or business.</p>
          </div>
        </div>
      </div>

      <!-- Contact Information -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Contact Us</h2>
        </div>
        
        <div class="bg-gray-50 p-8 rounded-lg">
          <p class="text-gray-700 leading-relaxed mb-4">
            If you have any questions about these Terms of Service, please contact us:
          </p>
          <div class="space-y-2 text-gray-700">
            <p><strong>Email:</strong> <a href="mailto:info@malbiskitchen.nl" class="text-[#937237] hover:underline">info@malbiskitchen.nl</a></p>
            <p><strong>Phone:</strong> <a href="tel:0626685252" class="text-[#937237] hover:underline">0626685252</a></p>
            <p><strong>Address:</strong> Argonweg 40, 1362 AB Almere, Netherlands</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
