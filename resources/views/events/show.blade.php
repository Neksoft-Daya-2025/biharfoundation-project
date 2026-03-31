@extends('layouts.app')

@section('title', $event->title)
@section('description', $event->description ? Str::limit($event->description, 160) : 'Book tickets for ' . $event->title)

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('events.index') }}" class="text-[#937237] hover:underline mb-6 inline-block">← Back to events</a>

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            @if($event->image_url)
            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-64 object-cover">
            @endif
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-4">
                    <span><strong>Date:</strong> {{ $event->start_at->format('l, d M Y') }}</span>
                    <span><strong>Time:</strong> {{ $event->start_at->format('H:i') }}@if($event->end_at) – {{ $event->end_at->format('H:i') }}@endif</span>
                    @if($event->venue)<span><strong>Venue:</strong> {{ $event->venue }}</span>@endif
                    @if($event->address)<span><strong>Address:</strong> {{ $event->address }}</span>@endif
                </div>
                @if($event->description)
                <div class="prose text-gray-600 mb-6">{{ nl2br(e($event->description)) }}</div>
                @endif
                @if($event->ticketTypes->isEmpty())
                <p class="text-xl font-semibold text-[#937237]">
                    @if($event->price_per_ticket > 0)
                        {{ format_money($event->price_per_ticket) }} per ticket
                    @else
                        Free event
                    @endif
                </p>
                @else
                <div class="space-y-2">
                    <p class="text-sm font-medium text-gray-700">Ticket types &amp; seats</p>
                    <ul class="space-y-1 text-sm text-gray-600">
                        @foreach($event->ticketTypes as $type)
                        <li>
                            <strong>{{ $type->name }}</strong> – {{ format_money($type->price) }} each · {{ $type->seats_left }} seat(s) left
                            @if($type->description)<span class="text-gray-500">({{ Str::limit($type->description, 40) }})</span>@endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        @if($event->ticketTypes->isNotEmpty())
        {{-- Ticket types booking form --}}
        @php $hasSeats = $event->ticketTypes->contains(fn($t) => $t->seats_left > 0); @endphp
        @if($hasSeats)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Book tickets</h2>
            <p class="text-sm text-gray-500 mb-4">Select quantity for each ticket type. At least one ticket required.</p>
            <form action="{{ route('events.book', $event) }}" method="POST" class="space-y-4">
                @csrf
                <div class="border border-gray-200 rounded-lg divide-y divide-gray-200 overflow-hidden">
                    @foreach($event->ticketTypes as $type)
                    @if($type->seats_left > 0)
                    <div class="px-4 py-3 flex flex-wrap items-center justify-between gap-4 bg-gray-50/50">
                        <div>
                            <span class="font-medium text-gray-900">{{ $type->name }}</span>
                            <span class="text-sm text-gray-600 ml-2">{{ format_money($type->price) }} each</span>
                            <span class="text-xs text-gray-500 ml-2">({{ $type->seats_left }} left)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <label for="ticket_types_{{ $type->id }}" class="text-sm text-gray-600">Qty</label>
                            <select id="ticket_types_{{ $type->id }}" name="ticket_types[{{ $type->id }}]" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] outline-none text-sm">
                                @for($i = 0; $i <= min(10, $type->seats_left); $i++)
                                <option value="{{ $i }}" {{ (int)old('ticket_types.'.$type->id, 0) === $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Your name *</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('customer_name') border-red-500 @enderror">
                        @error('customer_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('customer_email') border-red-500 @enderror">
                        @error('customer_email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                    <textarea id="notes" name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">{{ old('notes') }}</textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-[#937237] hover:bg-[#7a5d2e] text-white font-semibold rounded-lg transition-colors">
                        Confirm booking
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center text-amber-800">
            <p class="font-medium">This event is sold out.</p>
        </div>
        @endif
        @else
        {{-- Single price booking form (no ticket types) --}}
        @php
            $spotsLeft = $event->max_attendees ? max(0, $event->max_attendees - $event->total_booked) : null;
            $maxQty = $spotsLeft !== null ? min(10, $spotsLeft) : 10;
        @endphp
        @if($maxQty > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Book tickets</h2>
            @if($event->max_attendees)
            <p class="text-sm text-gray-500 mb-4">{{ $spotsLeft }} spot(s) left</p>
            @endif
            <form action="{{ route('events.book', $event) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Your name *</label>
                        <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('customer_name') border-red-500 @enderror">
                        @error('customer_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                        <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('customer_email') border-red-500 @enderror">
                        @error('customer_email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                </div>
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Number of tickets *</label>
                    <select id="quantity" name="quantity" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('quantity') border-red-500 @enderror">
                        @for($i = 1; $i <= $maxQty; $i++)
                        <option value="{{ $i }}" {{ old('quantity') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                    <textarea id="notes" name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">{{ old('notes') }}</textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-[#937237] hover:bg-[#7a5d2e] text-white font-semibold rounded-lg transition-colors">
                        Confirm booking
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center text-amber-800">
            <p class="font-medium">This event is sold out.</p>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
