@extends('layouts.app')
@section('title', $page->title)
@section('meta_description', $page->excerpt ?: Str::limit(strip_tags($page->content), 160))

@section('content')
<div class="page-header">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        <p>{{ $page->excerpt ?: 'Informasi profil Dharmayukti Karini Cabang Papua Barat' }}</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="detail-layout" style="grid-template-columns:minmax(0,1fr) 320px;">
            <article class="detail-article">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a><span>&rsaquo;</span>
                    <a href="{{ route('profil') }}">Profil</a><span>&rsaquo;</span>
                    {{ $page->title }}
                </div>

                <div class="profil-section">
                    <div class="detail-content">
                        {!! $page->content !!}
                    </div>
                </div>
            </article>

            <aside class="sidebar">
                <div class="sidebar-widget">
                    <h3>Halaman Profil</h3>
                    <ul class="category-list">
                        @foreach($pages as $item)
                        <li>
                            <a href="{{ route('profil.show', $item->slug) }}">{{ $item->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
