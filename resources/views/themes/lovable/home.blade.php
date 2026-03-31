@extends('themes.lovable.layouts.app')

@section('title', 'Bihar Foundation Netherlands')

@push('head')
<meta name="description" content="Stichting Bihar Foundation Netherlands Chapter — community, culture, events, and initiatives connecting the Bihar diaspora in the Netherlands." />
<meta name="author" content="Bihar Foundation Netherlands" />
<meta property="og:title" content="Bihar Foundation Netherlands | Stichting Bihar Foundation Netherlands Chapter" />
<meta property="og:description" content="Stichting Bihar Foundation Netherlands Chapter — community, culture, events, and initiatives connecting the Bihar diaspora in the Netherlands." />
<meta property="og:type" content="website" />
<meta name="twitter:card" content="summary_large_image" />
@if(file_exists(public_path('themes/lovable/assets/hero-video.mp4')))
<link rel="preload" as="video" href="{{ asset('themes/lovable/assets/hero-video.mp4') }}" type="video/mp4" />
@endif
@endpush

@php
$assetDir = public_path('themes/lovable/assets');
$css = is_dir($assetDir) ? glob($assetDir . '/index-*.css') : [];
$js = is_dir($assetDir) ? glob($assetDir . '/index-*.js') : [];
$routerBasename = str_starts_with(request()->path(), 'theme-preview') ? '/theme-preview' : '/home';
@endphp

@push('styles')
@foreach($css as $file)
<link rel="stylesheet" crossorigin href="{{ asset('themes/lovable/assets/' . basename($file)) }}">
@endforeach
@endpush

@section('content')
<div id="root" data-router-basename="{{ $routerBasename }}"></div>
@endsection

@push('scripts')
@foreach($js as $file)
<script type="module" crossorigin src="{{ asset('themes/lovable/assets/' . basename($file)) }}"></script>
@endforeach
@endpush
