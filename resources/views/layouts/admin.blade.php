<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Admin DYK</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('css')
</head>
<body>
    <div class="admin-wrapper">
        {{-- SIDEBAR --}}
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <img src="{{ asset('logo_web.png') }}" alt="Logo">
                <h3>Dharmayukti Karini</h3>
                <small>Cabang Papua Barat</small>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Kelola Berita
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.agendas.index') }}" class="{{ request()->routeIs('admin.agendas.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/></svg>
                    Kelola Agenda
                </a>
                <a href="{{ route('admin.profile-pages.index') }}" class="{{ request()->routeIs('admin.profile-pages.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586A2 2 0 0114 3.586L18.414 8A2 2 0 0119 9.414V19a2 2 0 01-2 2z"/></svg>
                    Kelola Profil
                </a>
                <a href="{{ route('admin.sliders.index') }}" class="{{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2zm0 4h10M7 12h6"/></svg>
                    Kelola Slider
                </a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                    Kategori
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m3 5.197V21"/></svg>
                    Pengguna
                </a>
                @endif
                <div class="nav-divider"></div>
                <a href="{{ route('home') }}" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <a href="#" onclick="this.closest('form').submit();return false;" style="color:rgba(255,255,255,.6);">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </a>
                </form>
            </nav>
        </aside>

        {{-- MAIN --}}
        <main class="admin-main">
            <div class="admin-topbar">
                <div style="display:flex;align-items:center;gap:12px;">
                    <button class="sidebar-toggle-btn" onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                    </button>
                    <h2>@yield('title', 'Dashboard')</h2>
                </div>
                <div class="admin-user">
                    <img src="{{ auth()->user()->avatar_url }}" alt="">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="badge {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-author' }}">{{ ucfirst(auth()->user()->role) }}</span>
                </div>
            </div>

            <div class="admin-content">
                @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-error">⚠️ {{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @yield('js')
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
    <script>
    (function () {
        if (!window.CKEDITOR) {
            return;
        }

        var uploadUrl = '{{ route('admin.editor.upload') }}?_token={{ csrf_token() }}';

        CKEDITOR.disableAutoInline = true;

        document.querySelectorAll('textarea').forEach(function (textarea, index) {
            if (textarea.dataset.ckeditor === 'false') {
                return;
            }

            if (!textarea.id) {
                textarea.id = 'ckeditor-textarea-' + index;
            }

            if (CKEDITOR.instances[textarea.id]) {
                return;
            }

            CKEDITOR.replace(textarea.id, {
                height: Math.max(180, (parseInt(textarea.getAttribute('rows'), 10) || 8) * 32),
                allowedContent: true,
                extraPlugins: 'uploadimage,image2,justify,colorbutton,font,table,tableresize,autoembed,embed',
                removePlugins: 'easyimage,cloudservices',
                filebrowserUploadUrl: uploadUrl,
                filebrowserImageUploadUrl: uploadUrl,
                uploadUrl: uploadUrl,
                imageUploadUrl: uploadUrl,
                filebrowserUploadMethod: 'xhr',
                fileTools_requestHeaders: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                toolbar: [
                    { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                    { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'Embed'] },
                    { name: 'links', items: ['Link', 'Unlink'] },
                    { name: 'tools', items: ['Maximize', 'Source'] }
                ]
            });
        });

        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function () {
                Object.keys(CKEDITOR.instances).forEach(function (name) {
                    CKEDITOR.instances[name].updateElement();
                });
            });
        });
    })();
    </script>
</body>
</html>
