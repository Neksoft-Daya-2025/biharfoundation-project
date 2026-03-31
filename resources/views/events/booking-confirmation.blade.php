@extends('layouts.app')

@section('title', 'Booking confirmed')
@section('description', 'Your event booking confirmation')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Booking confirmed</h1>
            <p class="text-gray-600 mb-6">Thank you for your booking. Please save your reference number.</p>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left">
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Booking reference</p>
                <p class="text-2xl font-mono font-bold text-[#937237] mt-1">{{ $booking->booking_reference }}</p>
            </div>

            <div class="text-left space-y-2 text-sm text-gray-600 mb-6">
                <p><strong>Event:</strong> {{ $booking->event->title }}</p>
                <p><strong>Date:</strong> {{ $booking->event->start_at->format('l, d M Y \a\t H:i') }}</p>
                <p><strong>Name:</strong> {{ $booking->customer_name }}</p>
                <p><strong>Email:</strong> {{ $booking->customer_email }}</p>
                @if($booking->items->isNotEmpty())
                <p><strong>Tickets:</strong></p>
                <ul class="list-disc list-inside ml-2 mt-1 space-y-0.5">
                    @foreach($booking->items as $item)
                    <li>{{ $item->ticketType->name ?? 'N/A' }}: {{ $item->quantity }} × {{ format_money($item->unit_price) }} = {{ format_money($item->total_amount) }}</li>
                    @endforeach
                </ul>
                <p class="mt-2"><strong>Total:</strong> {{ format_money($booking->total_amount) }}</p>
                @else
                <p><strong>Tickets:</strong> {{ $booking->quantity }}</p>
                <p><strong>Total:</strong> {{ format_money($booking->total_amount) }}</p>
                @endif
            </div>

            <p class="text-sm text-gray-500 mb-6">We've sent a confirmation to your email. You may be contacted if there are any updates to the event.</p>

            <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 bg-[#937237] hover:bg-[#7a5d2e] text-white font-medium rounded-lg transition-colors">
                View more events
            </a>
        </div>
    </div>
</div>
@endsection
