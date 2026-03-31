@extends('layouts.app')

@section('title', 'Events')
@section('description', 'Upcoming events and ticket booking')
@section('keywords', 'events, tickets, booking')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Upcoming Events</h1>
        <p class="text-gray-600 mb-8">Book your tickets for our upcoming events.</p>

        @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
            {{ session('error') }}
        </div>
        @endif

        <div class="space-y-6">
            @forelse($events as $event)
            <article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="sm:flex">
                    @if($event->image_url)
                    <div class="sm:w-48 flex-shrink-0">
                        <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    </div>
                    @endif
                    <div class="p-6 flex-1">
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $event->title }}</h2>
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-medium">{{ $event->start_at->format('l, d M Y') }}</span>
                            at {{ $event->start_at->format('H:i') }}
                            @if($event->venue) · {{ $event->venue }} @endif
                        </p>
                        @if($event->description)
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($event->description, 150) }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-4">
                            <span class="text-lg font-semibold text-[#937237]">
                                @if($event->price_per_ticket > 0)
                                    {{ format_money($event->price_per_ticket) }} per ticket
                                @else
                                    Free
                                @endif
                            </span>
                            <a href="{{ route('events.show', $event->slug) }}" class="inline-flex items-center px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                                Book tickets
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center text-gray-500">
                <p class="text-lg">No upcoming events at the moment.</p>
                <p class="text-sm mt-2">Check back later for new events.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
