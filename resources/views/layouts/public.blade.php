<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Informasi Ketahanan Pangan Malang Selatan: data pemerintahan, ekonomi, kemasyarakatan, sarana prasarana, dan kehutanan Bakorwil III Malang, Provinsi Jawa Timur.">
    <meta name="theme-color" content="#0b3a26">
    <title>@yield('title', 'Beranda') · Sistem Informasi Ketahanan Pangan Malang Selatan</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php($navBidang = \App\Support\Bidang::reguler())
@php($navKhusus = \App\Support\Bidang::khusus())
<body @class(['has-hero' => View::hasSection('hero')])>

<header class="site-nav" data-site-nav>
    <div class="container">
        <a href="{{ route('dashboard') }}" class="brand" aria-label="Beranda Sistem Informasi Ketahanan Pangan Bakorwil III Malang">
            <x-brand />
        </a>

        <button type="button" class="btn btn-ghost btn-icon nav-toggle" data-nav-toggle aria-label="Buka menu">
            <i class="bi bi-list" style="font-size:22px"></i>
        </button>

        <nav class="site-menu" aria-label="Menu utama">
            <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Beranda</a>

            <div @class(['dropdown', 'active' => request()->routeIs('data.*', 'kawasan-hutan.*', 'lahan-kritis.*')])>
                <button type="button" data-dropdown-toggle aria-expanded="false">
                    Data Bidang <i class="bi bi-chevron-down chev"></i>
                </button>
                <div class="dropdown-menu left">
                    <a href="{{ route('data.index') }}"><i class="bi bi-grid-1x2"></i> Semua Bidang</a>
                    <hr>
                    @foreach ($navBidang as $nb)
                        <a href="{{ route('data.bidang', $nb['slug']) }}"><i class="bi bi-{{ $nb['icon'] }}"></i> {{ $nb['nama'] }}</a>
                    @endforeach
                    <hr>
                    <span class="nav-note"><i class="bi bi-globe2"></i> Terbuka untuk umum, tanpa login</span>
                </div>
            </div>

            @foreach ($navKhusus as $nk)
                <div @class(['dropdown', 'active' => request()->is('data/'.$nk['slug'], 'data/'.$nk['slug'].'/*')])>
                    <button type="button" data-dropdown-toggle aria-expanded="false">
                        {{ $nk['nama'] }} <i class="bi bi-chevron-down chev"></i>
                    </button>
                    <div class="dropdown-menu left">
                        <a href="{{ route('data.bidang', $nk['slug']) }}"><i class="bi bi-grid-1x2"></i> Ringkasan</a>
                        <hr>
                        @foreach (\App\Support\Bidang::modulBidang($nk) as $m)
                            <a href="{{ route('data.modul', ['bidang' => $nk['slug'], 'modul' => $m['slug']]) }}"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i> {{ $m['nama'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm"><i class="bi bi-speedometer2"></i> Panel Pengelola</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm" title="Khusus Administrator & Petugas"><i class="bi bi-box-arrow-in-right"></i> Masuk Petugas</a>
            @endauth
        </nav>
    </div>
</header>

@yield('hero')

<main class="site-main">
    <div class="container">
        <x-alerts />
        @yield('content')
    </div>
</main>

<footer class="site-foot">
    <div class="container foot-grid">
        <div>
            <x-brand variant="dark" />
            <p>Sistem Informasi Ketahanan Pangan Malang Selatan. Penyajian data seluruh bidang Bakorwil III Malang untuk mendukung perencanaan wilayah.</p>
        </div>
        <div>
            <h4>Data Bidang</h4>
            @foreach ($navBidang as $nb)
                <a href="{{ route('data.bidang', $nb['slug']) }}">{{ $nb['nama'] }}</a>
            @endforeach
            @foreach ($navKhusus as $nk)
                <a href="{{ route('data.bidang', $nk['slug']) }}">{{ $nk['nama'] }}</a>
            @endforeach
            <a href="{{ route('kawasan-hutan.index') }}">Kawasan Hutan</a>
            <a href="{{ route('lahan-kritis.index') }}">Lahan Kritis</a>
        </div>
        <div>
            <h4>Instansi</h4>
            <span>Bakorwil III Malang</span>
            <span>Pemerintah Provinsi Jawa Timur</span>
            @auth
                <a href="{{ route('admin.dashboard') }}">Panel Pengelola</a>
            @else
                <a href="{{ route('login') }}">Masuk Petugas</a>
            @endauth
        </div>
    </div>
    <div class="container foot-bottom">
        <span>&copy; {{ date('Y') }} Bakorwil III Malang. Seluruh hak dilindungi.</span>
        <a href="#" data-back-to-top><i class="bi bi-arrow-up"></i> Kembali ke atas</a>
    </div>
</footer>

@stack('scripts')
</body>
</html>
