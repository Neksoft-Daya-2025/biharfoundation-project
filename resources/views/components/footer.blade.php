<footer class="relative overflow-hidden" style="background-color: #7a5d2e;">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/5 via-transparent to-white/5"></div>
    <div class="absolute top-10 right-10 w-32 h-32 bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 left-10 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>
  </div>
  
  <div class="relative z-10">
    <div class="container grid gap-12 py-16 md:py-20 md:grid-cols-4">
      <!-- Brand Section -->
      <div class="md:col-span-1">
        <a href="{{ route('home') }}" class="flex items-center gap-3 mb-6">
          <img 
            src="{{ asset('assets/logo.png') }}" 
            alt="Malbi's Kitchen" 
            class="h-8 w-auto filter brightness-0 invert"
            loading="lazy"
            title="Malbi's Kitchen Logo"
          />
          <span class="font-heading text-2xl tracking-wide text-white">Malbi's Kitchen</span>
        </a>
        <p class="text-sm text-white/80 max-w-sm leading-relaxed mb-6">
          Authentic Surinamese cuisine delivered fresh to your door. Experience traditional flavors with modern convenience.
        </p>
        
        <!-- Social Media -->
        <div class="flex items-center gap-4">
          <a href="https://www.facebook.com/malbiskitchen" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="p-3 rounded-full transition-all duration-300 hover:scale-110 text-white/80 hover:text-white" style="background-color: #5a4520 !important;">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </a>
          <a href="https://www.instagram.com/malbiskitchen" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="p-3 rounded-full transition-all duration-300 hover:scale-110 text-white/80 hover:text-white" style="background-color: #5a4520 !important;">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>
          <a href="https://twitter.com/malbiskitchen" target="_blank" rel="noopener noreferrer" aria-label="Twitter" class="p-3 rounded-full transition-all duration-300 hover:scale-110 text-white/80 hover:text-white" style="background-color: #5a4520 !important;">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- Contact Section -->
      <div>
        <h4 class="font-heading text-xl text-white mb-6 relative">
          Contact Info
          <div class="absolute -bottom-2 left-0 w-8 h-0.5 bg-gradient-to-r from-white/60 to-transparent"></div>
        </h4>
        <ul class="space-y-3 text-sm text-white/80">
          <li class="flex items-start gap-3 group">
            <div class="p-2 rounded-full transition-all duration-300 mt-0.5" style="background-color: #5a4520 !important;">
              <svg class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ffffff !important; stroke: #ffffff !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
              </svg>
            </div>
            <div>
              <span class="font-medium">Argonweg 40</span>
              <br />
              <span class="text-white/60">1362 AB Almere</span>
            </div>
          </li>
          <li class="flex items-center gap-3 group">
            <div class="p-2 rounded-full transition-all duration-300" style="background-color: #5a4520 !important;">
              <svg class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ffffff !important; stroke: #ffffff !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <div>
              <span class="font-medium">Monday: Closed • Tue-Sun: 17:00 - 21:00</span>
            </div>
          </li>
          <li class="flex items-center gap-3 group">
            <div class="p-2 rounded-full transition-all duration-300" style="background-color: #5a4520 !important;">
              <svg class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ffffff !important; stroke: #ffffff !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
            </div>
            <div class="text-white/80">
              <a 
                href="tel:0626685252" 
                class="font-medium hover:text-white transition-colors duration-300 cursor-pointer"
                style="color: #ffffff !important; text-decoration: none !important;"
              >
                0626685252
              </a>
            </div>
          </li>
          <li class="flex items-center gap-3 group">
            <div class="p-2 rounded-full transition-all duration-300" style="background-color: #5a4520 !important;">
              <svg class="h-4 w-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ffffff !important; stroke: #ffffff !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
              </svg>
            </div>
            <div class="text-white/80">
              <a 
                href="mailto:info@malbiskitchen.nl" 
                class="font-medium hover:text-white transition-colors duration-300 cursor-pointer"
                style="color: #ffffff !important; text-decoration: none !important;"
              >
                info@malbiskitchen.nl
              </a>
            </div>
          </li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="font-heading text-xl text-white mb-6 relative">
          Quick Links
          <div class="absolute -bottom-2 left-0 w-8 h-0.5 bg-gradient-to-r from-white/60 to-transparent"></div>
        </h4>
        <ul class="space-y-3 text-sm" style="list-style: none !important; padding-left: 0 !important;">
          <li style="list-style: none !important;"><a href="{{ route('home') }}" class="text-white/80 hover:text-white transition-colors duration-300 hover:translate-x-1 inline-block no-underline" style="text-decoration: none !important; color: rgba(255, 255, 255, 0.8) !important;">Home</a></li>
          <li style="list-style: none !important;"><a href="{{ route('about') }}" class="text-white/80 hover:text-white transition-colors duration-300 hover:translate-x-1 inline-block no-underline" style="text-decoration: none !important; color: rgba(255, 255, 255, 0.8) !important;">About Us</a></li>
          <li style="list-style: none !important;"><a href="{{ route('theme.preview') }}" class="text-white/80 hover:text-white transition-colors duration-300 hover:translate-x-1 inline-block no-underline" style="text-decoration: none !important; color: rgba(255, 255, 255, 0.8) !important;">Order Online</a></li>
          <li style="list-style: none !important;"><a href="{{ route('blog') }}" class="text-white/80 hover:text-white transition-colors duration-300 hover:translate-x-1 inline-block no-underline" style="text-decoration: none !important; color: rgba(255, 255, 255, 0.8) !important;">Blog</a></li>
          <li style="list-style: none !important;"><a href="{{ route('contact') }}" class="text-white/80 hover:text-white transition-colors duration-300 hover:translate-x-1 inline-block no-underline" style="text-decoration: none !important; color: rgba(255, 255, 255, 0.8) !important;">Contact Us</a></li>
        </ul>
      </div>

      <!-- Delivery Info -->
      <div>
        <h4 class="font-heading text-xl text-white mb-6 relative">
          Delivery Info
          <div class="absolute -bottom-2 left-0 w-8 h-0.5 bg-gradient-to-r from-white/60 to-transparent"></div>
        </h4>
        <div class="space-y-3">
          <div class="flex items-center gap-2 text-sm text-white/80">
            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
            <span>Delivery: From €25.00</span>
          </div>
          <div class="flex items-center gap-2 text-sm text-white/80">
            <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
            <span>Free Delivery: From €50.00</span>
          </div>
          <div class="flex items-center gap-2 text-sm text-white/80">
            <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
            <span>Cost: From €3.50</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Section -->
    <div class="border-t border-white/20 py-8">
      <div class="container">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
          <div class="text-center md:text-left">
            <p class="text-xs text-white/60">
              © {{ date('Y') }} Malbi's Kitchen. All rights reserved. • Powered By <a href="https://neksoftconsultancy.com/" target="_blank" rel="noopener noreferrer" class="text-white/70 hover:text-white transition-colors">Neksoft Consultancy Services</a>
            </p>
          </div>
          <div class="flex items-center gap-6 text-xs text-white/60">
            <a href="{{ route('privacy') }}" class="hover:text-white transition-colors text-white no-underline" style="color: #ffffff !important; text-decoration: none !important;">Privacy Policy</a>
            <a href="{{ route('terms') }}" class="hover:text-white transition-colors text-white no-underline" style="color: #ffffff !important; text-decoration: none !important;">Terms of Service</a>
            <a href="javascript:void(0);" onclick="document.getElementById('cookie-consent-popup').style.display='block'; document.getElementById('cookie-consent-popup').classList.remove('hidden');" class="hover:text-white transition-colors text-white no-underline cursor-pointer" style="color: #ffffff !important; text-decoration: none !important;">Cookies</a>
            <a href="{{ route('login') }}" class="hover:text-white transition-colors text-white no-underline" style="color: #ffffff !important; text-decoration: none !important;" title="Admin dashboard">Admin</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<style>
  /* Footer Icon Backgrounds - Darker Brown */
  footer .rounded-full[style*="background-color: #5a4520"] {
    background-color: #5a4520 !important;
    border-radius: 50% !important;
  }
  
  /* Footer Links - No Blue Color */
  footer a {
    color: inherit !important;
    text-decoration: none !important;
  }
  /* Contact info links - white color */
  footer .text-white\/80 a[href^="tel:"],
  footer .text-white\/80 a[href^="mailto:"],
  footer ul.text-white\/80 a[href^="tel:"],
  footer ul.text-white\/80 a[href^="mailto:"] {
    color: rgba(255, 255, 255, 0.8) !important;
  }
  footer .text-white\/80 a[href^="tel:"]:hover,
  footer .text-white\/80 a[href^="mailto:"]:hover,
  footer ul.text-white\/80 a[href^="tel:"]:hover,
  footer ul.text-white\/80 a[href^="mailto:"]:hover {
    color: #ffffff !important;
  }
  
  /* Quick Links - No Bullet Points */
  footer ul[style*="list-style: none"] {
    list-style: none !important;
    padding-left: 0 !important;
  }
  footer ul[style*="list-style: none"] li {
    list-style: none !important;
  }
  
  /* Ensure all footer links are not blue */
  footer a:not([href^="tel:"]):not([href^="mailto:"]):not([href^="http"]) {
    color: rgba(255, 255, 255, 0.8) !important;
  }
  footer a:not([href^="tel:"]):not([href^="mailto:"]):not([href^="http"]):hover {
    color: #ffffff !important;
  }
</style>
