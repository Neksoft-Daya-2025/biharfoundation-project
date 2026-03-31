@extends('layouts.dashboard')

@section('title', $product ? 'Edit Product' : 'Add Product')
@section('page-title', $product ? 'Edit Product' : 'Add Product')
@section('page-description', $product ? 'Update product details' : 'Create a new product')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('dashboard.products') }}" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Products
        </a>
    </div>

    <form action="{{ $product ? route('dashboard.products.update', $product) : route('dashboard.products.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if($product) @method('PUT') @endif

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('name') border-red-500 @enderror">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('description') border-red-500 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ({{ currency_symbol() }}) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('price') border-red-500 @enderror">
                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                <select id="category_id" name="category_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('category_id') border-red-500 @enderror">
                    <option value="">Select category</option>
                    @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image URL</label>
            <input type="text" id="image" name="image" value="{{ old('image', $product->image ?? '') }}" placeholder="https://..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
            @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="allergens" class="block text-sm font-medium text-gray-700 mb-1">Allergens (comma-separated)</label>
            <input type="text" id="allergens" name="allergens" value="{{ old('allergens', $product && $product->allergens ? implode(', ', $product->allergens) : '') }}" placeholder="e.g. nuts, gluten"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $product->is_popular ?? false) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-[#937237] focus:ring-[#937237]">
                <span class="text-sm font-medium text-gray-700">Popular</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-[#937237] focus:ring-[#937237]">
                <span class="text-sm font-medium text-gray-700">Available</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                {{ $product ? 'Update' : 'Create' }} Product
            </button>
            <a href="{{ route('dashboard.products') }}" class="px-6 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
