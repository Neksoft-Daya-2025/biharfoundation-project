@extends('layouts.app')

@section('title', "About Us | Malbi's Kitchen - Our Story & Heritage")
@section('description', "Discover the story behind Malbi's Kitchen. We bring authentic Surinamese cuisine to Almere with traditional recipes passed down through generations. Learn about our values, heritage, and commitment to quality.")
@section('keywords', "about Malbi's Kitchen, Surinamese restaurant Almere, our story, traditional recipes, authentic cuisine, family recipes")
@section('og_title', "About Us | Malbi's Kitchen - Our Story & Heritage")
@section('og_description', "Discover the story behind Malbi's Kitchen. We bring authentic Surinamese cuisine to Almere with traditional recipes.")
@section('og_image', asset('assets/images/about/og-about.jpg'))
@section('robots', 'index, follow')

@section('schema')
{
  "@@context": "https://schema.org",
  "@@type": "Restaurant",
  "name": "Malbi's Kitchen",
  "description": "Authentic Surinamese cuisine delivered fresh to your door in Almere",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/logo.png') }}",
  "image": "{{ asset('assets/images/about/og-about.jpg') }}",
  "telephone": "0626685252",
  "email": "info@malbiskitchen.nl",
  "address": {
    "@@type": "PostalAddress",
    "streetAddress": "Argonweg 40",
    "addressLocality": "Almere",
    "postalCode": "1362 AB",
    "addressCountry": "NL"
  }
}
@endsection

@section('content')
<!-- Hero Section -->
<section class="relative w-full overflow-hidden" style="padding-top: 128px; min-height: calc(500px + 128px); height: auto !important;">
  <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2069&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-black/70" style="background-color: rgba(0, 0, 0, 0.7) !important; z-index: 1;"></div>
  </div>
  <div class="relative z-10 flex h-full items-center justify-center text-center text-white px-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="font-heading text-4xl md:text-6xl mb-6">About Malbi's Kitchen</h1>
      <p class="text-xl text-white/90 max-w-2xl mx-auto">
        Discover the story behind our authentic Surinamese cuisine and our commitment to delivering exceptional flavors to your doorstep.
      </p>
    </div>
  </div>
</section>

<!-- Our Story Section -->
<section class="py-16 md:py-24 bg-[#FAF9F6]">
  <div class="container">
    <div class="max-w-7xl mx-auto">
      <div class="grid lg:grid-cols-2 gap-0 items-stretch">
        <!-- Left Side - Image -->
        <div class="relative h-[500px] lg:h-auto overflow-hidden">
          <img
            src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?q=80&w=800&auto=format&fit=crop"
            alt="Malbi's Kitchen interior showing traditional Surinamese cuisine preparation"
            class="w-full h-full object-cover"
            loading="lazy"
            title="Malbi's Kitchen Interior"
          />
        </div>
        
        <!-- Right Side - Text Content -->
        <div class="bg-[#FAF9F6] px-8 md:px-12 lg:px-16 py-12 md:py-16 lg:py-20 flex flex-col justify-center">
          <div class="max-w-xl">
            <!-- Main Heading -->
            <h2 class="font-heading text-3xl md:text-4xl lg:text-5xl mb-6 text-gray-900 leading-tight">
              Our Story
            </h2>
            
            <!-- Description -->
            <div class="text-gray-700 text-base md:text-lg leading-relaxed font-sans space-y-4">
              <p>
                Malbi's Kitchen was born from a passion for authentic Surinamese cuisine and a desire to share the rich flavors of our heritage with the community in Almere. Our journey began with a simple mission: to bring traditional Surinamese dishes to your table with the same love and care that has been passed down through generations.
              </p>
              <p>
                Founded by experienced chefs who grew up with these recipes, we understand that great food is more than just ingredients - it's about tradition, family, and the stories that make each dish special. Every meal we prepare carries the essence of Surinamese culture, blending indigenous, African, Indian, Indonesian, and Dutch influences into something truly unique.
              </p>
              <p>
                Today, we're proud to serve the Almere community with fresh, authentic dishes delivered right to your door. From our signature Bakkeljauw to our aromatic Moksi Alesi, each dish is prepared with the finest ingredients and traditional techniques that have stood the test of time.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Values Section -->
<section id="values" class="py-16 md:py-20 bg-gray-50">
  <div class="container">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-16">
        <h2 class="font-heading text-3xl md:text-4xl mb-4">Our Values</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          The principles that guide everything we do at Malbi's Kitchen
        </p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-center">
          <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #937237 !important; width: 64px !important; height: 64px !important;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ffffff !important; stroke: #ffffff !important;">
              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl mb-4">Authenticity</h3>
          <p class="text-gray-600 leading-relaxed">We stay true to traditional recipes and cooking methods passed down through generations.</p>
        </div>
        <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-center">
          <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #937237 !important; width: 64px !important; height: 64px !important;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ffffff !important; stroke: #ffffff !important;">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl mb-4">Quality</h3>
          <p class="text-gray-600 leading-relaxed">Only the freshest ingredients and finest spices make it into our kitchen.</p>
        </div>
        <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-center">
          <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #937237 !important; width: 64px !important; height: 64px !important;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ffffff !important; stroke: #ffffff !important;">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
              <circle cx="9" cy="7" r="4"></circle>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl mb-4">Community</h3>
          <p class="text-gray-600 leading-relaxed">We're proud to serve and strengthen our local Almere community.</p>
        </div>
        <div class="bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 text-center">
          <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #937237 !important; width: 64px !important; height: 64px !important;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ffffff !important; stroke: #ffffff !important;">
              <circle cx="12" cy="12" r="10"></circle>
              <path d="M12 6v6l4 2"></path>
            </svg>
          </div>
          <h3 class="font-heading text-xl mb-4">Reliability</h3>
          <p class="text-gray-600 leading-relaxed">Consistent quality and timely delivery, every time you order with us.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Visit Us Section -->
<section class="relative py-16 md:py-20 overflow-hidden">
  <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2069&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-black/70" style="background-color: rgba(0, 0, 0, 0.7) !important;"></div>
  </div>
  <div class="container relative z-10">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="font-heading text-3xl md:text-4xl text-white mb-6">Visit Us</h2>
      <p class="text-xl text-white/90 mb-12 max-w-2xl mx-auto">
        Experience authentic Surinamese cuisine at our location in Almere
      </p>
      <div class="grid md:grid-cols-3 gap-8 mb-12">
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6 hover:bg-white/15 transition-all duration-300">
          <svg class="h-8 w-8 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <h3 class="text-white font-semibold mb-2">Address</h3>
          <p class="text-white/80 mb-3">Argonweg 40<br />1362 AB Almere</p>
          <a href="https://maps.google.com/?q=Argonweg+40,+1362+AB+Almere" target="_blank" rel="noopener noreferrer" class="text-white/90 hover:text-white text-sm transition-colors">
            View on Maps →
          </a>
        </div>
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6 hover:bg-white/15 transition-all duration-300">
          <svg class="h-8 w-8 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
          </svg>
          <h3 class="text-white font-semibold mb-2">Phone</h3>
          <p class="text-white/80 text-lg font-medium mb-2">0626685252</p>
          <p class="text-white/70 text-sm">Tue-Sun: 17:00-21:00</p>
        </div>
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-6 hover:bg-white/15 transition-all duration-300">
          <svg class="h-8 w-8 text-white mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
          <h3 class="text-white font-semibold mb-2">Email</h3>
          <p class="text-white/80 mb-2">info@malbiskitchen.nl</p>
          <p class="text-white/70 text-sm">24h response</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
