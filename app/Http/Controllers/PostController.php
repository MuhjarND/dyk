<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;

class PostController extends Controller
{
    public function index()
    {
        $query = Post::with(['category', 'author'])->published();

        if (request('kategori')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', request('kategori'));
            });
        }

        if (request('cari')) {
            $search = request('cari');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%");
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(9);
        $categories = Category::withCount(['posts' => function ($q) {
            $q->where('status', 'published');
        }])->get();

        return view('berita', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::with(['category', 'author', 'media'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $post->increment('views');

        $related = Post::with('category')
            ->published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $popular = Post::with('category')
            ->published()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('detail', compact('post', 'related', 'popular'));
    }
}
