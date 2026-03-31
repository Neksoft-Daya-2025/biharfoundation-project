<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    /**
     * List published blog posts (public).
     */
    public function index()
    {
        $posts = BlogPost::where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('blog', ['posts' => $posts]);
    }

    /**
     * Show a single published post by slug (public).
     */
    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('blog-show', ['post' => $post]);
    }
}
