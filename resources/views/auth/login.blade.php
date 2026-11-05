<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · Sistem Informasi Ketahanan Pangan Malang Selatan</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="auth">
    <aside class="auth-aside">
        <div class="hero-bg" aria-hidden="true">
            <span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span>
            <span class="hero-grid"></span>
        </div>

        <div>
            <a href="{{ route('dashboard') }}" aria-label="Ke beranda"><x-brand variant="dark" size="lg" sub="Pemerintah Provinsi Jawa Timur" /></a>
        </div>

        <div>
            <h1>Sistem Informasi Ketahanan Pangan Malang Selatan</h1>
            <p>Pengelolaan dan penyajian data kawasan hutan, lahan kritis, lingkungan hidup, dan SDM di wilayah Malang Selatan.</p>
            <ul>
                <li><i class="bi bi-shield-fill-check"></i> <span><b>Administrator</b> · akses penuh &amp; kelola pengguna</span></li>
                <li><i class="bi bi-person-badge-fill"></i> <span><b>Petugas</b> · tambah, ubah, import &amp; export data</span></li>
                <li><i class="bi bi-eye-fill"></i> <span><b>Viewer</b> · lihat data &amp; export Excel</span></li>
            </ul>
        </div>

        <small>Bakorwil III Malang · Pemerintah Provinsi Jawa Timur</small>
    </aside>

    <main class="auth-form">
        <div class="box">
            <div class="auth-mobile-logo">
                <x-brand />
            </div>

            <h2>Masuk ke Panel Pengelola</h2>
            <p class="sub">Khusus pengguna terdaftar Bakorwil III Malang (Administrator, Petugas, Viewer).</p>

            @if ($errors->any())
                <div class="alert alert-error" role="alert" style="margin-bottom:18px">
                    <i class="bi bi-exclamation-octagon-fill"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="bi bi-envelope lead"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="nama@instansi.go.id" required autofocus autocomplete="username">
                    </div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <i class="bi bi-lock lead"></i>
                        <input id="password" type="password" name="password" class="input has-trail" placeholder="Masukkan password" required autocomplete="current-password">
                        <button type="button" class="trail" data-toggle-password>Lihat</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block" data-loading="Memeriksa…"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
            </form>

            <a href="{{ route('dashboard') }}" class="back"><i class="bi bi-arrow-left"></i> Kembali ke beranda</a>
        </div>
    </main>
</div>

</body>
</html>
