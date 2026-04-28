@extends('layouts.app')
@section('title', $post->title)
@section('meta_description', Str::limit(strip_tags($post->content), 160))

@section('content')
<section class="section" style="padding-top:24px;">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Beranda</a><span>›</span>
            <a href="{{ route('berita') }}">Berita</a><span>›</span>
            {{ Str::limit($post->title, 50) }}
        </div>

        <div class="detail-layout">
            <article class="detail-article">
                <div class="detail-header">
                    @if($post->category)
                    <span class="badge badge-success" style="margin-bottom:12px;">{{ $post->category->name }}</span>
                    @endif
                    <h1>{{ $post->title }}</h1>
                    <div class="detail-meta">
                        <span>📅 {{ $post->formatted_date }}</span>
                        <span>✍️ {{ $post->author->name ?? 'Admin' }}</span>
                        <span>👁 {{ $post->views }}x dibaca</span>
                    </div>
                </div>

                @if($post->thumbnail)
                <div class="detail-thumbnail">
                    <img src="{{ asset('uploads/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                </div>
                @endif

                <div class="detail-content">
                    {!! $post->content !!}
                </div>

                @if($post->media->count() > 0)
                <div class="post-media-section">
                    <div class="post-media-header">
                        <h2>Dokumentasi Kegiatan</h2>
                        <p>Foto dan video kegiatan yang terkait dengan berita ini.</p>
                    </div>
                    <div class="post-media-grid">
                        @foreach($post->media as $media)
                            @if($media->isImage())
                            <button
                                type="button"
                                class="post-media-card post-media-image"
                                data-gallery-image="{{ $media->file_url }}"
                                data-gallery-alt="Dokumentasi {{ $post->title }}"
                                aria-label="Buka dokumentasi {{ $post->title }}"
                            >
                                <img src="{{ $media->file_url }}" alt="Dokumentasi {{ $post->title }}">
                                <span class="post-media-overlay">Lihat Foto</span>
                            </button>
                            @else
                            <div class="post-media-card post-media-video">
                                <video src="{{ $media->file_url }}" controls preload="metadata"></video>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Share --}}
                <div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border);">
                    <strong style="font-size:14px;">Bagikan:</strong>
                    <div style="display:flex;gap:8px;margin-top:8px;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline">Facebook</a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-sm btn-outline">Twitter</a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" class="btn btn-sm btn-primary">WhatsApp</a>
                    </div>
                </div>

                {{-- Related Posts --}}
                @if($related->count() > 0)
                <div style="margin-top:48px;">
                    <h2 style="font-size:22px;margin-bottom:24px;">Berita Terkait</h2>
                    <div class="card-grid" style="grid-template-columns:repeat(auto-fill,minmax(280px,1fr));">
                        @foreach($related as $rel)
                        <article class="post-card">
                            <div class="post-card-img" style="height:160px;">
                                @if($rel->thumbnail)
                                    <img src="{{ asset('uploads/' . $rel->thumbnail) }}" alt="{{ $rel->title }}">
                                @else
                                    <div class="placeholder-img">🌸</div>
                                @endif
                            </div>
                            <div class="post-card-body">
                                <h3 style="font-size:15px;"><a href="{{ route('berita.detail', $rel->slug) }}">{{ $rel->title }}</a></h3>
                                <div class="post-card-meta">
                                    <span>📅 {{ $rel->formatted_date }}</span>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
                @endif
            </article>

            <aside class="sidebar">
                {{-- Popular Posts --}}
                <div class="sidebar-widget">
                    <h3>Berita Populer</h3>
                    @foreach($popular as $pop)
                    <div class="sidebar-post">
                        <div class="sidebar-post-img">
                            @if($pop->thumbnail)
                                <img src="{{ asset('uploads/' . $pop->thumbnail) }}" alt="">
                            @else
                                <div style="width:100%;height:100%;background:var(--primary-100);display:flex;align-items:center;justify-content:center;">🌸</div>
                            @endif
                        </div>
                        <div>
                            <h4><a href="{{ route('berita.detail', $pop->slug) }}">{{ Str::limit($pop->title, 60) }}</a></h4>
                            <small>👁 {{ $pop->views }}x dibaca</small>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Categories --}}
                <div class="sidebar-widget">
                    <h3>Kategori</h3>
                    <ul class="category-list">
                        @foreach(\App\Category::withCount(['posts' => function($q){ $q->where('status','published'); }])->get() as $cat)
                        <li>
                            <a href="{{ route('berita', ['kategori' => $cat->slug]) }}">{{ $cat->name }}</a>
                            <span class="count">{{ $cat->posts_count }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>

<div class="media-lightbox" id="mediaLightbox" aria-hidden="true">
    <button type="button" class="media-lightbox-close" data-lightbox-close aria-label="Tutup galeri">&times;</button>
    <div class="media-lightbox-backdrop" data-lightbox-close></div>
    <figure class="media-lightbox-frame">
        <img src="" alt="" id="mediaLightboxImage">
        <figcaption id="mediaLightboxCaption"></figcaption>
    </figure>
</div>
@endsection

@section('js')
<script>
(function () {
    var lightbox = document.getElementById('mediaLightbox');
    var image = document.getElementById('mediaLightboxImage');
    var caption = document.getElementById('mediaLightboxCaption');
    var triggers = document.querySelectorAll('[data-gallery-image]');

    if (!lightbox || !image || !triggers.length) {
        return;
    }

    function openLightbox(src, alt) {
        image.src = src;
        image.alt = alt || 'Dokumentasi kegiatan';
        caption.textContent = alt || 'Dokumentasi kegiatan';
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        image.removeAttribute('src');
    }

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            openLightbox(trigger.getAttribute('data-gallery-image'), trigger.getAttribute('data-gallery-alt'));
        });
    });

    lightbox.querySelectorAll('[data-lightbox-close]').forEach(function (button) {
        button.addEventListener('click', closeLightbox);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && lightbox.classList.contains('is-open')) {
            closeLightbox();
        }
    });
})();
</script>
@endsection
