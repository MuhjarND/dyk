@extends('layouts.admin')
@section('title', 'Kelola Profil')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>Halaman Profil</h3>
        <a href="{{ route('admin.profile-pages.create') }}" class="btn btn-primary btn-sm">+ Tambah Halaman</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Slug</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
            <tr>
                <td>
                    <strong>{{ $page->title }}</strong>
                    @if($page->excerpt)
                    <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ Str::limit($page->excerpt, 70) }}</div>
                    @endif
                </td>
                <td>{{ $page->slug }}</td>
                <td>{{ $page->sort_order }}</td>
                <td><span class="badge {{ $page->is_active ? 'badge-success' : 'badge-warning' }}">{{ $page->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.profile-pages.edit', $page->id) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.profile-pages.destroy', $page->id) }}" onsubmit="return confirm('Yakin hapus halaman profil ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:40px;">Belum ada halaman profil.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
