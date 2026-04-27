@extends('layouts.admin')
@section('title', isset($page) ? 'Edit Halaman Profil' : 'Tambah Halaman Profil')

@section('content')
<div class="form-card" style="max-width:860px;">
    <form method="POST" action="{{ isset($page) ? route('admin.profile-pages.update', $page->id) : route('admin.profile-pages.store') }}">
        @csrf
        @if(isset($page)) @method('PUT') @endif

        <div class="form-group">
            <label>Judul Halaman <span class="required">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title ?? '') }}" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 180px;gap:20px;">
            <div class="form-group">
                <label>Ringkasan Singkat</label>
                <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror" rows="3">{{ old('excerpt', $page->excerpt ?? '') }}</textarea>
                @error('excerpt')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $page->sort_order ?? 0) }}" min="0">
                @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Konten Halaman <span class="required">*</span></label>
            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="16" required>{{ old('content', $page->content ?? '') }}</textarea>
            <span class="form-hint">Konten mendukung HTML sederhana seperti paragraf, heading, list, dan strong.</span>
            @error('content')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label style="display:flex;align-items:center;gap:10px;margin:0;font-weight:500;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', isset($page) ? $page->is_active : true) ? 'checked' : '' }}>
                Halaman aktif
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ isset($page) ? 'Perbarui Halaman' : 'Simpan Halaman' }}</button>
            <a href="{{ route('admin.profile-pages.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
