<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Website resmi Dharmayukti Karini Cabang Papua Barat - organisasi wanita peradilan di bawah naungan Mahkamah Agung RI')">
    <title>@yield('title', 'Dharmayukti Karini Cabang Papua Barat') - Organisasi Wanita Peradilan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('logo_web.png') }}" alt="Logo Dharmayukti Karini Cabang Papua Barat">
                <span>Dharmayukti Karini<small>Cabang Papua Barat</small></span>
            </a>
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a></li>
                <li><a href="{{ route('berita') }}" class="{{ request()->routeIs('berita*') ? 'active' : '' }}">Berita</a></li>
                <li class="nav-dropdown {{ request()->routeIs('profil*') ? 'active' : '' }}">
                    <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil*') ? 'active' : '' }}">Profil</a>
                    @if(isset($navProfilePages) && $navProfilePages->count())
                    <ul class="nav-dropdown-menu">
                        @foreach($navProfilePages as $navProfilePage)
                        <li><a href="{{ route('profil.show', $navProfilePage->slug) }}">{{ $navProfilePage->title }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                <li><a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a></li>
                @auth
                <li><a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a></li>
                @endauth
            </ul>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <h4>Dharmayukti Karini Cabang Papua Barat</h4>
                    <p>Media informasi resmi cabang Papua Barat yang menjadi wadah sosial, pemberdayaan anggota, dan penguatan nilai integritas di lingkungan peradilan.</p>
                    <p style="margin-top:12px">Sekretariat Dharmayukti Karini<br>Cabang Papua Barat</p>
                </div>
                <div>
                    <h4>Tautan</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('berita') }}">Berita</a></li>
                        <li><a href="{{ route('profil') }}">Profil Organisasi</a></li>
                        <li><a href="{{ route('kontak') }}">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Kontak</h4>
                    <ul>
                        <li>Kontak cabang tersedia melalui sekretariat</li>
                        <li>Email cabang dapat diperbarui sesuai kebutuhan</li>
                        <li>Portal informasi Dharmayukti Karini Cabang Papua Barat</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Dharmayukti Karini Cabang Papua Barat. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>

    <script>
    (function () {
        var navToggle = document.getElementById('navToggle');
        var navLinks = document.getElementById('navLinks');

        if (navToggle && navLinks) {
            navToggle.addEventListener('click', function () {
                navLinks.classList.toggle('active');
            });
        }

        var revealTargets = document.querySelectorAll('.section-header, .stat-card, .post-card, .about-content, .about-image, .contact-grid > div, .sidebar-widget, .detail-article, .hero-petal, .calendar-card, .profile-card, .agenda-list-card');
        revealTargets.forEach(function (element) {
            if (!element.classList.contains('reveal-up')) {
                element.classList.add('reveal-up');
            }
        });

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.14, rootMargin: '0px 0px -40px 0px' });

            revealTargets.forEach(function (element) {
                observer.observe(element);
            });
        } else {
            revealTargets.forEach(function (element) {
                element.classList.add('is-visible');
            });
        }

        var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

        if (!prefersReducedMotion && finePointer) {
            document.body.classList.add('has-fancy-cursor');

            var cursorDot = document.createElement('div');
            var halo = document.createElement('div');
            cursorDot.className = 'cursor-dot';
            halo.className = 'cursor-halo';
            document.body.appendChild(halo);
            document.body.appendChild(cursorDot);

            var pointer = { x: window.innerWidth / 2, y: window.innerHeight / 2 };
            var haloPointer = { x: pointer.x, y: pointer.y };
            var visible = false;

            function setOpacity(value) {
                cursorDot.style.opacity = value;
                halo.style.opacity = value;
            }

            function animateCursor() {
                haloPointer.x += (pointer.x - haloPointer.x) * 0.18;
                haloPointer.y += (pointer.y - haloPointer.y) * 0.18;

                cursorDot.style.transform = 'translate(' + pointer.x + 'px, ' + pointer.y + 'px)';
                halo.style.transform = 'translate(' + haloPointer.x + 'px, ' + haloPointer.y + 'px)';
                requestAnimationFrame(animateCursor);
            }

            window.addEventListener('mousemove', function (event) {
                pointer.x = event.clientX;
                pointer.y = event.clientY;

                if (!visible) {
                    visible = true;
                    setOpacity(1);
                }
            });

            window.addEventListener('mouseleave', function () {
                visible = false;
                setOpacity(0);
            });

            document.querySelectorAll('a, button, input, textarea, select, .btn').forEach(function (element) {
                element.addEventListener('mouseenter', function () {
                    cursorDot.classList.add('is-active');
                    halo.classList.add('is-active');
                });

                element.addEventListener('mouseleave', function () {
                    cursorDot.classList.remove('is-active');
                    halo.classList.remove('is-active');
                });
            });

            window.addEventListener('click', function (event) {
                var sparkle = document.createElement('span');
                sparkle.className = 'cursor-sparkle';
                sparkle.style.left = event.clientX + 'px';
                sparkle.style.top = event.clientY + 'px';
                document.body.appendChild(sparkle);

                setTimeout(function () {
                    sparkle.remove();
                }, 900);
            });

            animateCursor();
        }
    })();
    </script>
    @yield('js')
</body>
</html>
