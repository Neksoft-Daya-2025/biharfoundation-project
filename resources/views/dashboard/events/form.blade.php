@extends('layouts.dashboard')

@section('title', $event ? 'Edit Event' : 'Add Event')
@section('page-title', $event ? 'Edit Event' : 'Add Event')
@section('page-description', $event ? 'Update event details' : 'Create a new event')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('dashboard.events') }}" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Events
        </a>
    </div>

    <form action="{{ $event ? route('dashboard.events.update', $event) : route('dashboard.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if($event) @method('PUT') @endif

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $event->title ?? '') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('title') border-red-500 @enderror">
            @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('description') border-red-500 @enderror">{{ old('description', $event->description ?? '') }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_at" class="block text-sm font-medium text-gray-700 mb-1">Start date & time *</label>
                <input type="datetime-local" id="start_at" name="start_at" value="{{ old('start_at', $event ? $event->start_at?->format('Y-m-d\TH:i') : '') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('start_at') border-red-500 @enderror">
                @error('start_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="end_at" class="block text-sm font-medium text-gray-700 mb-1">End date & time</label>
                <input type="datetime-local" id="end_at" name="end_at" value="{{ old('end_at', $event && $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                @error('end_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="venue" class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
            <input type="text" id="venue" name="venue" value="{{ old('venue', $event->venue ?? '') }}" placeholder="e.g. Main Hall"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea id="address" name="address" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">{{ old('address', $event->address ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="price_per_ticket" class="block text-sm font-medium text-gray-700 mb-1">Price per ticket ({{ currency_symbol() }})</label>
                <input type="number" id="price_per_ticket" name="price_per_ticket" step="0.01" min="0" value="{{ old('price_per_ticket', $event->price_per_ticket ?? 0) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                <p class="text-xs text-gray-500 mt-1">0 = Free event</p>
            </div>
            <div>
                <label for="max_attendees" class="block text-sm font-medium text-gray-700 mb-1">Max attendees</label>
                <input type="number" id="max_attendees" name="max_attendees" min="0" value="{{ old('max_attendees', $event->max_attendees ?? '') }}" placeholder="Leave empty for unlimited"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Event image</label>
            @if($event && $event->image)
            <div class="mb-3">
                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="h-40 w-auto rounded-lg border border-gray-200 object-cover">
                <p class="text-xs text-gray-500 mt-1">Current image. Upload a new file or paste a URL below to replace.</p>
            </div>
            @endif
            <div class="space-y-2">
                <div>
                    <label for="image_upload" class="block text-xs font-medium text-gray-600 mb-1">Upload image</label>
                    <input type="file" id="image_upload" name="image_upload" accept="image/jpeg,image/png,image/gif,image/webp"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#937237] file:text-white file:cursor-pointer hover:file:bg-[#7a5d2e]">
                    <p class="text-xs text-gray-500 mt-1">JPEG, PNG, GIF or WebP. Max 5 MB.</p>
                    @error('image_upload')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="image" class="block text-xs font-medium text-gray-600 mb-1">Or use image URL</label>
                    <input type="text" id="image" name="image" value="{{ old('image', $event && $event->image && (str_starts_with($event->image, 'http://') || str_starts_with($event->image, 'https://')) ? $event->image : '') }}" placeholder="https://... or images/your-file.png"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none text-sm">
                    <p class="text-xs text-gray-500 mt-1">Full URL, or path from the site root such as <code class="text-gray-700">images/your-file.png</code> (not <code class="text-gray-700">public/</code> or <code class="text-gray-700">@public/</code>). Leave empty to keep the current image. Upload takes priority if both are set.</p>
                </div>
            </div>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
                <option value="draft" {{ old('status', $event->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $event->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="cancelled" {{ old('status', $event->status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Published events appear on the public events page</p>
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $event->sort_order ?? 0) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                {{ $event ? 'Update Event' : 'Create Event' }}
            </button>
            @if($event)
            <a href="{{ route('dashboard.events.show', $event) }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">Cancel</a>
            @endif
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>feather.replace();</script>
@endpush
