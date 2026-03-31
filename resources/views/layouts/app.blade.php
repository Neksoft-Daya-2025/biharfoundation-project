<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <!-- SEO Meta Tags -->
  <title>@yield('title', "Malbi's Kitchen - Authentic Surinamese Cuisine in Almere")</title>
  <meta name="description" content="@yield('description', 'Experience authentic Surinamese cuisine delivered fresh to your door. Malbi\'s Kitchen offers traditional dishes like Bakkeljauw, Moksi Alesi, and more. Order online for delivery or pickup in Almere.')">
  <meta name="keywords" content="@yield('keywords', 'Surinamese food, authentic cuisine, Almere, delivery, Malbi\'s Kitchen, Bakkeljauw, Moksi Alesi, traditional food, online ordering')">
  <meta name="author" content="Malbi's Kitchen">
  <meta name="robots" content="@yield('robots', 'index, follow')">
  
  <!-- Open Graph -->
  <meta property="og:title" content="@yield('og_title', 'Home | Malbi\'s Kitchen - Authentic Surinamese Cuisine in Almere')">
  <meta property="og:description" content="@yield('og_description', 'Experience authentic Surinamese cuisine delivered fresh to your door.')">
  <meta property="og:image" content="@yield('og_image', asset('assets/images/home/og-home.jpg'))">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="website">
  
  <!-- Preconnect for performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v=34">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header-sticky.css') }}?v=1">
  <link rel="stylesheet" href="{{ asset('assets/css/mobile-menu.css') }}?v=1">
  <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}?v=1">
  
  <!-- Structured Data -->
  <script type="application/ld+json" id="schema-data">
  @yield('schema', '')
  </script>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/logo.png') }}">
  
  @stack('styles')
  
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <!-- Header -->
  @include('components.header')
  
  <!-- Sticky Header -->
  @include('components.sticky-header')
  
  <!-- Main Content -->
  <main class="bg-background">
    @yield('content')
  </main>

  <!-- Footer -->
  @include('components.footer')
  
  <!-- Cookie Consent Popup -->
  @include('components.cookie-consent')
  
  <!-- Cart Sidebar -->
  @include('components.cart-sidebar')
  
  <!-- Scripts -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="{{ asset('assets/js/mobile-menu.js') }}"></script>
  <script src="{{ asset('assets/js/cart.js') }}"></script>
  
  <!-- Header Sticky Script - Standalone -->
  <script>
  (function() {
    'use strict';
    
    function initHeaderSticky() {
      const header = document.querySelector('[data-main-header]');
      if (!header) {
        console.warn('Header not found, retrying...');
        setTimeout(initHeaderSticky, 100);
        return;
      }
      
      console.log('Header sticky script initialized');
      
      let ticking = false;
      
      function updateHeader() {
        const scrollY = window.pageYOffset || window.scrollY || document.documentElement.scrollTop;
        
        if (scrollY > 100) {
          // Scrolled - make white
          header.classList.add('is-sticky');
          header.classList.remove('bg-white/10');
          
          // Force white background
          header.style.cssText = header.style.cssText.replace(/background[^;]*;?/gi, '') + ' background-color: #ffffff !important; background: #ffffff !important;';
          
          // Change text colors
          const links = header.querySelectorAll('nav a, nav a[data-nav-link]');
          links.forEach(link => {
            link.style.color = '#1b1b18';
          });
          
          const buttons = header.querySelectorAll('button:not([style*="background-color"])');
          buttons.forEach(btn => {
            const btnId = btn.id || '';
            if (!btnId.includes('mobile-menu') && !btnId.includes('sticky-mobile-menu') && !btnId.includes('cart-toggle')) {
              btn.style.color = '#1b1b18';
            }
          });
          
          const svgs = header.querySelectorAll('svg:not([class*="text-white"])');
          svgs.forEach(svg => {
            const svgId = svg.id || '';
            if (!svg.closest('a[style*="background-color"]') && 
                !svgId.includes('mobile-menu') && !svgId.includes('sticky-mobile-menu') &&
                !svg.closest('button[id*="cart-toggle"]')) {
              svg.style.color = '#1b1b18';
            }
          });
        } else {
          // At top - make fully transparent
          header.classList.remove('is-sticky');
          header.classList.remove('bg-white/10');
          
          // Force fully transparent background
          header.style.cssText = header.style.cssText.replace(/background[^;]*;?/gi, '') + ' background-color: transparent !important; background: transparent !important;';
          
          // Change text colors to white
          const links = header.querySelectorAll('nav a, nav a[data-nav-link]');
          links.forEach(link => {
            link.style.color = '#ffffff';
          });
          
          const buttons = header.querySelectorAll('button:not([style*="background-color"])');
          buttons.forEach(btn => {
            const btnId = btn.id || '';
            if (!btnId.includes('mobile-menu') && !btnId.includes('sticky-mobile-menu') && !btnId.includes('cart-toggle')) {
              btn.style.color = '#ffffff';
            }
          });
          
          const svgs = header.querySelectorAll('svg:not([class*="text-white"])');
          svgs.forEach(svg => {
            const svgId = svg.id || '';
            if (!svg.closest('a[style*="background-color"]') && 
                !svgId.includes('mobile-menu') && !svgId.includes('sticky-mobile-menu') &&
                !svg.closest('button[id*="cart-toggle"]')) {
              svg.style.color = '#ffffff';
            }
          });
        }
        
        ticking = false;
      }
      
      function onScroll() {
        if (!ticking) {
          window.requestAnimationFrame(updateHeader);
          ticking = true;
        }
      }
      
      // Multiple scroll listeners for reliability
      window.addEventListener('scroll', onScroll, { passive: true });
      window.addEventListener('scroll', updateHeader, { passive: true });
      
      // Initial call
      updateHeader();
      
      console.log('Header sticky listeners attached');
    }
    
    // Run on DOM ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initHeaderSticky);
    } else {
      initHeaderSticky();
    }
  })();
  </script>
  
  @stack('scripts')

  <!-- Optional: send visitor location for analytics map (only if user allows) -->
  <script>
  (function(){
    if (!navigator.geolocation) return;
    navigator.geolocation.getCurrentPosition(
      function(pos) {
        var fd = new FormData();
        fd.append('latitude', pos.coords.latitude);
        fd.append('longitude', pos.coords.longitude);
        fd.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
        fetch('{{ url("/api/analytics/update-location") }}', { method: 'POST', body: fd, credentials: 'same-origin' }).catch(function(){});
      },
      function() {}
    );
  })();
  </script>
  
  <!-- FontAwesome for Icons -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
