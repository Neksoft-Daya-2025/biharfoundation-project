@extends('layouts.dashboard')

@section('title', 'Product Categories')
@section('page-title', 'Product Categories')
@section('page-description', 'Manage menu categories for products')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Product Categories</h2>
            <p class="text-sm text-gray-600 mt-1">Categories group products on the menu (e.g. Fish Dishes, Drinks).</p>
        </div>
        <a href="{{ route('dashboard.categories.create') }}" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="plus" class="w-4 h-4"></i>
            Add Category
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Active</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $category->products_count ?? $category->products()->count() }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $category->sort_order }}</td>
                        <td class="px-6 py-4 text-sm">{{ $category->is_active ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('dashboard.categories.edit', $category) }}" class="text-[#937237] hover:underline">Edit</a>
                            <form action="{{ route('dashboard.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category? Products in it will need another category.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">No categories yet. <a href="{{ route('dashboard.categories.create') }}" class="text-[#937237] hover:underline">Add one</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
