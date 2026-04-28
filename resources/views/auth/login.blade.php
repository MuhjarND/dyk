<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dharmayukti Karini</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="logo">
                <img src="{{ asset('logo_web.png') }}" alt="Logo Dharmayukti Karini Cabang Papua Barat">
                <h2>Dharmayukti Karini</h2>
                <p>Masuk ke Panel Admin</p>
            </div>

            @if($errors->any())
            <div class="alert alert-error">
                ⚠️ {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="form-group" style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="margin:0;font-weight:400;font-size:13px;">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Masuk</button>
            </form>

            <div style="text-align:center;margin-top:20px;">
                <a href="{{ route('home') }}" style="font-size:13px;color:var(--text-muted);">← Kembali ke Website</a>
            </div>
        </div>
    </div>
</body>
</html>
