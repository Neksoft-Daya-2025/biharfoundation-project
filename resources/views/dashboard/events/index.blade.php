@extends('layouts.dashboard')

@section('title', 'Events')
@section('page-title', 'Event Management')
@section('page-description', 'Create and manage events and ticket bookings')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Events</h2>
            <p class="text-sm text-gray-600 mt-1">Create events and manage bookings</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.events.attendees') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="users" class="w-4 h-4"></i>
                Attendees
            </a>
            <a href="{{ route('dashboard.events.create') }}" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i data-feather="plus" class="w-4 h-4"></i>
                Add Event
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date & Venue</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Bookings</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($events as $event)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">{{ $event->title }}</span>
                            @if($event->description)
                            <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($event->description, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div>{{ $event->start_at?->format('d M Y, H:i') }}</div>
                            @if($event->venue)<div class="text-xs text-gray-500">{{ $event->venue }}</div>@endif
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ $event->price_per_ticket > 0 ? format_money($event->price_per_ticket) . ' / ticket' : 'Free' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $event->bookings->whereIn('status', ['pending','confirmed'])->sum('quantity') }}
                            @if($event->max_attendees) / {{ $event->max_attendees }} @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($event->status === 'published')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Published</span>
                            @elseif($event->status === 'cancelled')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">Cancelled</span>
                            @else
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('dashboard.events.show', $event) }}" class="text-gray-600 hover:text-[#937237] hover:underline">View</a>
                            <a href="{{ route('dashboard.events.edit', $event) }}" class="text-[#937237] hover:underline">Edit</a>
                            <form action="{{ route('dashboard.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Delete this event? All bookings will be deleted.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No events yet. <a href="{{ route('dashboard.events.create') }}" class="text-[#937237] hover:underline">Create one</a></td>
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
