@extends('layouts.admin')
@section('title', isset($agenda) ? 'Edit Agenda' : 'Tambah Agenda')

@section('content')
<div class="form-card" style="max-width:760px;">
    <form method="POST" action="{{ isset($agenda) ? route('admin.agendas.update', $agenda->id) : route('admin.agendas.store') }}">
        @csrf
        @if(isset($agenda)) @method('PUT') @endif

        <div class="form-group">
            <label>Judul Agenda <span class="required">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $agenda->title ?? '') }}" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $agenda->description ?? '') }}</textarea>
            @error('description')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div class="form-group">
                <label>Tanggal Agenda <span class="required">*</span></label>
                <input type="date" name="agenda_date" class="form-control @error('agenda_date') is-invalid @enderror" value="{{ old('agenda_date', isset($agenda) ? $agenda->agenda_date->format('Y-m-d') : '') }}" required>
                @error('agenda_date')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $agenda->location ?? '') }}">
                @error('location')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div class="form-group">
                <label>Waktu Mulai</label>
                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', isset($agenda) ? substr((string) $agenda->start_time, 0, 5) : '') }}">
                @error('start_time')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Waktu Selesai</label>
                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', isset($agenda) ? substr((string) $agenda->end_time, 0, 5) : '') }}">
                @error('end_time')<div class="form-error">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="form-group">
            <label style="display:flex;align-items:center;gap:10px;margin:0;font-weight:500;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', isset($agenda) ? $agenda->is_active : true) ? 'checked' : '' }}>
                Agenda aktif
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">{{ isset($agenda) ? 'Perbarui Agenda' : 'Simpan Agenda' }}</button>
            <a href="{{ route('admin.agendas.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
