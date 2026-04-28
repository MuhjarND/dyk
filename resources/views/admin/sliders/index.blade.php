@extends('layouts.admin')
@section('title', 'Kelola Slider')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>Daftar Slider</h3>
        <div class="header-actions">
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">+ Tambah Slider</a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Preview</th>
                <th>Berita</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sliders as $slider)
            <tr>
                <td style="width:150px;">
                    <img src="{{ $slider->image_url }}" alt="{{ $slider->display_title }}" style="width:120px;height:68px;object-fit:cover;border-radius:10px;border:1px solid var(--border);">
                </td>
                <td>
                    <strong>{{ $slider->display_title }}</strong>
                    @if($slider->post)
                    <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ optional($slider->post->published_at)->format('d/m/Y') ?: 'Belum ada tanggal publikasi' }}</div>
                    @endif
                    @if($slider->display_description)
                    <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ \Illuminate\Support\Str::limit($slider->display_description, 80) }}</div>
                    @endif
                    @unless($slider->post)
                    <div style="font-size:12px;color:#b45309;margin-top:4px;">Berita asal tidak ditemukan. Pilih ulang berita ini.</div>
                    @endunless
                </td>
                <td>{{ $slider->sort_order }}</td>
                <td>
                    <span class="badge {{ $slider->is_active ? 'badge-success' : 'badge-warning' }}">
                        {{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>{{ $slider->created_at->format('d/m/Y') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.sliders.destroy', $slider->id) }}" onsubmit="return confirm('Yakin hapus slider ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;">Belum ada slider berita.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
