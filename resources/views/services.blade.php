@extends('layouts.app')

@section('title', "Order Online | Malbi's Kitchen - Menu & Delivery")
@section('description', "Browse our full menu of authentic Surinamese dishes. Order online for delivery or pickup. Free delivery on orders over €50. Fish dishes, soups, rice dishes, and more available.")
@section('keywords', "order online, Surinamese menu, delivery Almere, pickup, fish dishes, soup dishes, Moksi Alesi, online ordering, food delivery")
@section('og_title', "Order Online | Malbi's Kitchen - Menu & Delivery")
@section('og_description', "Browse our full menu of authentic Surinamese dishes. Order online for delivery or pickup.")
@section('og_image', asset('assets/images/services/og-services.jpg'))
@section('robots', 'index, follow')

@section('content')
<!-- Hero Section -->
<section class="relative h-[500px] flex items-center justify-center overflow-hidden" style="height: 500px !important;">
  <div class="absolute inset-0">
    <img
      src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?q=80&w=2070&auto=format&fit=crop"
      alt="Malbi's Kitchen menu and ordering"
      class="w-full h-full object-cover"
      loading="lazy"
      title="Order Online"
    />
    <div class="absolute inset-0 bg-black/70" style="background-color: rgba(0, 0, 0, 0.7) !important; z-index: 1;"></div>
  </div>
  <div class="relative z-10 flex h-full items-center justify-center text-center text-white px-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="font-heading text-4xl md:text-6xl mb-6">Order Online</h1>
      <p class="text-xl text-white/90 max-w-2xl mx-auto">
        Browse our full menu of authentic Surinamese dishes and order for delivery or pickup
      </p>
    </div>
  </div>
</section>

<!-- Menu Categories Section -->
<section class="py-20 bg-white">
  <div class="container">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-12">
        <h2 class="font-heading text-3xl md:text-4xl text-gray-900 mb-4">Our Menu</h2>
        <div class="w-20 h-1 bg-gradient-to-r from-[#937237] to-[#7a5d2e] mx-auto rounded-full"></div>
      </div>

      <!-- Category Tabs (from database) -->
      <div class="mb-12 overflow-x-auto">
        <div class="flex gap-3 md:gap-4 justify-center items-end flex-wrap md:flex-nowrap pb-6">
          @foreach($categories ?? [] as $index => $cat)
          <button class="category-tab relative px-6 py-3 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap shadow-md hover:shadow-lg hover:-translate-y-1 {{ $index === 0 ? 'active' : '' }}" data-category="{{ $cat->slug }}" style="{{ $index === 0 ? 'background-color: #7a5d2e; color: #ffffff; transform: translateY(0);' : 'background-color: #f5f5f5; color: #374151;' }}">
            {{ $cat->name }}
            @if($index === 0)
            <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-[8px] border-r-[8px] border-t-[8px] border-transparent" style="border-top-color: #7a5d2e;"></div>
            @endif
          </button>
          @endforeach
        </div>
      </div>

      <!-- Menu Items Grid -->
      <div class="menu-items-grid grid md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
        @forelse($products as $product)
        <div class="menu-item-card bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300" data-category="{{ $product->category }}" style="box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);">
          <div class="relative" style="height: 128px; overflow: hidden;">
            @if($product->image)
            <img
              src="{{ $product->image }}"
              alt="{{ $product->name }}"
              class="w-full h-full object-cover"
              style="height: 128px !important; max-height: 128px !important; min-height: 128px !important; width: 100% !important; object-fit: cover !important; display: block !important; margin: 0 !important; padding: 0 !important;"
              loading="lazy"
            />
            @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
              <span class="text-gray-400 text-sm">No Image</span>
            </div>
            @endif
            @if($product->is_popular)
            <div class="absolute top-3 right-3 bg-[#937237] px-3 py-1.5 rounded-lg flex items-center gap-2">
              <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
              </svg>
              <span class="text-white text-xs font-semibold">Popular</span>
            </div>
            @endif
          </div>
          <div class="p-6 bg-white" style="padding: 1.5rem !important;">
            <div class="flex justify-between items-center mb-3">
              <h3 class="font-bold text-lg text-gray-900">{{ $product->name }}</h3>
              <span class="text-[#937237] font-bold text-lg">€{{ number_format($product->price, 2) }}</span>
            </div>
            <p class="text-gray-600 text-sm mb-6">{{ $product->description }}</p>
            @if($product->allergens && count($product->allergens) > 0)
            <div class="mb-6">
              <p class="text-xs font-medium text-gray-600 mb-2">Allergens:</p>
              <div class="flex flex-wrap gap-2">
                @foreach($product->allergens as $allergen)
                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded-full font-medium">{{ $allergen }}</span>
                @endforeach
              </div>
            </div>
            @endif
            <button onclick="addToCart({{ $product->id }})" class="bg-[#937237] hover:bg-[#7a5d2e] text-white py-2 px-4 rounded-lg font-semibold text-xs transition-all duration-300 flex items-center gap-1.5 border border-[#7a5d2e] mt-2" style="background-color: #937237 !important; border: 1px solid #7a5d2e !important; box-shadow: none !important; align-self: flex-start; margin-top: 0.5rem !important;">
              <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ffffff !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
              </svg>
              <span style="color: #ffffff !important;">Add to Cart</span>
            </button>
          </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
          <p class="text-gray-500 text-lg">No products available at the moment.</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
(function() {
    'use strict';
    
    function initializeCategoryFilter() {
        const categoryTabs = document.querySelectorAll('.category-tab');
        const menuItems = document.querySelectorAll('.menu-item-card');
        
        if (categoryTabs.length === 0 || menuItems.length === 0) return;
        
        // Initialize all items as visible
        menuItems.forEach(item => {
            item.style.display = 'block';
            item.style.opacity = '1';
            item.style.transform = 'scale(1)';
            item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        });
        
        function filterItems(category) {
            menuItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                if (category === 'all' || itemCategory === category) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        }
        
        function updateActiveTab(activeTab) {
            categoryTabs.forEach(t => {
                t.classList.remove('active');
                t.style.backgroundColor = '#f5f5f5';
                t.style.color = '#374151';
                t.style.transform = 'translateY(0)';
                t.style.transition = 'all 0.3s ease';
                // Remove arrow indicator
                const arrow = t.querySelector('div[style*="border-top-color"]');
                if (arrow) arrow.remove();
            });
            
            // Set active tab
            activeTab.classList.add('active');
            activeTab.style.backgroundColor = '#7a5d2e';
            activeTab.style.color = '#ffffff';
            activeTab.style.transform = 'translateY(0)';
            
            // Add arrow indicator
            const arrow = document.createElement('div');
            arrow.className = 'absolute -bottom-3 left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-[8px] border-r-[8px] border-t-[8px] border-transparent';
            arrow.style.borderTopColor = '#7a5d2e';
            activeTab.appendChild(arrow);
        }
        
        categoryTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const selectedCategory = this.getAttribute('data-category');
                updateActiveTab(this);
                filterItems(selectedCategory);
            });
        });
        
        // Set initial active tab (fish is default)
        const activeTab = document.querySelector('.category-tab.active');
        if (activeTab) {
            const initialCategory = activeTab.getAttribute('data-category');
            filterItems(initialCategory);
        }
    }
    
    // Initialize on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeCategoryFilter);
    } else {
        initializeCategoryFilter();
    }
})();
</script>
@endpush
@endsection
