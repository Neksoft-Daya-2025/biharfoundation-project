<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                    ->orWhere('excerpt', 'like', "%{$s}%");
            });
        }

        $posts = $query->paginate(15);
        return view('dashboard.blog.index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('dashboard.blog.form', ['post' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'], null);
        $data['status'] = $request->input('status', 'draft');
        $data['published_at'] = ($data['status'] ?? '') === 'published' ? now() : null;
        $data['featured_image'] = $this->handleFeaturedImage($request, $data['featured_image'] ?? null);
        BlogPost::create($data);
        return redirect()->route('dashboard.blog')->with('success', 'Post created.');
    }

    public function edit(BlogPost $post)
    {
        return view('dashboard.blog.form', ['post' => $post]);
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $this->validatePost($request, $post);
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $post->slug, $post->id);
        $data['status'] = $request->input('status', 'draft');
        if (($data['status'] ?? '') === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        } elseif (($data['status'] ?? '') === 'draft') {
            $data['published_at'] = null;
        }
        $data['featured_image'] = $this->handleFeaturedImage($request, $data['featured_image'] ?? $post->featured_image, $post);
        $post->update($data);
        return redirect()->route('dashboard.blog')->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();
        return redirect()->route('dashboard.blog')->with('success', 'Post deleted.');
    }

    private function validatePost(Request $request, ?BlogPost $post = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:blog_posts,slug';
        if ($post) {
            $slugRule .= ',' . $post->id;
        }
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => $slugRule,
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:500',
            'featured_image_file' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ];
        $data = $request->validate($rules);
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        return $data;
    }

    /** Store uploaded image or keep existing URL/path. Returns path or URL string. */
    private function handleFeaturedImage(Request $request, ?string $fromForm, ?BlogPost $post = null): ?string
    {
        $file = $request->file('featured_image_file');
        if ($file) {
            if ($post && $post->featured_image && !Str::startsWith($post->featured_image, 'http')) {
                Storage::disk('public')->delete($post->featured_image);
            }
            return $file->store('blog', 'public');
        }
        $url = trim($fromForm ?? '');
        if ($url !== '') {
            return $url;
        }
        return $post ? $post->featured_image : null;
    }

    private function uniqueSlug(string $base, ?int $excludeId): string
    {
        $slug = Str::slug($base);
        $query = BlogPost::where('slug', $slug);
        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }
        if ($query->exists()) {
            $slug .= '-' . time();
        }
        return $slug;
    }
}
