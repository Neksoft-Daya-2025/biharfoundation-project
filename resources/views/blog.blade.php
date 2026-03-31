@extends('layouts.app')

@section('title', "Blog | Malbi's Kitchen - Recipes, Stories & Culinary Insights")
@section('description', "Read our blog for authentic Surinamese recipes, cooking tips, ingredient stories, and culinary insights from Malbi's Kitchen. Stay updated with our latest posts and newsletter.")
@section('keywords', "Surinamese recipes, cooking blog, food blog, Malbi's Kitchen blog, Surinamese cuisine tips, traditional recipes, cooking techniques, food stories")
@section('og_title', "Blog | Malbi's Kitchen - Recipes, Stories & Culinary Insights")
@section('og_description', "Read our blog for authentic Surinamese recipes, cooking tips, and culinary insights.")
@section('og_image', asset('assets/images/blog/og-blog.jpg'))
@section('robots', 'index, follow')

@section('content')
<!-- Hero Section -->
<section class="relative h-[500px] flex items-center justify-center overflow-hidden bg-black" style="height: 500px !important; background-color: #000000 !important;">
  <div class="absolute inset-0">
    <img
      src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?q=80&w=2070&auto=format&fit=crop"
      alt="Blog background"
      class="w-full h-full object-cover opacity-30"
      loading="lazy"
      title="Our Blog"
    />
    <div class="absolute inset-0 bg-black/80" style="background-color: rgba(0, 0, 0, 0.8) !important; z-index: 1;"></div>
  </div>
  <div class="relative z-10 flex h-full items-center justify-center text-center text-white px-6">
    <div class="max-w-4xl mx-auto">
      <h1 class="font-heading text-4xl md:text-6xl mb-6 text-white">Our Blog</h1>
      <p class="text-xl text-white/90 max-w-2xl mx-auto">
        Stories, recipes, and insights from Malbi's Kitchen
      </p>
    </div>
  </div>
</section>

<!-- Blog Posts Section -->
<section class="py-24 px-6 bg-white" id="blog-posts-section" style="background-color: #ffffff !important; padding-top: 6rem !important; padding-bottom: 6rem !important;">
  <div class="container max-w-7xl mx-auto">
    <div class="space-y-32" id="blog-posts-container" style="gap: 8rem !important;">
      @forelse($posts ?? [] as $post)
      <article class="blog-post-item">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
          <div class="{{ $loop->iteration % 2 === 0 ? 'order-1' : 'order-2 lg:order-1' }}">
            @if($post->featured_image_url)
              <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover rounded-lg" loading="lazy" />
            @else
              <img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800&auto=format&fit=crop" alt="{{ $post->title }}" class="w-full h-full object-cover rounded-lg" loading="lazy" />
            @endif
          </div>
          <div class="{{ $loop->iteration % 2 === 0 ? 'order-2' : 'order-1 lg:order-2' }}">
            <span class="inline-block bg-gray-100 text-gray-700 text-sm px-4 py-1.5 rounded-full mb-4 font-medium">
              {{ $post->published_at?->format('F j, Y') }}
            </span>
            <h2 class="text-3xl md:text-4xl font-heading mb-4 text-gray-900">{{ $post->title }}</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">{{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 200) }}</p>
            <a href="{{ route('blog.show', $post->slug) }}" class="text-[#937237] font-semibold hover:pl-2 transition-all inline-flex items-center gap-2" style="color: #937237 !important;">
              Read More
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #937237 !important;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          </div>
        </div>
      </article>
      @empty
      <p class="text-center text-gray-500 py-12">No blog posts yet. Check back soon.</p>
      @endforelse
    </div>

    @if(isset($posts) && $posts->hasPages())
    <div class="mt-16 flex justify-center">
      {{ $posts->links() }}
    </div>
    @endif
  </div>
</section>
@endsection
