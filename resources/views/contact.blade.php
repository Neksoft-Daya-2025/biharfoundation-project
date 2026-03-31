@extends('layouts.app')

@section('title', "Contact Us | Malbi's Kitchen - Get in Touch")
@section('description', "Contact Malbi's Kitchen in Almere. Visit us at Argonweg 40, call 0626685252, or email info@malbiskitchen.nl. Open Tuesday-Sunday 17:00-21:00. We're here to help with orders and questions.")
@section('keywords', "contact Malbi's Kitchen, Almere restaurant, phone number, address, email, opening hours, location")
@section('og_title', "Contact Us | Malbi's Kitchen - Get in Touch")
@section('og_description', "Contact Malbi's Kitchen in Almere. Visit us at Argonweg 40, call 0626685252, or email info@malbiskitchen.nl.")
@section('og_image', asset('assets/images/contact/og-contact.jpg'))
@section('robots', 'index, follow')

@section('content')
<!-- Hero Section -->
<section class="relative flex items-center justify-center overflow-hidden" style="padding-top: 128px; min-height: calc(500px + 128px); height: auto !important;">
  <div class="absolute inset-0">
    <img
      src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?q=80&w=2070&auto=format&fit=crop"
      alt="Contact Malbi's Kitchen"
      class="w-full h-full object-cover"
      loading="lazy"
      title="Contact Us"
    />
    <div class="absolute inset-0 bg-black/70" style="background-color: rgba(0, 0, 0, 0.7) !important; z-index: 1;"></div>
  </div>
  <div class="relative z-10 flex h-full items-center justify-center text-center text-white px-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="font-heading text-4xl md:text-6xl mb-6 text-white">Contact Us</h1>
      <p class="text-xl text-white/90 max-w-2xl mx-auto">
        Get in touch with Malbi's Kitchen for orders, questions, or feedback
      </p>
    </div>
  </div>
</section>

<!-- Contact Information -->
<section class="py-20 bg-white">
  <div class="container">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl md:text-4xl text-gray-900 mb-4">Get In Touch</h2>
        <div class="w-20 h-1 bg-gradient-to-r from-[#937237] to-[#7a5d2e] mx-auto rounded-full"></div>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
        <div class="text-center p-8 bg-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
          <div class="w-16 h-16 bg-[#937237] rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #937237 !important; width: 64px !important; height: 64px !important; border-radius: 50% !important; min-width: 64px !important; min-height: 64px !important; max-width: 64px !important; max-height: 64px !important;">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color: #ffffff !important; stroke: #ffffff !important;">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Address</h3>
          <div class="space-y-1">
            <p class="text-gray-600">Argonweg 40</p>
            <p class="text-gray-600">1362 AB Almere</p>
            <p class="text-gray-600">Netherlands</p>
          </div>
        </div>
        <div class="text-center p-8 bg-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
          <div class="w-16 h-16 bg-[#937237] rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #937237 !important; width: 64px !important; height: 64px !important; border-radius: 50% !important; min-width: 64px !important; min-height: 64px !important; max-width: 64px !important; max-height: 64px !important;">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color: #ffffff !important; stroke: #ffffff !important;">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Phone</h3>
          <div class="space-y-1">
            <a href="tel:0626685252" class="text-gray-600 hover:text-[#937237] transition-colors duration-300 cursor-pointer block no-underline" style="text-decoration: none !important;">
              0626685252
            </a>
            <p class="text-gray-600">Available for orders</p>
          </div>
        </div>
        <div class="text-center p-8 bg-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
          <div class="w-16 h-16 bg-[#937237] rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #937237 !important; width: 64px !important; height: 64px !important; border-radius: 50% !important; min-width: 64px !important; min-height: 64px !important; max-width: 64px !important; max-height: 64px !important;">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color: #ffffff !important; stroke: #ffffff !important;">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Email</h3>
          <div class="space-y-1">
            <a href="mailto:info@malbiskitchen.nl" class="text-gray-600 hover:text-[#937237] transition-colors duration-300 cursor-pointer block no-underline" style="text-decoration: none !important;">
              info@malbiskitchen.nl
            </a>
            <a href="mailto:orders@malbiskitchen.nl" class="text-gray-600 hover:text-[#937237] transition-colors duration-300 cursor-pointer block no-underline" style="text-decoration: none !important;">
              orders@malbiskitchen.nl
            </a>
          </div>
        </div>
        <div class="text-center p-8 bg-white rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-gray-100">
          <div class="w-16 h-16 bg-[#937237] rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: #937237 !important; width: 64px !important; height: 64px !important; border-radius: 50% !important; min-width: 64px !important; min-height: 64px !important; max-width: 64px !important; max-height: 64px !important;">
            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color: #ffffff !important; stroke: #ffffff !important;">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Opening Hours</h3>
          <div class="space-y-1">
            <p class="text-gray-600">Monday: Closed</p>
            <p class="text-gray-600">Tuesday - Sunday: 17:00 - 21:00</p>
          </div>
        </div>
      </div>

      <!-- Contact Form and Map -->
      <div class="grid lg:grid-cols-2 gap-12">
        <!-- Contact Form -->
        <div class="bg-gray-50 p-8 rounded-2xl" style="box-shadow: none !important;">
          <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>
          <form class="space-y-6" id="contact-form" method="POST" action="{{ route('contact.submit') }}">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  First Name
                </label>
                <input
                  type="text"
                  name="first_name"
                  id="first_name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-transparent"
                  placeholder="Your first name"
                  required
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  Last Name
                </label>
                <input
                  type="text"
                  name="last_name"
                  id="last_name"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-transparent"
                  placeholder="Your last name"
                  required
                />
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Email
              </label>
              <input
                type="email"
                name="email"
                id="email"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-transparent"
                placeholder="your.email@example.com"
                required
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Phone
              </label>
              <input
                type="tel"
                name="phone"
                id="phone"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-transparent"
                placeholder="Your phone number"
              />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Subject
              </label>
              <select name="subject" id="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-transparent" required>
                <option value="General Inquiry">General Inquiry</option>
                <option value="Order Question">Order Question</option>
                <option value="Feedback">Feedback</option>
                <option value="Complaint">Complaint</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Message
              </label>
              <textarea
                name="message"
                id="message"
                rows="5"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-transparent"
                placeholder="Your message..."
                required
              ></textarea>
            </div>
            <div id="contact-message" class="hidden mb-4 p-4 rounded-lg"></div>
            <button
              type="submit"
              id="contact-submit-btn"
              class="w-full bg-[#937237] hover:bg-[#7a5d2e] text-white py-3 px-6 rounded-lg font-semibold transition-all duration-300"
              style="background-color: #937237 !important;"
            >
              <span id="submit-text">Send Message</span>
              <span id="submit-loading" class="hidden">Sending...</span>
            </button>
          </form>
        </div>
        
        <!-- Map -->
        <div class="bg-gray-100 rounded-2xl overflow-hidden" style="height: 500px;">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2436.1234567890123!2d5.214303!3d52.370216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTLCsDIyJzEyLjgiTiA1wrAxMic1MS41IkU!5e0!3m2!1sen!2snl!4v1234567890123!5m2!1sen!2snl"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const contactForm = document.getElementById('contact-form');
  const submitBtn = document.getElementById('contact-submit-btn');
  const submitText = document.getElementById('submit-text');
  const submitLoading = document.getElementById('submit-loading');
  const messageDiv = document.getElementById('contact-message');
  
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Disable submit button
      submitBtn.disabled = true;
      submitText.classList.add('hidden');
      submitLoading.classList.remove('hidden');
      messageDiv.classList.add('hidden');
      
      // Get form data
      const formData = new FormData(contactForm);
      
      // Submit via AJAX
      fetch('{{ route("contact.submit") }}', {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]')?.value
        }
      })
      .then(response => response.json())
      .then(data => {
        messageDiv.classList.remove('hidden');
        
        if (data.success) {
          messageDiv.className = 'mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800';
          messageDiv.textContent = data.message || 'Thank you! Your message has been sent successfully.';
          contactForm.reset();
        } else {
          messageDiv.className = 'mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
          let errorMsg = data.message || 'There was an error sending your message.';
          if (data.errors) {
            const errorList = Object.values(data.errors).flat().join(', ');
            errorMsg += ' ' + errorList;
          }
          messageDiv.textContent = errorMsg;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        messageDiv.classList.remove('hidden');
        messageDiv.className = 'mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800';
        messageDiv.textContent = 'Sorry, there was an error sending your message. Please try again later or contact us directly.';
      })
      .finally(() => {
        // Re-enable submit button
        submitBtn.disabled = false;
        submitText.classList.remove('hidden');
        submitLoading.classList.add('hidden');
        
        // Scroll to message
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      });
    });
  }
});
</script>
@endpush
@endsection
