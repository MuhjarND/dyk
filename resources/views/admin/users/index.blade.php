@extends('layouts.admin')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>Daftar Pengguna</h3>
        <div class="header-actions">
            <button type="button" class="btn btn-whatsapp btn-sm" onclick="sendAllAccounts()">Kirim Akun Semua</button>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Tambah Pengguna</a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr><th>Nama</th><th>Email</th><th>WhatsApp</th><th>Role</th><th>Jumlah Berita</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td style="display:flex;align-items:center;gap:10px;">
                    <img src="{{ $user->avatar_url }}" style="width:32px;height:32px;border-radius:50%;">
                    <strong>{{ $user->name }}</strong>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->whatsapp ?: '-' }}</td>
                <td><span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-author' }}">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->posts_count }}</td>
                <td>
                    <div class="actions">
                        @if($user->whatsapp_account_url)
                        <a href="{{ $user->whatsapp_account_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-whatsapp">WA</a>
                        @else
                        <span class="btn btn-sm btn-muted" title="Nomor WhatsApp belum diisi">WA</span>
                        @endif
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
            <tr><td colspan="6" style="text-align:center;padding:32px;">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function sendAllAccounts() {
    var urls = @json($users->filter(function ($user) {
        return (bool) $user->whatsapp_account_url;
    })->pluck('whatsapp_account_url')->values());

    if (!urls.length) {
        alert('Belum ada user dengan nomor WhatsApp.');
        return;
    }

    if (!confirm('Buka WhatsApp untuk ' + urls.length + ' user? Browser mungkin meminta izin membuka beberapa tab.')) {
        return;
    }

    urls.forEach(function (url, index) {
        setTimeout(function () {
            window.open(url, '_blank', 'noopener');
        }, index * 450);
    });
}
</script>
@endsection
