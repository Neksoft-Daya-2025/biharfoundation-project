@extends('layouts.dashboard')

@section('title', 'Attendees')
@section('page-title', 'Attendees Management')
@section('page-description', 'View and manage all event bookings and attendees')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Attendees</h2>
            <p class="text-sm text-gray-600 mt-1">All event ticket bookings</p>
        </div>
        <a href="{{ route('dashboard.events') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="calendar" class="w-4 h-4"></i> Events
        </a>
    </div>

    <form method="GET" action="{{ route('dashboard.events.attendees') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <select name="event_id" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
                <option value="">All events</option>
                @foreach($events as $e)
                <option value="{{ $e->id }}" {{ request('event_id') == $e->id ? 'selected' : '' }}>{{ $e->title }}</option>
                @endforeach
            </select>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
                <option value="">All statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="search" class="w-4 h-4"></i> Filter
            </button>
        </div>
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Attendee</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Booked at</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-sm text-gray-900">{{ $booking->booking_reference }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('dashboard.events.show', $booking->event) }}" class="text-[#937237] hover:underline">{{ $booking->event->title }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ $booking->customer_name }}</div>
                            <div class="text-gray-500">{{ $booking->customer_email }}</div>
                            @if($booking->customer_phone)<div class="text-gray-500 text-xs">{{ $booking->customer_phone }}</div>@endif
                            @if($booking->items->isNotEmpty())
                            <div class="text-xs text-gray-500 mt-1">
                                @foreach($booking->items as $item)
                                {{ $item->ticketType->name ?? 'N/A' }}: {{ $item->quantity }}<br>
                                @endforeach
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->attendees_count }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ format_money($booking->total_amount) }}</td>
                        <td class="px-6 py-4">
                            @if($booking->status === 'confirmed')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Confirmed</span>
                            @elseif($booking->status === 'cancelled')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Cancelled</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-800">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $booking->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('dashboard.events.show', $booking->event) }}" class="text-[#937237] hover:underline">View event</a>
                            @if($booking->status !== 'cancelled')
                            <form action="{{ route('dashboard.events.bookings.update-status', $booking) }}" method="POST" class="inline ml-2">
                                @csrf
                                <input type="hidden" name="status" value="{{ $booking->status === 'confirmed' ? 'pending' : 'confirmed' }}">
                                <button type="submit" class="text-[#937237] hover:underline">{{ $booking->status === 'confirmed' ? 'Pending' : 'Confirm' }}</button>
                            </form>
                            <form action="{{ route('dashboard.events.bookings.update-status', $booking) }}" method="POST" class="inline ml-2">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Cancel this booking?');">Cancel</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $bookings->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>feather.replace();</script>
@endpush
