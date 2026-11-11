<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistem Informasi Ketahanan Pangan')</title>

    {{-- CSS global (Tailwind) + CSS layout viewer --}}
    @vite([
        'resources/css/app.css',
        'resources/css/viewer.css',
        'resources/js/app.js',
    ])

    {{-- CSS khusus halaman --}}
    @yield('style')
</head>


<body>


    {{-- ==========================================
         NAVBAR VIEWER
    =========================================== --}}

    <nav class="viewer-navbar">


        {{-- LOGO --}}

        <a
            href="{{ route('dashboard') }}"
            class="viewer-brand"
        >

            <img
                src="{{ asset('images/logo-bakorwil.png') }}"
                alt="Logo Bakorwil"
            >

            <div class="viewer-brand-text">

                <strong>
                    BAKORWIL III MALANG
                </strong>

                <span>
                    Sistem Informasi Ketahanan Pangan
                </span>

            </div>

        </a>


        {{-- MENU VIEWER --}}

        <div class="viewer-menu">


            {{-- DASHBOARD --}}

            <a
                href="{{ route('dashboard') }}"
                class="{{ request()->is('/') ? 'active' : '' }}"
            >
                Dashboard
            </a>


            {{-- KEHUTANAN --}}

            <div class="viewer-dropdown">

                <button type="button">
                    Kehutanan ▾
                </button>

                <div class="viewer-dropdown-menu">

                    <a href="{{ route('kawasan-hutan.index') }}">
                        Kawasan Hutan
                    </a>

                    <a href="{{ route('lahan-kritis.index') }}">
                        Lahan Kritis
                    </a>

                </div>

            </div>


            {{-- LINGKUNGAN HIDUP --}}

            <a
                href="{{ route('lingkungan-hidup') }}"
                class="{{ request()->is('lingkungan-hidup') ? 'active' : '' }}"
            >
                Lingkungan Hidup
            </a>


            {{-- SDM --}}

            <a
                href="{{ route('sdm') }}"
                class="{{ request()->is('sdm') ? 'active' : '' }}"
            >
                SDM
            </a>


        </div>

    </nav>


    {{-- ==========================================
         CONTENT
    =========================================== --}}

    <main class="viewer-main">


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="viewer-alert viewer-alert-success">

                {{ session('success') }}

            </div>

        @endif


        {{-- ERROR MESSAGE --}}

        @if(session('error'))

            <div class="viewer-alert viewer-alert-error">

                {{ session('error') }}

            </div>

        @endif


        {{-- ISI HALAMAN --}}

        @yield('content')


    </main>


    {{-- ==========================================
         FOOTER
    =========================================== --}}

    <footer class="viewer-footer">

        Sistem Informasi Ketahanan Pangan Malang Selatan
        · Bakorwil III Malang Provinsi Jawa Timur

    </footer>


    @yield('script')


</body>
</html>