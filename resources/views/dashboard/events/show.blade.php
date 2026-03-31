@extends('layouts.dashboard')

@section('title', $event->title)
@section('page-title', $event->title)
@section('page-description', 'Event details and bookings')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <a href="{{ route('dashboard.events') }}" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Events
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.events.edit', $event) }}" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="edit-2" class="w-4 h-4"></i> Edit
            </a>
            <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="external-link" class="w-4 h-4"></i> View public page
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Event details</h3>
                @if($event->image_url)
                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                @endif
                @if($event->description)
                <p class="text-gray-600 mb-4">{{ $event->description }}</p>
                @endif
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <dt class="text-gray-500">Start</dt>
                    <dd class="font-medium text-gray-900">{{ $event->start_at?->format('l, d M Y H:i') }}</dd>
                    @if($event->end_at)
                    <dt class="text-gray-500">End</dt>
                    <dd class="font-medium text-gray-900">{{ $event->end_at->format('l, d M Y H:i') }}</dd>
                    @endif
                    @if($event->venue)
                    <dt class="text-gray-500">Venue</dt>
                    <dd class="font-medium text-gray-900">{{ $event->venue }}</dd>
                    @endif
                    @if($event->address)
                    <dt class="text-gray-500">Address</dt>
                    <dd class="font-medium text-gray-900">{{ $event->address }}</dd>
                    @endif
                    <dt class="text-gray-500">Price</dt>
                    <dd class="font-medium text-gray-900">{{ $event->price_per_ticket > 0 ? format_money($event->price_per_ticket) . ' / ticket' : 'Free' }}</dd>
                    <dt class="text-gray-500">Status</dt>
                    <dd>
                        @if($event->status === 'published')
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Published</span>
                        @elseif($event->status === 'cancelled')
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Cancelled</span>
                        @else
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Draft</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h4 class="font-bold text-gray-900 mb-2">Bookings summary</h4>
                <p class="text-3xl font-bold text-[#937237]">{{ $event->total_booked }}</p>
                <p class="text-sm text-gray-500">tickets booked</p>
                @if($event->has_ticket_types)
                <p class="text-sm text-gray-600 mt-2">{{ $event->ticketTypes->sum('quantity') }} total seats</p>
                @elseif($event->max_attendees)
                <p class="text-sm text-gray-600 mt-2">Capacity: {{ $event->max_attendees }}</p>
                @endif
            </div>
        </div>
    </div>

    @if($event->ticketTypes->isNotEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Ticket types &amp; seats</h3>
            <a href="{{ route('dashboard.events.ticket-types.create', $event) }}" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2 text-sm">
                <i data-feather="plus" class="w-4 h-4"></i> Add ticket type
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Seats</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Sold</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Left</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($event->ticketTypes as $type)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">{{ $type->name }}</span>
                            @if($type->description)<p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($type->description, 50) }}</p>@endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ format_money($type->price) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $type->quantity }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $type->sold }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $type->seats_left }}</td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('dashboard.events.ticket-types.edit', [$event, $type]) }}" class="text-[#937237] hover:underline">Edit</a>
                            @if(!$type->bookingItems()->exists())
                            <form action="{{ route('dashboard.events.ticket-types.destroy', [$event, $type]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this ticket type?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Ticket types &amp; seats</h3>
            <a href="{{ route('dashboard.events.ticket-types.create', $event) }}" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2 text-sm">
                <i data-feather="plus" class="w-4 h-4"></i> Add ticket type
            </a>
        </div>
        <div class="p-6 text-center text-gray-500">
            <p>No ticket types yet. Add ticket types to manage seats and pricing per type (e.g. VIP, General).</p>
            <p class="text-sm mt-2">Without ticket types, the event uses a single price and optional max attendees.</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Bookings &amp; Attendees</h3>
            <a href="{{ route('dashboard.events.attendees', ['event_id' => $event->id]) }}" class="text-sm text-[#937237] hover:underline">View all attendees</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($event->bookings as $booking)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-mono text-sm text-gray-900">{{ $booking->booking_reference }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="font-medium text-gray-900">{{ $booking->customer_name }}</div>
                            <div class="text-gray-500">{{ $booking->customer_email }}</div>
                            @if($booking->items->isNotEmpty())
                            <div class="text-xs text-gray-500 mt-1">
                                @foreach($booking->items as $item)
                                {{ $item->ticketType->name ?? 'N/A' }}: {{ $item->quantity }} @ {{ format_money($item->unit_price) }}<br>
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
                            @if($booking->status !== 'cancelled')
                            <form action="{{ route('dashboard.events.bookings.update-status', $booking) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="{{ $booking->status === 'confirmed' ? 'pending' : 'confirmed' }}">
                                <button type="submit" class="text-[#937237] hover:underline">{{ $booking->status === 'confirmed' ? 'Set Pending' : 'Confirm' }}</button>
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
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No bookings yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>feather.replace();</script>
@endpush
