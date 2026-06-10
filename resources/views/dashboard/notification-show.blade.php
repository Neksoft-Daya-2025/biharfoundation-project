@extends('layouts.dashboard')

@section('title', 'Notification')
@section('page-title', 'Notification')
@section('page-description', 'Notification details')

@push('styles')
<style>
    .type-badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; }
    .type-order { background: #dbeafe; color: #1e40af; }
    .type-system { background: #e5e7eb; color: #374151; }
    .type-info { background: #d1fae5; color: #065f46; }
    .type-warning { background: #fef3c7; color: #92400e; }
    .type-success { background: #d1fae5; color: #047857; }
</style>
@endpush

@section('content')
@php
    $typeClass = match ($notification->type) {
        'order' => 'type-order',
        'system' => 'type-system',
        'info' => 'type-info',
        'warning' => 'type-warning',
        'success' => 'type-success',
        default => 'bg-gray-100 text-gray-800',
    };
    $relatedLink = $notification->data['link'] ?? null;
@endphp

<div class="max-w-3xl space-y-6">
    <a href="{{ route('dashboard.notifications') }}" class="inline-flex items-center gap-2 text-[#937237] hover:underline">
        <i data-feather="arrow-left" class="w-4 h-4"></i>
        Back to notifications
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-2 flex-wrap mb-4">
            <span class="type-badge {{ $typeClass }}">{{ $notification->type }}</span>
            <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
            @if($notification->isRead())
                <span class="text-xs font-medium text-gray-500">Read</span>
            @endif
        </div>

        <h2 class="text-2xl font-bold text-gray-900">{{ $notification->title }}</h2>

        @if($notification->message)
            <p class="text-gray-600 mt-4 leading-relaxed">{{ $notification->message }}</p>
        @endif

        @if($relatedLink)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <a href="{{ $relatedLink }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                    <i data-feather="external-link" class="w-4 h-4"></i>
                    Open related item
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.dispatchEvent(new CustomEvent('notifications:updated', {
        detail: { unread_count: {{ (int) $unreadCount }} }
    }));
    feather.replace();
</script>
@endpush
