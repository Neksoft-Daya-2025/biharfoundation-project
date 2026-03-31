@extends('layouts.app')

@section('title', "Privacy Policy | Malbi's Kitchen - Your Privacy Matters")
@section('description', "Read Malbi's Kitchen's Privacy Policy to understand how we collect, use, and protect your personal information. Your privacy and data security are our top priorities.")
@section('keywords', "privacy policy, data protection, Malbi's Kitchen privacy, GDPR compliance, data security, personal information protection")
@section('og_title', "Privacy Policy | Malbi's Kitchen - Your Privacy Matters")
@section('og_description', "Read Malbi's Kitchen's Privacy Policy to understand how we collect, use, and protect your personal information.")
@section('og_image', asset('assets/images/privacy/og-privacy.jpg'))
@section('robots', 'index, follow')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden" style="padding-top: 128px; min-height: calc(50vh + 128px);">
  <div class="absolute inset-0">
    <img
      src="https://images.unsplash.com/photo-1551218808-94e220e084d2?q=80&w=2070&auto=format&fit=crop"
      alt="Privacy Policy background"
      class="w-full h-full object-cover"
      loading="lazy"
      title="Privacy Policy"
    />
    <div class="absolute inset-0 bg-gradient-to-br from-[#937237]/80 via-[#7a5d2e]/70 to-[#937237]/80"></div>
  </div>
  <div class="relative z-10 flex h-full items-center justify-center text-center text-white px-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="font-heading text-4xl md:text-6xl mb-6 text-white">Privacy Policy</h1>
      <p class="text-xl text-white/90 max-w-2xl mx-auto">
        Your privacy is important to us. Learn how we collect, use, and protect your information.
      </p>
    </div>
  </div>
</section>

<!-- Privacy Policy Content -->
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Introduction</h2>
        </div>
        <p class="text-gray-700 leading-relaxed mb-4">
          At Malbi's Kitchen, we are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.
        </p>
        <p class="text-gray-700 leading-relaxed">
          By using our website or services, you agree to the collection and use of information in accordance with this policy.
        </p>
      </div>

      <!-- Information We Collect -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Information We Collect</h2>
        </div>
        
        <div class="space-y-6">
          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Personal Information</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
              <li>Name and contact information (email, phone number, address)</li>
              <li>Order history and preferences</li>
              <li>Payment information (processed securely through third-party providers)</li>
              <li>Communication preferences</li>
            </ul>
          </div>

          <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Automatically Collected Information</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
              <li>IP address and device information</li>
              <li>Browser type and version</li>
              <li>Pages visited and time spent on our website</li>
              <li>Referring website information</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- How We Use Information -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">How We Use Your Information</h2>
        </div>
        
        <div class="grid md:grid-cols-2 gap-6">
          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Service Delivery</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 text-sm">
              <li>Process and fulfill your orders</li>
              <li>Provide customer support</li>
              <li>Send order confirmations and updates</li>
              <li>Handle delivery and pickup arrangements</li>
            </ul>
          </div>

          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Communication</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 text-sm">
              <li>Send newsletters and promotional offers</li>
              <li>Respond to your inquiries</li>
              <li>Provide important service updates</li>
              <li>Conduct customer satisfaction surveys</li>
            </ul>
          </div>

          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Improvement</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 text-sm">
              <li>Analyze website usage and performance</li>
              <li>Improve our services and menu offerings</li>
              <li>Develop new features and functionality</li>
              <li>Ensure website security and prevent fraud</li>
            </ul>
          </div>

          <div class="bg-gray-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Legal Compliance</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-700 text-sm">
              <li>Comply with applicable laws and regulations</li>
              <li>Protect our rights and interests</li>
              <li>Resolve disputes and enforce agreements</li>
              <li>Prevent fraudulent activities</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Data Protection -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Data Protection</h2>
        </div>
        
        <div class="bg-[#937237]/5 p-8 rounded-lg">
          <h3 class="text-xl font-semibold text-gray-900 mb-4">Security Measures</h3>
          <p class="text-gray-700 leading-relaxed mb-4">
            We implement appropriate technical and organizational security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:
          </p>
          <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>SSL encryption for data transmission</li>
            <li>Secure payment processing through trusted providers</li>
            <li>Regular security audits and updates</li>
            <li>Limited access to personal information on a need-to-know basis</li>
            <li>Secure data storage and backup procedures</li>
          </ul>
        </div>
      </div>

      <!-- Your Rights -->
      <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
          <svg class="h-8 w-8 text-[#937237]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
          </svg>
          <h2 class="text-3xl font-bold text-gray-900">Your Rights</h2>
        </div>
        
        <div class="space-y-4">
          <div class="border-l-4 border-[#937237] pl-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Access and Portability</h3>
            <p class="text-gray-700">You have the right to request access to your personal information and receive a copy of your data in a portable format.</p>
          </div>
          
          <div class="border-l-4 border-[#937237] pl-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Correction and Updates</h3>
            <p class="text-gray-700">You can request corrections to inaccurate or incomplete personal information.</p>
          </div>
          
          <div class="border-l-4 border-[#937237] pl-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Deletion</h3>
            <p class="text-gray-700">You have the right to request deletion of your personal information, subject to certain legal obligations.</p>
          </div>
          
          <div class="border-l-4 border-[#937237] pl-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Opt-out</h3>
            <p class="text-gray-700">You can unsubscribe from marketing communications at any time using the unsubscribe link in our emails.</p>
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
            If you have any questions about this Privacy Policy or wish to exercise your rights, please contact us:
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
