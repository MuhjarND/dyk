@extends('layouts.admin')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>Daftar Pengguna</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Tambah Pengguna</a>
    </div>
    <table class="data-table">
        <thead>
            <tr><th>Nama</th><th>Email</th><th>Role</th><th>Jumlah Berita</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="display:flex;align-items:center;gap:10px;">
                    <img src="{{ $user->avatar_url }}" style="width:32px;height:32px;border-radius:50%;">
                    <strong>{{ $user->name }}</strong>
                </td>
                <td>{{ $user->email }}</td>
                <td><span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-author' }}">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->posts_count }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline">Edit</a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Hapus pengguna ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:32px;">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
