<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $totalPosts = Post::count();
            $publishedPosts = Post::published()->count();
            $draftPosts = Post::where('status', 'draft')->count();
            $totalViews = Post::sum('views');
            $totalUsers = User::count();
            $totalCategories = Category::count();
            $recentPosts = Post::with(['category', 'author'])->orderBy('created_at', 'desc')->take(5)->get();
        } else {
            $totalPosts = Post::where('author_id', $user->id)->count();
            $publishedPosts = Post::where('author_id', $user->id)->published()->count();
            $draftPosts = Post::where('author_id', $user->id)->where('status', 'draft')->count();
            $totalViews = Post::where('author_id', $user->id)->sum('views');
            $totalUsers = 0;
            $totalCategories = Category::count();
            $recentPosts = Post::with(['category', 'author'])->where('author_id', $user->id)->orderBy('created_at', 'desc')->take(5)->get();
        }

        return view('admin.dashboard', compact(
            'totalPosts', 'publishedPosts', 'draftPosts', 'totalViews',
            'totalUsers', 'totalCategories', 'recentPosts'
        ));
    }
}
