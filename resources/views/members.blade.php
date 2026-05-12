@extends('layouts.app')
@section('title', 'Daftar Anggota')
@section('meta_description', 'Daftar anggota Dharmayukti Karini Cabang Papua Barat')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Daftar Anggota</h1>
        <p>Informasi anggota Dharmayukti Karini Cabang Papua Barat</p>
    </div>
</div>

<section class="section member-directory-section">
    <div class="container">
        <div class="member-directory">
            @forelse($members as $member)
            <article class="member-row">
                <div class="member-number">{{ $members->firstItem() + $loop->index }}</div>
                <div class="member-avatar">
                    @if($member->photo_url)
                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}">
                    @else
                    <span>{{ $member->initials ?: 'DK' }}</span>
                    @endif
                </div>
                <div class="member-info">
                    <dl class="member-detail-list">
                        <div>
                            <dt>Nama</dt>
                            <dd>{{ $member->name }}</dd>
                        </div>
                        <div>
                            <dt>Jabatan</dt>
                            <dd>{{ $member->position }}</dd>
                        </div>
                        <div>
                            <dt>Status Keanggotaan</dt>
                            <dd><span class="member-status member-status-{{ $member->membership_status }}">{{ $member->status_label }}</span></dd>
                        </div>
                    </dl>
                </div>
                <blockquote class="member-quote">
                    {{ $member->quote ?: 'Mengabdi dengan ketulusan, menjaga kebersamaan, dan memperkuat peran organisasi.' }}
                </blockquote>
            </article>
            @empty
            <div class="profil-section" style="text-align:center;">
                <h2>Belum ada anggota</h2>
                <p>Data anggota belum tersedia untuk ditampilkan.</p>
            </div>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $members->links() }}
        </div>
    </div>
</section>
@endsection
