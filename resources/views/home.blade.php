@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="hero-petal hero-petal-1"></div>
        <div class="hero-petal hero-petal-2"></div>
        <div class="hero-petal hero-petal-3"></div>
        <div class="hero-petal hero-petal-4"></div>
        <div class="hero-content">
            <h1>Selamat Datang di<br><span>Dharmayukti Karini Cabang Papua Barat</span></h1>
            <p>Media informasi resmi Dharmayukti Karini Cabang Papua Barat untuk menyampaikan kegiatan, profil organisasi, berita cabang, agenda organisasi, dan penguatan solidaritas anggota.</p>
            <div class="hero-cta">
                <a href="{{ route('profil') }}" class="btn btn-secondary">Profil Organisasi</a>
                <a href="{{ route('berita') }}" class="btn btn-outline" style="color:#fff;border-color:rgba(255,255,255,.5);">Lihat Berita</a>
            </div>
        </div>
        <div class="hero-image hero-logo-badge">
            <img src="{{ asset('logo_web.png') }}" alt="Logo Dharmayukti Karini">
        </div>
    </div>
</section>

{{-- SLIDER BERITA --}}
<section class="section slider-section-wrap">
    <div class="container">
        <div class="section-header">
            <h2>Berita Pilihan</h2>
            <p>Highlight berita dan kegiatan terbaru Dharmayukti Karini Cabang Papua Barat.</p>
            <span class="accent-line"></span>
        </div>

        <div class="news-carousel slider-section-shell" id="homeSlider">
            <div class="news-carousel-stage">
                @forelse($sliders as $index => $slider)
                <article class="news-carousel-item {{ $index === 0 ? 'is-active' : '' }}" data-slide-index="{{ $index }}">
                    <div class="news-carousel-card">
                        <div class="news-carousel-media">
                            <img src="{{ $slider->image_url }}" alt="{{ $slider->display_title }}">
                        </div>
                        <div class="news-carousel-overlay"></div>
                        <div class="news-carousel-content">
                            <div class="news-carousel-meta">
                                <span class="news-carousel-tag">Berita Pilihan</span>
                                @if($slider->post && $slider->post->published_at)
                                <span>{{ $slider->post->published_at->translatedFormat('d M Y') }}</span>
                                @endif
                            </div>
                            <h3>{{ $slider->display_title }}</h3>
                            <p class="news-carousel-excerpt">{{ \Illuminate\Support\Str::limit($slider->display_description ?: 'Media informasi resmi Dharmayukti Karini Cabang Papua Barat untuk menyampaikan kegiatan, profil organisasi, dan penguatan solidaritas anggota.', 170) }}</p>
                            <div class="news-carousel-actions">
                                <a href="{{ $slider->display_url }}" class="btn btn-secondary">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <article class="news-carousel-item is-active">
                    <div class="news-carousel-card">
                        <div class="news-carousel-media">
                            <img src="{{ asset('logo_web.png') }}" alt="Logo Dharmayukti Karini">
                        </div>
                        <div class="news-carousel-overlay"></div>
                        <div class="news-carousel-content">
                            <div class="news-carousel-meta">
                                <span class="news-carousel-tag">Berita Pilihan</span>
                            </div>
                            <h3>Belum Ada Berita Pilihan</h3>
                            <p class="news-carousel-excerpt">Tambahkan slider dari halaman admin untuk menampilkan berita unggulan di beranda website.</p>
                            <div class="news-carousel-actions">
                                <a href="{{ route('berita') }}" class="btn btn-secondary">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </article>
                @endforelse
            </div>

            @if($sliders->count() > 1)
            <div class="news-carousel-controls">
                <button type="button" class="news-carousel-arrow" data-slider-prev aria-label="Slide sebelumnya">&lsaquo;</button>
                <div class="hero-slider-dots">
                    @foreach($sliders as $index => $slider)
                    <button type="button" class="hero-slider-dot {{ $index === 0 ? 'is-active' : '' }}" data-slider-dot="{{ $index }}" aria-label="Tampilkan slide {{ $index + 1 }}"></button>
                    @endforeach
                </div>
                <button type="button" class="news-carousel-arrow" data-slider-next aria-label="Slide berikutnya">&rsaquo;</button>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="section stats-highlight-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number" data-count="{{ $totalPosts }}">0</div>
                <div class="stat-label">Berita Dipublikasi</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-count="{{ $totalCategories }}">0</div>
                <div class="stat-label">Kategori</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" data-count="{{ $totalViews }}">0</div>
                <div class="stat-label">Total Pembaca</div>
            </div>
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
<section class="section" style="background:#fff;padding-top:60px;">
    <div class="container">
        <div class="section-header">
            <h2>Berita Terbaru</h2>
            <p>Informasi terkini seputar kegiatan Dharmayukti Karini Cabang Papua Barat</p>
            <span class="accent-line"></span>
        </div>
        <div class="card-grid">
            @foreach($posts as $post)
            <article class="post-card">
                <div class="post-card-img">
                    @if($post->thumbnail)
                        <img src="{{ asset('uploads/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                    @else
                        <div class="placeholder-img">DYK</div>
                    @endif
                    @if($post->category)
                    <span class="post-card-badge">{{ $post->category->name }}</span>
                    @endif
                </div>
                <div class="post-card-body">
                    <div class="post-card-meta">
                        <span>📅 {{ $post->formatted_date }}</span>
                        <span>👁 {{ $post->views }}x dibaca</span>
                    </div>
                    <h3><a href="{{ route('berita.detail', $post->slug) }}">{{ $post->title }}</a></h3>
                    <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                </div>
                <div class="post-card-footer">
                    <span style="font-size:13px;color:var(--text-muted)">{{ $post->author->name ?? 'Admin' }}</span>
                    <a href="{{ route('berita.detail', $post->slug) }}">Baca Selengkapnya →</a>
                </div>
            </article>
            @endforeach
        </div>
        @if($posts->count() >= 6)
        <div style="text-align:center;margin-top:40px;">
            <a href="{{ route('berita') }}" class="btn btn-primary">Lihat Semua Berita →</a>
        </div>
        @endif
    </div>
</section>

{{-- AGENDA --}}
<section class="section" style="background:#fff7fa;">
    <div class="container">
        <div class="section-header">
            <h2>Agenda Organisasi</h2>
            <p>Kalender agenda kegiatan Dharmayukti Karini Cabang Papua Barat untuk bulan {{ $calendarMonth->translatedFormat('F Y') }}</p>
            <span class="accent-line"></span>
        </div>

        <div class="agenda-layout">
            <div class="calendar-card">
                <div class="calendar-toolbar">
                    <a href="{{ route('home', ['agenda_month' => $calendarMonth->copy()->subMonth()->format('Y-m')]) }}" class="btn btn-outline btn-sm">Bulan Sebelumnya</a>
                    <h3>{{ $calendarMonth->translatedFormat('F Y') }}</h3>
                    <a href="{{ route('home', ['agenda_month' => $calendarMonth->copy()->addMonth()->format('Y-m')]) }}" class="btn btn-outline btn-sm">Bulan Berikutnya</a>
                </div>

                <div class="calendar-weekdays">
                    <span>Sen</span>
                    <span>Sel</span>
                    <span>Rab</span>
                    <span>Kam</span>
                    <span>Jum</span>
                    <span>Sab</span>
                    <span>Min</span>
                </div>

                <div class="calendar-grid">
                    @foreach($calendarDays as $day)
                    <div class="calendar-day {{ !$day['isCurrentMonth'] ? 'is-outside' : '' }} {{ $day['isToday'] ? 'is-today' : '' }}">
                        <div class="calendar-day-number">{{ $day['date']->format('d') }}</div>
                        <div class="calendar-day-events">
                            @forelse($day['events']->take(2) as $event)
                            <div class="calendar-event-pill">{{ $event->title }}</div>
                            @empty
                            @endforelse
                            @if($day['events']->count() > 2)
                            <div class="calendar-event-more">+{{ $day['events']->count() - 2 }} agenda</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="agenda-list-card">
                <div class="agenda-list-header">
                    <h3>Agenda Terdekat</h3>
                    <p>Daftar agenda aktif yang akan datang.</p>
                </div>
                <div class="agenda-list">
                    @forelse($upcomingAgendas as $agenda)
                    <article class="agenda-item">
                        <div class="agenda-item-date">
                            <strong>{{ $agenda->agenda_date->format('d') }}</strong>
                            <span>{{ $agenda->agenda_date->translatedFormat('M') }}</span>
                        </div>
                        <div class="agenda-item-body">
                            <h4>{{ $agenda->title }}</h4>
                            <p>{{ $agenda->description ? \Illuminate\Support\Str::limit(strip_tags($agenda->description), 160) : 'Agenda organisasi Dharmayukti Karini Cabang Papua Barat.' }}</p>
                            <div class="agenda-item-meta">
                                <span>{{ $agenda->location ?: 'Lokasi akan diperbarui' }}</span>
                                <span>{{ $agenda->start_time ? substr($agenda->start_time, 0, 5) : 'Waktu menyusul' }}</span>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="profil-section" style="padding:24px;">
                        <h3 style="margin-bottom:8px;">Belum ada agenda</h3>
                        <p style="margin-bottom:0;">Agenda organisasi belum tersedia untuk ditampilkan.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG SINGKAT --}}
<section class="section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <h2>Tentang Dharmayukti Karini Cabang Papua Barat</h2>
                <p>Website ini didedikasikan untuk Dharmayukti Karini Cabang Papua Barat sebagai ruang informasi resmi mengenai profil, program kerja, dan kegiatan organisasi di tingkat cabang.</p>
                <p>Dharmayukti Karini sendiri merupakan organisasi wanita peradilan yang didirikan pada 25 September 2002 berdasarkan SK Ketua Mahkamah Agung RI, dan cabang Papua Barat hadir untuk memperkuat silaturahmi, pemberdayaan anggota, serta peran sosial organisasi di wilayah Papua Barat.</p>
                <a href="{{ route('profil') }}" class="btn btn-primary" style="margin-top:12px;">Selengkapnya →</a>
            </div>
            <div class="about-image">
                <div style="background:linear-gradient(135deg,var(--primary-100),var(--primary-50));border-radius:16px;padding:60px;text-align:center;">
                    <img src="{{ asset('logo_web.png') }}" alt="Dharmayukti Karini Cabang Papua Barat" style="max-width:200px;">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
(function () {
    var statNumbers = document.querySelectorAll('.stat-number[data-count]');

    if (!statNumbers.length) {
        return;
    }

    function formatCount(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function animateCounter(element) {
        var target = parseInt(element.getAttribute('data-count'), 10) || 0;
        var duration = 1600;
        var startTime = null;

        function tick(timestamp) {
            if (!startTime) {
                startTime = timestamp;
            }

            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            var currentValue = Math.round(target * eased);

            element.textContent = formatCount(currentValue);

            if (progress < 1) {
                window.requestAnimationFrame(tick);
            } else {
                element.textContent = formatCount(target);
            }
        }

        window.requestAnimationFrame(tick);
    }

    var hasAnimated = false;
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting && !hasAnimated) {
                hasAnimated = true;
                statNumbers.forEach(animateCounter);
                observer.disconnect();
            }
        });
    }, {
        threshold: 0.35
    });

    observer.observe(document.querySelector('.stats-highlight-section'));
})();

(function () {
    var slider = document.getElementById('homeSlider');

    if (!slider) {
        return;
    }

    var slides = slider.querySelectorAll('.news-carousel-item');
    var dots = slider.querySelectorAll('.hero-slider-dot');
    var prevButton = slider.querySelector('[data-slider-prev]');
    var nextButton = slider.querySelector('[data-slider-next]');
    var current = 0;
    var intervalId = null;

    if (slides.length <= 1) {
        return;
    }

    function renderSlide(index) {
        current = index;

        slides.forEach(function (slide, slideIndex) {
            slide.classList.remove('is-active', 'is-prev', 'is-next');

            if (slideIndex === current) {
                slide.classList.add('is-active');
            } else if (slideIndex === (current - 1 + slides.length) % slides.length) {
                slide.classList.add('is-prev');
            } else if (slideIndex === (current + 1) % slides.length) {
                slide.classList.add('is-next');
            }
        });

        dots.forEach(function (dot, dotIndex) {
            dot.classList.toggle('is-active', dotIndex === current);
        });
    }

    function nextSlide() {
        renderSlide((current + 1) % slides.length);
    }

    function prevSlide() {
        renderSlide((current - 1 + slides.length) % slides.length);
    }

    function startAutoPlay() {
        stopAutoPlay();
        intervalId = setInterval(nextSlide, 6000);
    }

    function stopAutoPlay() {
        if (intervalId) {
            clearInterval(intervalId);
        }
    }

    dots.forEach(function (dot, index) {
        dot.addEventListener('click', function () {
            renderSlide(index);
            startAutoPlay();
        });
    });

    slides.forEach(function (slide, index) {
        slide.addEventListener('click', function () {
            if (index !== current) {
                renderSlide(index);
                startAutoPlay();
            }
        });
    });

    if (nextButton) {
        nextButton.addEventListener('click', function () {
            nextSlide();
            startAutoPlay();
        });
    }

    if (prevButton) {
        prevButton.addEventListener('click', function () {
            prevSlide();
            startAutoPlay();
        });
    }

    slider.addEventListener('mouseenter', stopAutoPlay);
    slider.addEventListener('mouseleave', startAutoPlay);

    renderSlide(0);
    startAutoPlay();
})();
</script>
@endsection
