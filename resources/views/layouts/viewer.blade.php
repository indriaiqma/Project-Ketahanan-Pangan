
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Sistem Informasi Ketahanan Pangan')
        - Bakorwil III Malang
    </title>

    @vite(['resources/css/viewer.css'])

    {{-- CSS khusus halaman tetap dapat digunakan --}}
    @yield('style')
</head>
<body class="viewer-page">

    {{-- NAVBAR VIEWER --}}
    <header class="viewer-navbar">
        <div class="viewer-navbar-inner">

            <a href="{{ route('dashboard') }}"
               class="viewer-brand"
               aria-label="Dashboard Bakorwil III Malang">

                <img
                    src="{{ asset('images/logo-bakorwil.png') }}"
                    alt="Logo Bakorwil III Malang"
                >

                <span class="viewer-brand-text">
                    <span class="viewer-brand-title">
                        BAKORWIL III MALANG
                    </span>
                    <span class="viewer-brand-subtitle">
                        Sistem Informasi Ketahanan Pangan
                    </span>
                </span>
            </a>

            <nav class="viewer-menu" aria-label="Navigasi utama">

                <a
                    href="{{ route('dashboard') }}"
                    class="viewer-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    @if(request()->routeIs('dashboard')) aria-current="page" @endif
                >
                    Dashboard
                </a>

                <details class="viewer-dropdown"
                    {{ request()->routeIs('kawasan-hutan.*', 'lahan-kritis.*') ? 'open' : '' }}>

                    <summary class="viewer-dropdown-toggle
                        {{ request()->routeIs('kawasan-hutan.*', 'lahan-kritis.*') ? 'active' : '' }}">
                        Kehutanan
                        <span aria-hidden="true">⌄</span>
                    </summary>

                    <div class="viewer-dropdown-menu">
                        <a href="{{ route('kawasan-hutan.index') }}">
                            Kawasan Hutan
                        </a>
                        <a href="{{ route('lahan-kritis.index') }}">
                            Lahan Kritis
                        </a>
                    </div>
                </details>

                <a
                    href="{{ route('lingkungan-hidup') }}"
                    class="viewer-menu-link {{ request()->routeIs('lingkungan-hidup') ? 'active' : '' }}"
                >
                    Lingkungan Hidup
                </a>

                <a
                    href="{{ route('sdm') }}"
                    class="viewer-menu-link {{ request()->routeIs('sdm') ? 'active' : '' }}"
                >
                    SDM
                </a>

            </nav>
        </div>
    </header>

    {{-- KONTEN HALAMAN --}}
    <main class="viewer-main">

        @if(session('success'))
            <div class="viewer-alert viewer-alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="viewer-alert viewer-alert-error" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @hasSection('hidePageHeading')
            @yield('content')
        @else
            @hasSection('heading')
                <div class="viewer-page-heading">
                    <h1>@yield('heading')</h1>
                </div>
            @endif

            @yield('content')
        @endif

    </main>

    {{-- FOOTER --}}
    <footer class="viewer-footer">
        <strong>Sistem Informasi Ketahanan Pangan Malang Selatan</strong>
        <span aria-hidden="true"> &nbsp;•&nbsp; </span>
        Bakorwil III Malang Provinsi Jawa Timur
    </footer>

    {{-- JavaScript halaman tetap berjalan --}}
    @yield('script')

</body>
</html>
