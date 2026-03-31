@extends('layouts.app')

@section('title', ($post->meta_title ?: $post->title) . " | Malbi's Kitchen")
@section('description', $post->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 160))
@section('og_title', $post->title)
@section('og_description', $post->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 160))
@if($post->featured_image_url)
@section('og_image', $post->featured_image_url)
@endif

@section('content')
<section class="py-20 px-6 bg-white" style="padding-top: 8rem;">
  <div class="container max-w-3xl mx-auto">
    <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-[#937237] font-medium mb-8 hover:underline">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
      Back to Blog
    </a>
    <article>
      <span class="text-sm text-gray-500">{{ $post->published_at?->format('F j, Y') }}</span>
      <h1 class="font-heading text-3xl md:text-4xl lg:text-5xl text-gray-900 mt-2 mb-6">{{ $post->title }}</h1>
      @if($post->featured_image_url)
      <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full rounded-lg shadow-lg mb-8" loading="lazy" />
      @endif
      <div class="prose prose-lg max-w-none text-gray-700">
        {!! $post->content !!}
      </div>
    </article>
  </div>
</section>
@endsection
