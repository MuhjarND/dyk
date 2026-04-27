@extends('layouts.app')
@section('title', 'Kontak')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Hubungi Kami</h1>
        <p>Informasi kontak Dharmayukti Karini Cabang Papua Barat</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div>
                <div class="profil-section" style="margin-bottom:0;">
                    <h2>Informasi Kontak</h2>
                    <p>Silakan hubungi Dharmayukti Karini Cabang Papua Barat melalui informasi kontak di bawah ini atau kirimkan pesan melalui formulir.</p>
                    <ul class="contact-info-list" style="margin-top:20px;">
                        <li>
                            <div class="contact-icon">📍</div>
                            <div><strong>Alamat</strong><br>Sekretariat Dharmayukti Karini Cabang Papua Barat<br>Papua Barat</div>
                        </li>
                        <li>
                            <div class="contact-icon">📞</div>
                            <div><strong>Telepon</strong><br>Kontak cabang dapat diperbarui di sini</div>
                        </li>
                        <li>
                            <div class="contact-icon">📧</div>
                            <div><strong>Email</strong><br>Email cabang dapat diperbarui di sini</div>
                        </li>
                        <li>
                            <div class="contact-icon">🕐</div>
                            <div><strong>Jam Operasional</strong><br>Senin - Jumat: 08.00 - 16.00 WIT</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="profil-section contact-form" style="margin-bottom:0;">
                    <h2>Kirim Pesan</h2>
                    <form>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" placeholder="Masukkan alamat email Anda">
                        </div>
                        <div class="form-group">
                            <label>Subjek</label>
                            <input type="text" placeholder="Subjek pesan">
                        </div>
                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea rows="5" placeholder="Tulis pesan Anda di sini..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="alert('Terima kasih! Pesan Anda telah dikirim.')">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
