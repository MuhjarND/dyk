@extends('layouts.admin')
@section('title', isset($member) ? 'Edit Anggota' : 'Tambah Anggota')

@section('content')
<div class="form-card" style="max-width:720px;">
    <form method="POST" action="{{ isset($member) ? route('admin.members.update', $member->id) : route('admin.members.store') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($member)) @method('PUT') @endif

        <div class="form-group">
            <label>Nama <span class="required">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $member->name ?? '') }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 160px;gap:20px;">
            <div class="form-group">
                <label>Jabatan <span class="required">*</span></label>
                <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $member->position ?? '') }}" required>
                @error('position')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $member->sort_order ?? 0) }}" min="0">
                @error('sort_order')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label>Foto Anggota</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*" onchange="previewMemberPhoto(this)">
            <span class="form-hint">Format: JPG, PNG, GIF, WebP. Maks: 5MB.</span>
            @error('photo')<div class="form-error">{{ $message }}</div>@enderror
            <div class="thumbnail-preview" id="memberPhotoPreview">
                @if(isset($member) && $member->photo_url)
                <img src="{{ $member->photo_url }}" alt="{{ $member->name }}">
                @endif
            </div>
        </div>

        <div class="form-group">
            <label>Status Keanggotaan <span class="required">*</span></label>
            <select name="membership_status" class="form-control @error('membership_status') is-invalid @enderror" required>
                @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" {{ old('membership_status', $member->membership_status ?? 'anggota') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('membership_status')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Quotes</label>
            <textarea name="quote" class="form-control @error('quote') is-invalid @enderror" rows="4" placeholder="Tuliskan quote singkat anggota">{{ old('quote', $member->quote ?? '') }}</textarea>
            <span class="form-hint">Maksimal 500 karakter. Akan tampil di sisi kanan kartu anggota.</span>
            @error('quote')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ isset($member) ? 'Perbarui Anggota' : 'Simpan Anggota' }}</button>
            <a href="{{ route('admin.members.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>

<script>
function previewMemberPhoto(input) {
    var preview = document.getElementById('memberPhotoPreview');

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview foto anggota">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
