<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title') · Sistem Informasi Ketahanan Pangan Malang Selatan</title>
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
            @hasSection('aside')
                @yield('aside')
            @else
                <h1>Sistem Informasi Ketahanan Pangan Malang Selatan</h1>
                <p>Pengelolaan dan penyajian data seluruh bidang Bakorwil III Malang di wilayah Malang Selatan.</p>
                <ul>
                    <li><i class="bi bi-shield-fill-check"></i> <span><b>Administrator</b> · akses penuh &amp; kelola pengguna</span></li>
                    <li><i class="bi bi-person-badge-fill"></i> <span><b>Petugas</b> · tambah, ubah, hapus, import &amp; export data</span></li>
                    <li><i class="bi bi-globe2"></i> <span><b>Masyarakat</b> · lihat data di situs publik tanpa login</span></li>
                </ul>
            @endif
        </div>

        <small>Bakorwil III Malang · Pemerintah Provinsi Jawa Timur</small>
    </aside>

    <main class="auth-form">
        <div class="box">
            <div class="auth-mobile-logo">
                <x-brand />
            </div>

            @yield('content')
        </div>
    </main>
</div>

</body>
</html>
