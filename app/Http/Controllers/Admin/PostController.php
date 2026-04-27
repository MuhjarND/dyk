<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $query = Post::with(['category', 'author']);

        if (!$user->isAdmin()) {
            $query->where('author_id', $user->id);
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('cari')) {
            $query->where('title', 'like', '%' . request('cari') . '%');
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'documentation' => 'required|array|min:1',
            'documentation.*' => 'file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,webm,mkv|max:51200',
        ]);

        $data = $request->only(['title', 'content', 'category_id', 'status']);
        $data['slug'] = Str::slug($request->title);
        $data['excerpt'] = Str::limit(strip_tags($request->content), 200);
        $data['author_id'] = auth()->id();

        // Ensure unique slug
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Post::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter++;
        }

        if ($request->status === 'published') {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = 'post_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $filename);
            $data['thumbnail'] = 'posts/' . $filename;
        }

        $post = Post::create($data);
        $this->storeDocumentation($post, $request->file('documentation', []));

        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil dibuat!');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        if (!auth()->user()->isAdmin() && $post->author_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('admin.posts.form', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if (!auth()->user()->isAdmin() && $post->author_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'documentation' => 'nullable|array',
            'documentation.*' => 'file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,webm,mkv|max:51200',
            'remove_media' => 'nullable|array',
            'remove_media.*' => 'integer',
        ]);

        $data = $request->only(['title', 'content', 'category_id', 'status']);
        $data['excerpt'] = Str::limit(strip_tags($request->content), 200);
        $removeMediaIds = collect($request->input('remove_media', []))->map(function ($id) {
            return (int) $id;
        })->filter();
        $existingMediaCount = $post->media()->count();
        $removableCount = $removeMediaIds->isEmpty()
            ? 0
            : $post->media()->whereIn('id', $removeMediaIds)->count();
        $newMediaCount = count($request->file('documentation', []));

        if (($existingMediaCount - $removableCount + $newMediaCount) <= 0) {
            return back()
                ->withErrors(['documentation' => 'Minimal satu dokumentasi kegiatan wajib tersedia.'])
                ->withInput();
        }

        if ($request->title !== $post->title) {
            $data['slug'] = Str::slug($request->title);
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Post::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        if ($request->status === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($post->thumbnail && file_exists(public_path('uploads/' . $post->thumbnail))) {
                unlink(public_path('uploads/' . $post->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = 'post_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $filename);
            $data['thumbnail'] = 'posts/' . $filename;
        }

        $post->update($data);
        $this->deleteMedia($post, $removeMediaIds->all());
        $this->storeDocumentation($post, $request->file('documentation', []));

        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (!auth()->user()->isAdmin() && $post->author_id !== auth()->id()) {
            abort(403);
        }

        if ($post->thumbnail && file_exists(public_path('uploads/' . $post->thumbnail))) {
            unlink(public_path('uploads/' . $post->thumbnail));
        }

        foreach ($post->media as $media) {
            if ($media->file_path && file_exists(public_path('uploads/' . $media->file_path))) {
                unlink(public_path('uploads/' . $media->file_path));
            }
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    protected function storeDocumentation(Post $post, array $files)
    {
        if (empty($files)) {
            return;
        }

        if (!file_exists(public_path('uploads/post-media'))) {
            mkdir(public_path('uploads/post-media'), 0755, true);
        }

        $currentOrder = (int) $post->media()->max('sort_order');

        foreach ($files as $file) {
            $filename = 'media_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/post-media'), $filename);

            $currentOrder++;

            $post->media()->create([
                'media_type' => $this->detectMediaType($file->getClientOriginalExtension()),
                'file_path' => 'post-media/' . $filename,
                'sort_order' => $currentOrder,
            ]);
        }
    }

    protected function deleteMedia(Post $post, array $mediaIds)
    {
        if (empty($mediaIds)) {
            return;
        }

        $mediaItems = $post->media()->whereIn('id', $mediaIds)->get();

        foreach ($mediaItems as $media) {
            if ($media->file_path && file_exists(public_path('uploads/' . $media->file_path))) {
                unlink(public_path('uploads/' . $media->file_path));
            }

            $media->delete();
        }
    }

    protected function detectMediaType($extension)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        return in_array(strtolower($extension), $imageExtensions, true) ? 'image' : 'video';
    }
}
