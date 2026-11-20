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
@php($navBidang = auth()->check() ? \App\Support\Bidang::untuk(auth()->user()) : \App\Support\Bidang::semua())
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

            <div @class(['dropdown', 'active' => request()->routeIs('kawasan-hutan.*', 'lahan-kritis.*')])>
                <button type="button" data-dropdown-toggle aria-expanded="false">
                    Kehutanan <i class="bi bi-chevron-down chev"></i>
                </button>
                <div class="dropdown-menu left">
                    <a href="{{ route('kawasan-hutan.index') }}"><i class="bi bi-tree"></i> Kawasan Hutan</a>
                    <a href="{{ route('lahan-kritis.index') }}"><i class="bi bi-exclamation-triangle"></i> Lahan Kritis</a>
                </div>
            </div>

            <div @class(['dropdown', 'active' => request()->routeIs('data.*')])>
                <button type="button" data-dropdown-toggle aria-expanded="false">
                    Data Bidang <i class="bi bi-chevron-down chev"></i>
                </button>
                <div class="dropdown-menu left">
                    <a href="{{ route('data.index') }}"><i class="bi bi-grid-1x2"></i> Semua Bidang</a>
                    <hr>
                    @foreach ($navBidang as $nb)
                        <a href="{{ route('data.bidang', $nb['slug']) }}"><i class="bi bi-{{ $nb['icon'] }}"></i> {{ $nb['nama'] }}</a>
                    @endforeach
                    @guest
                        <hr>
                        <span class="nav-note"><i class="bi bi-lock"></i> Masuk untuk melihat data bidang</span>
                    @endguest
                </div>
            </div>

            @auth
                @if (auth()->user()->isStaff())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm"><i class="bi bi-speedometer2"></i> Panel Pengelola</a>
                @else
                    <div class="dropdown nav-user">
                        <button type="button" data-dropdown-toggle aria-expanded="false" aria-label="Menu akun">
                            <span class="avatar sm">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                            <span class="nav-user-name">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 18) }}</span>
                            <i class="bi bi-chevron-down chev"></i>
                        </button>
                        <div class="dropdown-menu">
                            <div class="head">
                                <b>{{ auth()->user()->name }}</b>
                                <small>{{ auth()->user()->roleLabel() }} · hanya melihat data</small>
                            </div>
                            <hr>
                            <a href="{{ route('data.index') }}"><i class="bi bi-grid-1x2"></i> Data Bidang</a>
                            <a href="{{ route('admin.profile') }}"><i class="bi bi-person-circle"></i> Profil Saya</a>
                            <hr>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm"><i class="bi bi-box-arrow-in-right"></i> Masuk</a>
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
            <a href="{{ route('kawasan-hutan.index') }}">Kawasan Hutan</a>
            <a href="{{ route('lahan-kritis.index') }}">Lahan Kritis</a>
        </div>
        <div>
            <h4>Instansi</h4>
            <span>Bakorwil III Malang</span>
            <span>Pemerintah Provinsi Jawa Timur</span>
            @auth
                @if (auth()->user()->isStaff())
                    <a href="{{ route('admin.dashboard') }}">Panel Pengelola</a>
                @else
                    <a href="{{ route('admin.profile') }}">Profil Saya</a>
                @endif
            @else
                <a href="{{ route('login') }}">Masuk</a>
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
