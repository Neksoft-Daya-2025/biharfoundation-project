@extends('layouts.dashboard')

@section('title', 'Blog')
@section('page-title', 'Blog')
@section('page-description', 'Manage blog posts')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Blog posts</h2>
            <p class="text-sm text-gray-600 mt-1">Create, edit, and publish posts.</p>
        </div>
        <a href="{{ route('dashboard.blog.create') }}" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="plus" class="w-4 h-4"></i>
            New post
        </a>
    </div>

    <form method="GET" action="{{ route('dashboard.blog') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex flex-wrap items-center gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
            class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] focus:border-[#937237] outline-none w-64">
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#937237] outline-none">
            <option value="">All statuses</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-[#937237] hover:bg-[#7a5d2e] text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i data-feather="search" class="w-4 h-4"></i> Filter
        </button>
    </form>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-16">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Published</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Updated</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($post->featured_image_url)
                            <img src="{{ $post->featured_image_url }}" alt="" class="w-12 h-12 object-cover rounded border border-gray-200">
                            @else
                            <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">{{ $post->title }}</span>
                            @if($post->excerpt)
                            <p class="text-xs text-gray-500 mt-0.5">{{ Str::limit($post->excerpt, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $post->slug }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $post->status }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $post->published_at ? $post->published_at->format('M d, Y') : '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $post->updated_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right text-sm space-x-2">
                            <a href="{{ route('dashboard.blog.edit', $post) }}" class="text-[#937237] hover:underline">Edit</a>
                            <form action="{{ route('dashboard.blog.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No posts yet. <a href="{{ route('dashboard.blog.create') }}" class="text-[#937237] hover:underline">Create one</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $posts->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
