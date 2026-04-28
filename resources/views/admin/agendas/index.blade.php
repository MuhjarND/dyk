@extends('layouts.admin')
@section('title', 'Kelola Agenda')

@section('content')
<div class="data-card">
    <div class="data-card-header">
        <h3>Daftar Agenda</h3>
        <div class="header-actions">
            <a href="{{ route('admin.agendas.create') }}" class="btn btn-primary btn-sm">+ Tambah Agenda</a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Lokasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agendas as $agenda)
            <tr>
                <td>
                    <strong>{{ $agenda->title }}</strong>
                    @if($agenda->description)
                    <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">{{ Str::limit($agenda->description, 70) }}</div>
                    @endif
                </td>
                <td>{{ $agenda->agenda_date->format('d/m/Y') }}</td>
                <td>{{ $agenda->start_time ? substr($agenda->start_time, 0, 5) : '-' }}{{ $agenda->end_time ? ' - ' . substr($agenda->end_time, 0, 5) : '' }}</td>
                <td>{{ $agenda->location ?: '-' }}</td>
                <td><span class="badge {{ $agenda->is_active ? 'badge-success' : 'badge-warning' }}">{{ $agenda->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.agendas.destroy', $agenda->id) }}" onsubmit="return confirm('Yakin hapus agenda ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:40px;">Belum ada agenda.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
