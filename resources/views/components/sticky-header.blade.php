<header class="fixed inset-x-0 top-0 z-50 bg-white transition-all duration-300 shadow-md" data-sticky-header style="display: none; background-color: #ffffff !important; background: #ffffff !important; backdrop-filter: none !important; -webkit-backdrop-filter: none !important; opacity: 1 !important;">
  <!-- Navigation row - Compact version -->
  <div class="container flex h-20 items-center justify-between py-3">
    <a href="{{ route('home') }}" class="flex items-center gap-2">
      <img 
        src="{{ asset('assets/logo.png') }}" 
        alt="Malbi's Kitchen" 
        class="h-8 w-auto"
        loading="lazy"
        title="Malbi's Kitchen Logo"
      />
    </a>

    <button class="md:hidden p-2 text-gray-900 z-50 relative" aria-label="Toggle menu" id="sticky-mobile-menu-toggle" aria-expanded="false">
      <svg id="sticky-mobile-menu-icon" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
      <svg id="sticky-mobile-menu-close" class="h-6 w-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>

    <!-- Desktop Navigation -->
    <nav class="hidden md:flex flex-1">
      <ul class="flex items-center justify-center gap-6 mx-auto" style="list-style: none; width: 100%; justify-content: center;">
        <li>
          <a href="{{ route('home') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-gray-900 hover:text-[#937237] no-underline {{ request()->routeIs('home') ? 'text-[#937237]' : '' }}" data-sticky-nav-link style="color: #1b1b18 !important;">Home</a>
        </li>
        <li>
          <a href="{{ route('about') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-gray-900 hover:text-[#937237] no-underline {{ request()->routeIs('about') ? 'text-[#937237]' : '' }}" data-sticky-nav-link style="color: #1b1b18 !important;">About Us</a>
        </li>
        <li>
          <a href="{{ route('theme.preview') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-gray-900 hover:text-[#937237] no-underline {{ request()->routeIs('theme.preview') || request()->routeIs('public.home') ? 'text-[#937237]' : '' }}" data-sticky-nav-link style="color: #1b1b18 !important;">Order Online</a>
        </li>
        <li>
          <a href="{{ route('blog') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-gray-900 hover:text-[#937237] no-underline {{ request()->routeIs('blog') ? 'text-[#937237]' : '' }}" data-sticky-nav-link style="color: #1b1b18 !important;">Blog</a>
        </li>
        <li>
          <a href="{{ route('contact') }}" class="relative text-sm tracking-[0.2em] uppercase link-underline text-gray-900 hover:text-[#937237] no-underline {{ request()->routeIs('contact') ? 'text-[#937237]' : '' }}" data-sticky-nav-link style="color: #1b1b18 !important;">Contact Us</a>
        </li>
      </ul>
    </nav>

    <!-- Mobile Menu Panel -->
    <div id="sticky-mobile-menu-panel">
      <div class="h-full overflow-y-auto py-8 px-6">
        <nav class="flex flex-col gap-6">
          <a href="{{ route('home') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('home') ? 'text-[#937237]' : '' }}" data-sticky-nav-link>Home</a>
          <a href="{{ route('about') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('about') ? 'text-[#937237]' : '' }}" data-sticky-nav-link>About Us</a>
          <a href="{{ route('theme.preview') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('theme.preview') || request()->routeIs('public.home') ? 'text-[#937237]' : '' }}" data-sticky-nav-link>Order Online</a>
          <a href="{{ route('blog') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('blog') ? 'text-[#937237]' : '' }}" data-sticky-nav-link>Blog</a>
          <a href="{{ route('contact') }}" class="text-lg font-semibold text-gray-900 hover:text-[#937237] transition-colors py-2 border-b border-gray-200 {{ request()->routeIs('contact') ? 'text-[#937237]' : '' }}" data-sticky-nav-link>Contact Us</a>
          <div class="pt-4">
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
