<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProfilePage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfilePageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $pages = ProfilePage::orderBy('sort_order')->orderBy('title')->get();

        return view('admin.profile-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.profile-pages.form');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->makeUniqueSlug($request->title);
        $data['is_active'] = $request->has('is_active');

        ProfilePage::create($data);

        return redirect()->route('admin.profile-pages.index')
            ->with('success', 'Halaman profil berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $page = ProfilePage::findOrFail($id);

        return view('admin.profile-pages.form', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = ProfilePage::findOrFail($id);
        $data = $this->validatedData($request);
        $data['is_active'] = $request->has('is_active');

        if ($request->title !== $page->title) {
            $data['slug'] = $this->makeUniqueSlug($request->title, $page->id);
        }

        $page->update($data);

        return redirect()->route('admin.profile-pages.index')
            ->with('success', 'Halaman profil berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $page = ProfilePage::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.profile-pages.index')
            ->with('success', 'Halaman profil berhasil dihapus!');
    }

    protected function validatedData(Request $request)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'nullable|max:500',
            'content' => 'required',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }

    protected function makeUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (ProfilePage::where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }
}
