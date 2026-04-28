@extends('layouts.admin')
@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
<div class="form-card" style="max-width:600px;">
    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="form-group">
            <label>Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" required>
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" required>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Nomor WhatsApp</label>
            <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp', $user->whatsapp ?? '') }}" placeholder="Contoh: 082333106343">
            <span class="form-hint">Digunakan untuk tombol kirim akun via WhatsApp.</span>
            @error('whatsapp')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Password {{ isset($user) ? '(kosongkan jika tidak diubah)' : '' }} <span class="required">{{ isset($user) ? '' : '*' }}</span></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ isset($user) ? '' : 'required' }}>
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="form-group">
            <label>Role <span class="required">*</span></label>
            <select name="role" class="form-control" required>
                <option value="author" {{ old('role', $user->role ?? 'author') === 'author' ? 'selected' : '' }}>Author (Penulis)</option>
                <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Perbarui' : 'Simpan' }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
