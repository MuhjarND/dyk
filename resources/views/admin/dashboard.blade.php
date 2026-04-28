@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="dashboard-stats">
    <div class="dash-stat-card">
        <div class="dash-stat-icon green">📰</div>
        <div class="dash-stat-info">
            <h3>{{ $totalPosts }}</h3>
            <p>Total Berita</p>
        </div>
    </div>
    <div class="dash-stat-card">
        <div class="dash-stat-icon yellow">✅</div>
        <div class="dash-stat-info">
            <h3>{{ $publishedPosts }}</h3>
            <p>Dipublikasi</p>
        </div>
    </div>
    <div class="dash-stat-card">
        <div class="dash-stat-icon blue">📝</div>
        <div class="dash-stat-info">
            <h3>{{ $draftPosts }}</h3>
            <p>Draft</p>
        </div>
    </div>
    <div class="dash-stat-card">
        <div class="dash-stat-icon purple">👁</div>
        <div class="dash-stat-info">
            <h3>{{ number_format($totalViews) }}</h3>
            <p>Total Dibaca</p>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h3>Berita Terbaru</h3>
        <div class="header-actions">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">+ Buat Berita</a>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Dilihat</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentPosts as $post)
            <tr>
                <td><a href="{{ route('admin.posts.edit', $post->id) }}" style="font-weight:500;">{{ Str::limit($post->title, 50) }}</a></td>
                <td>{{ $post->category->name ?? '-' }}</td>
                <td><span class="badge {{ $post->status === 'published' ? 'badge-success' : 'badge-warning' }}">{{ $post->status === 'published' ? 'Publik' : 'Draft' }}</span></td>
                <td>{{ $post->views }}</td>
                <td>{{ $post->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;padding:32px;">Belum ada berita.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
