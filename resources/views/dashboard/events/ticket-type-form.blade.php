@extends('layouts.dashboard')

@section('title', $ticketType ? 'Edit Ticket Type' : 'Add Ticket Type')
@section('page-title', $ticketType ? 'Edit Ticket Type' : 'Add Ticket Type')
@section('page-description', $event->title)

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('dashboard.events.show', $event) }}" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to {{ $event->title }}
        </a>
    </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ $ticketType ? route('dashboard.events.ticket-types.update', [$event, $ticketType]) : route('dashboard.events.ticket-types.store', $event) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if($ticketType) @method('PUT') @endif

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Ticket type name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $ticketType->name ?? '') }}" required placeholder="e.g. General Admission, VIP"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('name') border-red-500 @enderror">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">{{ old('description', $ticketType->description ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ({{ currency_symbol() }}) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $ticketType->price ?? 0) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('price') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">0 = Free</p>
                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Number of seats *</label>
                <input type="number" id="quantity" name="quantity" min="{{ $ticketType ? $ticketType->sold : 0 }}" value="{{ old('quantity', $ticketType->quantity ?? 1) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('quantity') border-red-500 @enderror">
                @if($ticketType && $ticketType->sold > 0)
                <p class="text-xs text-amber-600 mt-1">Already sold: {{ $ticketType->sold }}. Cannot set seats below this.</p>
                @endif
                @error('quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $ticketType->sort_order ?? 0) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                {{ $ticketType ? 'Update Ticket Type' : 'Add Ticket Type' }}
            </button>
            <a href="{{ route('dashboard.events.show', $event) }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>feather.replace();</script>
@endpush
