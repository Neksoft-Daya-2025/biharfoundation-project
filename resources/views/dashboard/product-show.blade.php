@extends('layouts.dashboard')

@section('title', 'View Product')
@section('page-title', $product->name)
@section('page-description', 'Product details')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('dashboard.products') }}" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Products
        </a>
        <a href="{{ route('dashboard.products.edit', $product) }}" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="edit-2" class="w-4 h-4"></i> Edit
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($product->image)
        <div class="aspect-video bg-gray-100 flex items-center justify-center p-4">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="max-h-64 w-auto object-contain">
        </div>
        @endif
        <div class="p-6 space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Name</h3>
                <p class="text-lg font-semibold text-gray-900">{{ $product->name }}</p>
            </div>
            @if($product->description)
            <div>
                <h3 class="text-sm font-medium text-gray-500">Description</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $product->description }}</p>
            </div>
            @endif
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Price</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ format_money($product->price) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Category</h3>
                    <p class="text-gray-900">{{ $product->productCategory?->name ?? '—' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Popular</h3>
                    <p class="text-gray-900">{{ $product->is_popular ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Available</h3>
                    <p class="text-gray-900">{{ $product->is_available ? 'Yes' : 'No' }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Sort order</h3>
                <p class="text-gray-900">{{ $product->sort_order }}</p>
            </div>
            @if($product->allergens && count($product->allergens) > 0)
            <div>
                <h3 class="text-sm font-medium text-gray-500">Allergens</h3>
                <p class="text-gray-900">{{ implode(', ', $product->allergens) }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
