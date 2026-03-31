<header class="fixed inset-x-0 top-0 z-50 transition-all duration-300" data-main-header style="background-color: transparent !important; background: transparent !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important;">
  <!-- Navigation row -->
  <div class="container flex h-32 items-center justify-between py-6">
    <a href="{{ route('home') }}" class="flex items-center gap-2">
      <img 
        src="{{ asset('assets/logo.png') }}" 
        alt="Malbi's Kitchen" 
        class="h-20 w-auto"
        loading="lazy"
        title="Malbi's Kitchen Logo"
      />
    </a>

    <button class="md:hidden p-2 text-white z-50 relative" aria-label="Toggle menu" id="mobile-menu-toggle" aria-expanded="false">
      <svg id="mobile-menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
      <svg id="mobile-menu-close" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>

    <!-- Desktop Navigation -->
    <nav class="hidden md:flex flex-1">
      <ul class="flex items-center justify-center gap-8 mx-auto" style="list-style: none; width: 100%; justify-content: center;">
        <li>
          <a href="{{ route('home') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-white hover:text-white no-underline {{ request()->routeIs('home') ? 'text-[#937237]' : '' }}" data-nav-link>Home</a>
        </li>
        <li>
          <a href="{{ route('about') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-white hover:text-white no-underline {{ request()->routeIs('about') ? 'text-[#937237]' : '' }}" data-nav-link>About Us</a>
        </li>
        <li>
          <a href="{{ route('theme.preview') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-white hover:text-white no-underline {{ request()->routeIs('theme.preview') || request()->routeIs('public.home') ? 'text-[#937237]' : '' }}" data-nav-link>Order Online</a>
        </li>
        <li>
          <a href="{{ route('blog') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-white hover:text-white no-underline {{ request()->routeIs('blog') ? 'text-[#937237]' : '' }}" data-nav-link>Blog</a>
        </li>
        <li>
          <a href="{{ route('contact') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-white hover:text-white no-underline {{ request()->routeIs('contact') ? 'text-[#937237]' : '' }}" data-nav-link>Contact Us</a>
        </li>
      </ul>
    </nav>

    <!-- Mobile Menu Panel -->
    <div id="mobile-menu-panel">
      <div class="h-full overflow-y-auto py-8 px-6">
        <nav class="flex flex-col gap-6">
          <a href="{{ route('home') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('home') ? 'text-[#937237]' : '' }}" data-nav-link>Home</a>
          <a href="{{ route('about') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('about') ? 'text-[#937237]' : '' }}" data-nav-link>About Us</a>
          <a href="{{ route('theme.preview') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('theme.preview') || request()->routeIs('public.home') ? 'text-[#937237]' : '' }}" data-nav-link>Order Online</a>
          <a href="{{ route('blog') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('blog') ? 'text-[#937237]' : '' }}" data-nav-link>Blog</a>
          <a href="{{ route('contact') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('contact') ? 'text-[#937237]' : '' }}" data-nav-link>Contact Us</a>
          <div class="pt-4 space-y-3">
            <button id="cart-toggle-btn-mobile" class="relative w-full flex items-center justify-center gap-2 px-6 py-3 text-sm font-semibold tracking-[0.15em] uppercase text-white rounded-full transition-all duration-300 hover:scale-105 hover:shadow-lg" style="background-color: #937237;">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              CART (<span id="cart-badge-mobile">0</span>)
            </button>
            <a href="{{ route('theme.preview') }}" class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 text-sm font-semibold tracking-[0.15em] uppercase text-white rounded-full transition-all duration-300 hover:scale-105 hover:shadow-lg" style="background-color: #937237;">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              ORDER ONLINE
            </a>
          </div>
        </nav>
      </div>
    </div>

    <div class="hidden md:flex items-center gap-3">
      <button id="cart-toggle-btn-desktop" class="relative p-2 hover:bg-white/10 rounded-lg transition-colors">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <span id="cart-badge-desktop" class="absolute -top-1 -right-1 bg-[#937237] text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
      </button>
      <a
        href="{{ route('theme.preview') }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold tracking-[0.15em] uppercase text-white rounded-full transition-all duration-300 hover:scale-105 hover:shadow-lg no-underline"
        style="background-color: #937237;"
        onmouseover="this.style.backgroundColor='#7a5d2e'"
        onmouseout="this.style.backgroundColor='#937237'"
      >
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" style="color: #ffffff !important;">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        ORDER ONLINE
      </a>
    </div>
  </div>
</header>
