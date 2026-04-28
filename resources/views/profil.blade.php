@extends('layouts.app')
@section('title', 'Profil Organisasi')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Profil Organisasi</h1>
        <p>Pilih pembahasan profil Dharmayukti Karini Cabang Papua Barat</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Halaman Profil</h2>
            <p>Setiap bagian profil memiliki halaman tersendiri agar informasi lebih terstruktur dan mudah dikelola.</p>
            <span class="accent-line"></span>
        </div>

        <div class="profile-grid">
            @forelse($pages as $page)
            <article class="profile-card">
                <span class="profile-card-kicker">Profil</span>
                <h3>{{ $page->title }}</h3>
                <p>{{ $page->excerpt ? strip_tags($page->excerpt) : 'Pelajari informasi lebih lengkap mengenai bagian profil ini.' }}</p>
                <a href="{{ route('profil.show', $page->slug) }}" class="btn btn-primary btn-sm">Buka Halaman</a>
            </article>
            @empty
            <div class="profil-section" style="max-width:760px;margin:0 auto;">
                <h2>Belum ada halaman profil</h2>
                <p>Halaman profil belum tersedia. Silakan tambahkan melalui panel admin.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
