<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Bakorwil III Malang</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/dashboard-viewer.css'])
    @stack('styles')
</head>
<body class="dv-body">

@php
    // Helper: pakai route kalau ada, kalau belum ada jatuh ke '#'
    $r = fn ($name, $fallback = '#') => \Illuminate\Support\Facades\Route::has($name) ? route($name) : $fallback;
@endphp

<header class="dv-nav">
    <div class="dv-container dv-nav__inner">
        <a href="{{ $r('dashboard') }}" class="dv-brand">
    <img src="{{ asset('images/logo-bakorwil.png') }}" class="dv-brand__img" alt="Bakorwil III Malang Prov Jatim">
     <span class="dv-brand__text">
    <span class="dv-brand__title">Sistem Informasi Ketahanan Pangan</span>
    <span class="dv-brand__sub">Wilayah Malang Selatan</span>
</span>
</a>

        <nav class="dv-menu">
            <div class="dv-menu__item">
                <a href="{{ $r('dashboard') }}" class="dv-menu__link {{ request()->routeIs('dashboard*') ? 'is-active' : '' }}">
                    <i class="bi bi-house-door-fill"></i> <span class="txt-hide">Dashboard</span>
                </a>
            </div>

            <div class="dv-menu__item dv-hover" data-dropdown>
                <button type="button" class="dv-menu__link">Kehutanan <i class="bi bi-chevron-down" style="font-size:11px"></i></button>
                <div class="dv-dropdown">
                    <a href="{{ $r('kawasan-hutan.index') }}">Kawasan Hutan</a>
                    <a href="{{ $r('lahan-kritis.index') }}">Lahan Kritis</a>
                </div>
            </div>

            <div class="dv-menu__item">
                <a href="{{ $r('lingkungan-hidup') }}" class="dv-menu__link">Lingkungan Hidup</a>
            </div>

            <div class="dv-menu__item">
                <a href="{{ $r('sdm') }}" class="dv-menu__link">SDM</a>
            </div>

            <div class="dv-menu__item" data-dropdown style="margin-left:14px">
                <button type="button" class="dv-menu__link" style="padding:4px 8px">
                    <span class="dv-avatar"><i class="bi bi-person-fill"></i></span>
                    <i class="bi bi-chevron-down" style="font-size:11px"></i>
                </button>
                <div class="dv-dropdown right">
                    @auth
                        <a href="{{ $r('admin.profile') }}">Profil</a>
                        <form method="POST" action="{{ $r('logout') }}">
                            @csrf
                            <button type="submit">Keluar</button>
                        </form>
                    @else
                        <a href="{{ $r('login') }}">Masuk</a>
                    @endauth
                </div>
            </div>
        </nav>
    </div>
</header>

<main class="dv-container">
    @yield('content')
</main>

<footer class="dv-footer">
    <div class="dv-container dv-footer__inner">
        <div>
            <strong>BAKORWIL III MALANG</strong>
            <span>Pemerintah Provinsi Jawa Timur</span>
        </div>
        <div class="dv-footer__right">
            Sistem Informasi Ketahanan Pangan<br>
            &copy; {{ date('Y') }} Bakorwil III Malang. Hak cipta dilindungi.
        </div>
    </div>
</footer>

<script>
    // Dropdown sederhana (klik untuk buka, klik di luar untuk tutup)
    document.querySelectorAll('[data-dropdown]').forEach(function (el) {
        el.querySelector('button').addEventListener('click', function (e) {
            e.stopPropagation();
            document.querySelectorAll('[data-dropdown].open').forEach(function (o) { if (o !== el) o.classList.remove('open'); });
            el.classList.toggle('open');
        });
    });
    document.addEventListener('click', function () {
        document.querySelectorAll('[data-dropdown].open').forEach(function (o) { o.classList.remove('open'); });
    });
</script>
@stack('scripts')
</body>
</html>