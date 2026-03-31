@extends('layouts.dashboard')

@section('title', $category ? 'Edit Category' : 'Add Category')
@section('page-title', $category ? 'Edit Category' : 'Add Category')
@section('page-description', $category ? 'Update category details' : 'Create a new product category')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('dashboard.categories') }}" class="text-[#937237] hover:underline flex items-center gap-2">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Back to Categories
        </a>
    </div>

    <form action="{{ $category ? route('dashboard.categories.update', $category) : route('dashboard.categories.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
        @csrf
        @if($category) @method('PUT') @endif

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required placeholder="e.g. Fish Dishes"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('name') border-red-500 @enderror">
            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug ?? '') }}" placeholder="e.g. fish (leave blank to auto-generate)"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('slug') border-red-500 @enderror">
            @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none @error('description') border-red-500 @enderror">{{ old('description', $category->description ?? '') }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none">
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-[#937237] focus:ring-[#937237]">
                <span class="text-sm font-medium text-gray-700">Active (show on menu)</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors">
                {{ $category ? 'Update' : 'Create' }} Category
            </button>
            <a href="{{ route('dashboard.categories') }}" class="px-6 py-2 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">Cancel</a>
        </div>
    </form>
</div>
@endsection
