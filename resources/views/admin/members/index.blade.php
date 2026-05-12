@extends('layouts.admin')
@section('title', 'Daftar Anggota')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>Daftar Anggota</h3>
        <div class="header-actions">
            <a href="{{ route('admin.members.create') }}" class="btn btn-primary btn-sm">+ Tambah Anggota</a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Foto</th>
                <th>Jabatan</th>
                <th>Urutan</th>
                <th>Status Keanggotaan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td><strong>{{ $member->name }}</strong></td>
                <td>
                    @if($member->photo_url)
                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                    @else
                    <span style="display:inline-flex;width:48px;height:48px;border-radius:50%;align-items:center;justify-content:center;background:var(--primary-100);color:var(--primary);font-weight:700;">{{ $member->initials ?: 'DK' }}</span>
                    @endif
                </td>
                <td>{{ $member->position }}</td>
                <td>{{ $member->sort_order }}</td>
                <td><span class="badge badge-success">{{ $member->status_label }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.members.destroy', $member->id) }}" onsubmit="return confirm('Hapus anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:32px;">Belum ada anggota.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $members->links() }}
</div>
@endsection
