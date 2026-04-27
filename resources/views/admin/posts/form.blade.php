@extends('layouts.admin')
@section('title', isset($post) ? 'Edit Berita' : 'Buat Berita Baru')

@section('content')
<div class="form-card">
    <form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($post)) @method('PUT') @endif

        <div class="form-group">
            <label>Judul Berita <span class="required">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}" placeholder="Masukkan judul berita" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status <span class="required">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Publikasikan</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*" onchange="previewThumb(this)">
            <span class="form-hint">Format: JPG, PNG, GIF, WebP. Maks: 5MB.</span>
            <div class="thumbnail-preview" id="thumbPreview">
                @if(isset($post) && $post->thumbnail)
                <img src="{{ asset('uploads/' . $post->thumbnail) }}" alt="Thumbnail">
                @endif
            </div>
        </div>

        <div class="form-group">
            <label>Konten Berita <span class="required">*</span></label>
            <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror" rows="15" placeholder="Tulis konten berita di sini..." required>{{ old('content', $post->content ?? '') }}</textarea>
            @error('content')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Dokumentasi Kegiatan <span class="required">*</span></label>
            <input type="file" name="documentation[]" class="form-control @error('documentation') is-invalid @enderror @error('documentation.*') is-invalid @enderror" accept="image/*,video/*" multiple>
            <span class="form-hint">Wajib diisi. Boleh upload beberapa foto atau video kegiatan sekaligus.</span>
            @error('documentation')<div class="form-error">{{ $message }}</div>@enderror
            @error('documentation.*')<div class="form-error">{{ $message }}</div>@enderror

            @if(isset($post) && $post->media->count() > 0)
            <div class="media-manage-grid">
                @foreach($post->media as $media)
                <label class="media-manage-card">
                    <div class="media-manage-preview">
                        @if($media->isImage())
                        <img src="{{ $media->file_url }}" alt="Dokumentasi">
                        @else
                        <video src="{{ $media->file_url }}" controls preload="metadata"></video>
                        @endif
                    </div>
                    <span class="media-manage-remove">
                        <input type="checkbox" name="remove_media[]" value="{{ $media->id }}">
                        Hapus media ini
                    </span>
                </label>
                @endforeach
            </div>
            @endif
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Perbarui Berita' : 'Simpan Berita' }}</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

<script>
function previewThumb(input) {
    var preview = document.getElementById('thumbPreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) { preview.innerHTML = '<img src="'+e.target.result+'">'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
