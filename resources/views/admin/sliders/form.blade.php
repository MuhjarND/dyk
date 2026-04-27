@extends('layouts.admin')
@section('title', isset($slider) ? 'Edit Slider' : 'Tambah Slider')

@section('content')
<div class="form-card" style="max-width:760px;">
    <form method="POST" action="{{ isset($slider) ? route('admin.sliders.update', $slider->id) : route('admin.sliders.store') }}">
        @csrf
        @if(isset($slider)) @method('PUT') @endif

        <div class="form-group">
            <label>Pilih Berita <span class="required">*</span></label>
            <select
                name="post_id"
                id="sliderPostSelect"
                class="form-control @error('post_id') is-invalid @enderror"
                {{ $posts->isEmpty() ? 'disabled' : '' }}
            >
                <option value="">-- Pilih berita untuk ditampilkan di slider --</option>
                @foreach($posts as $post)
                <option
                    value="{{ $post->id }}"
                    data-title="{{ e($post->title) }}"
                    data-excerpt="{{ e($post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->content), 140)) }}"
                    data-image="{{ $post->thumbnail ? asset('uploads/' . $post->thumbnail) : asset('logo_web.png') }}"
                    data-date="{{ optional($post->published_at)->format('d M Y') }}"
                    {{ (string) old('post_id', $slider->post_id ?? '') === (string) $post->id ? 'selected' : '' }}
                >
                    {{ $post->title }}
                </option>
                @endforeach
            </select>
            <span class="form-hint">Slider akan mengambil judul, ringkasan, dan thumbnail dari berita yang dipilih.</span>
            @error('post_id')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div class="form-group">
                <label>Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $slider->sort_order ?? 0) }}" min="0">
                @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;">
                <label style="display:flex;align-items:center;gap:10px;margin:0;font-weight:500;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', isset($slider) ? $slider->is_active : true) ? 'checked' : '' }}>
                    Slider aktif
                </label>
            </div>
        </div>

        <div class="form-group">
            <label>Preview Berita</label>
            <div id="sliderPostPreview" style="display:grid;grid-template-columns:220px 1fr;gap:20px;padding:20px;border:1px solid var(--border);border-radius:16px;background:#fff8fb;min-height:180px;">
                <div style="border-radius:14px;overflow:hidden;background:#f4f4f4;min-height:140px;display:flex;align-items:center;justify-content:center;">
                    <img
                        id="sliderPostPreviewImage"
                        src="{{ isset($slider) ? $slider->image_url : asset('logo_web.png') }}"
                        alt="Preview slider"
                        style="width:100%;height:100%;object-fit:cover;{{ isset($slider) || old('post_id') ? '' : 'display:none;' }}"
                    >
                    <span id="sliderPostPreviewEmpty" style="{{ isset($slider) || old('post_id') ? 'display:none;' : '' }}color:var(--text-muted);font-size:14px;">Pilih berita untuk melihat preview</span>
                </div>
                <div>
                    <h4 id="sliderPostPreviewTitle" style="margin-bottom:10px;color:var(--text-dark);">
                        {{ old('post_id') || isset($slider) ? ($slider->display_title ?? 'Judul berita') : 'Judul berita akan tampil di sini' }}
                    </h4>
                    <div id="sliderPostPreviewDate" style="font-size:13px;color:var(--text-muted);margin-bottom:10px;">
                        {{ isset($slider) && optional($slider->post)->published_at ? $slider->post->published_at->format('d M Y') : '' }}
                    </div>
                    <p id="sliderPostPreviewExcerpt" style="margin:0;color:var(--text-body);line-height:1.7;">
                        {{ old('post_id') || isset($slider) ? ($slider->display_description ?: 'Ringkasan berita akan ditampilkan di slider.') : 'Ringkasan berita akan otomatis diambil dari konten berita yang dipilih.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" {{ $posts->isEmpty() ? 'disabled' : '' }}>{{ isset($slider) ? 'Perbarui Slider' : 'Simpan Slider' }}</button>
            <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline">Batal</a>
        </div>

        @if($posts->isEmpty())
        <div class="alert alert-error" style="margin-top:18px;">
            Belum ada berita berstatus terbit. Buat atau publikasikan berita terlebih dahulu sebelum menambahkan slider.
        </div>
        @endif
    </form>
</div>

<script>
function syncSliderPostPreview() {
    var select = document.getElementById('sliderPostSelect');
    var option = select ? select.options[select.selectedIndex] : null;
    var image = document.getElementById('sliderPostPreviewImage');
    var empty = document.getElementById('sliderPostPreviewEmpty');
    var title = document.getElementById('sliderPostPreviewTitle');
    var date = document.getElementById('sliderPostPreviewDate');
    var excerpt = document.getElementById('sliderPostPreviewExcerpt');

    if (!option || !option.value) {
        image.style.display = 'none';
        image.removeAttribute('src');
        empty.style.display = 'inline';
        title.textContent = 'Judul berita akan tampil di sini';
        date.textContent = '';
        excerpt.textContent = 'Ringkasan berita akan otomatis diambil dari konten berita yang dipilih.';
        return;
    }

    image.src = option.getAttribute('data-image');
    image.style.display = 'block';
    empty.style.display = 'none';
    title.textContent = option.getAttribute('data-title');
    date.textContent = option.getAttribute('data-date') || '';
    excerpt.textContent = option.getAttribute('data-excerpt') || 'Ringkasan berita akan ditampilkan di slider.';
}

document.addEventListener('DOMContentLoaded', function () {
    var select = document.getElementById('sliderPostSelect');

    if (!select) {
        return;
    }

    select.addEventListener('change', syncSliderPostPreview);
    syncSliderPostPreview();
});
</script>
@endsection
