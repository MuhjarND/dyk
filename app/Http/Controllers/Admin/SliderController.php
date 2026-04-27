<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $sliders = Slider::with('post')->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $posts = Post::published()->orderBy('published_at', 'desc')->get();

        return view('admin.sliders.form', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $post = Post::findOrFail($request->post_id);
        $data = [
            'post_id' => $post->id,
            'title' => $post->title,
            'description' => $post->excerpt,
            'image' => $post->thumbnail ?: '',
        ];
        $data['sort_order'] = $request->filled('sort_order') ? (int) $request->sort_order : 0;
        $data['is_active'] = $request->has('is_active');

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        $posts = Post::published()->orderBy('published_at', 'desc')->get();

        return view('admin.sliders.form', compact('slider', 'posts'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $post = Post::findOrFail($request->post_id);
        $data = [
            'post_id' => $post->id,
            'title' => $post->title,
            'description' => $post->excerpt,
            'image' => $post->thumbnail ?: '',
        ];
        $data['sort_order'] = $request->filled('sort_order') ? (int) $request->sort_order : 0;
        $data['is_active'] = $request->has('is_active');

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil dihapus!');
    }
}
