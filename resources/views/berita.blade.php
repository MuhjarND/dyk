@extends('layouts.app')
@section('title', 'Berita')
@section('meta_description', 'Berita terkini seputar kegiatan Dharmayukti Karini Cabang Papua Barat')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Berita & Kegiatan</h1>
        <p>Informasi terkini seputar kegiatan Dharmayukti Karini Cabang Papua Barat</p>
    </div>
</div>

<section class="section">
    <div class="container">
        {{-- Search & Filter --}}
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:32px;">
            <form action="{{ route('berita') }}" method="GET" class="search-bar">
                <input type="text" name="cari" placeholder="Cari berita..." value="{{ request('cari') }}">
                @if(request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <button type="submit">Cari</button>
            </form>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="{{ route('berita') }}" class="btn btn-sm {{ !request('kategori') ? 'btn-primary' : 'btn-outline' }}">Semua</a>
                @foreach($categories as $cat)
                <a href="{{ route('berita', ['kategori' => $cat->slug]) }}" class="btn btn-sm {{ request('kategori') == $cat->slug ? 'btn-primary' : 'btn-outline' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>

        @if($posts->count() > 0)
        <div class="card-grid">
            @foreach($posts as $post)
            <article class="post-card">
                <div class="post-card-img">
                    @if($post->thumbnail)
                        <img src="{{ asset('uploads/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                    @else
                        <div class="placeholder-img">🌸</div>
                    @endif
                    @if($post->category)
                    <span class="post-card-badge">{{ $post->category->name }}</span>
                    @endif
                </div>
                <div class="post-card-body">
                    <div class="post-card-meta">
                        <span>📅 {{ $post->formatted_date }}</span>
                        <span>👁 {{ $post->views }}x</span>
                    </div>
                    <h3><a href="{{ route('berita.detail', $post->slug) }}">{{ $post->title }}</a></h3>
                    <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                </div>
                <div class="post-card-footer">
                    <span style="font-size:13px;color:var(--text-muted)">{{ $post->author->name ?? '-' }}</span>
                    <a href="{{ route('berita.detail', $post->slug) }}">Baca →</a>
                </div>
            </article>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $posts->appends(request()->query())->links() }}
        </div>
        @else
        <div style="text-align:center;padding:60px 0;">
            <p style="font-size:48px;margin-bottom:16px;">📭</p>
            <h3>Tidak ada berita ditemukan</h3>
            <p style="color:var(--text-muted)">Coba kata kunci lain atau lihat semua berita.</p>
            <a href="{{ route('berita') }}" class="btn btn-primary" style="margin-top:16px;">Lihat Semua Berita</a>
        </div>
        @endif
    </div>
</section>
@endsection
