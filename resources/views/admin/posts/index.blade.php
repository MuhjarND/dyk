@extends('layouts.admin')
@section('title', 'Kelola Berita')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>Daftar Berita</h3>
        <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="search-bar" style="max-width:260px;">
                <input type="text" name="cari" placeholder="Cari..." value="{{ request('cari') }}" style="padding:8px 12px;">
                <button type="submit" style="padding:8px 14px;">Cari</button>
            </form>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">+ Buat Berita</a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Dilihat</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td style="max-width:260px;"><strong>{{ Str::limit($post->title, 45) }}</strong></td>
                <td>{{ $post->category->name ?? '-' }}</td>
                <td>{{ $post->author->name ?? '-' }}</td>
                <td><span class="badge {{ $post->status === 'published' ? 'badge-success' : 'badge-warning' }}">{{ $post->status === 'published' ? 'Publik' : 'Draft' }}</span></td>
                <td>{{ $post->views }}</td>
                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" onsubmit="return confirm('Yakin hapus berita ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:40px;">Belum ada berita.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($posts->hasPages())
<div class="pagination-wrapper" style="margin-top:24px;">
    {{ $posts->appends(request()->query())->links() }}
</div>
@endif
@endsection
