@extends('layouts.admin')
@section('title', 'Kelola Kategori')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
    {{-- Form Tambah --}}
    <div class="form-card">
        <h3 style="margin-bottom:20px;">Tambah Kategori Baru</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="form-group">
                <label>Nama Kategori <span class="required">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Masukkan nama kategori" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat (opsional)">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    {{-- Daftar Kategori --}}
    <div class="data-card">
        <div class="data-card-header"><h3>Daftar Kategori</h3></div>
        <table class="data-table">
            <thead><tr><th>Nama</th><th>Berita</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td><strong>{{ $cat->name }}</strong></td>
                    <td><span class="badge badge-info">{{ $cat->posts_count }}</span></td>
                    <td>
                        <div class="actions">
                            <button class="btn btn-sm btn-outline" onclick="editCat({{ $cat->id }},'{{ $cat->name }}','{{ $cat->description }}')">Edit</button>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;padding:32px;">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Edit Modal (simple inline) --}}
<div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
    <div class="form-card" style="max-width:440px;width:100%;">
        <h3 style="margin-bottom:20px;">Edit Kategori</h3>
        <form method="POST" id="editForm">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="name" id="editName" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" id="editDesc" class="form-control" rows="3"></textarea>
            </div>
            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editModal').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function editCat(id, name, desc) {
    document.getElementById('editName').value = name;
    document.getElementById('editDesc').value = desc || '';
    document.getElementById('editForm').action = '{{ url("admin/categories") }}/' + id;
    document.getElementById('editModal').style.display = 'flex';
}
</script>
@endsection
