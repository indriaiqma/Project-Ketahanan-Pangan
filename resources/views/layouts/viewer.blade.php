<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistem Informasi Ketahanan Pangan')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #F7FAF8;
            color: #26382E;
        }

        a {
            text-decoration: none;
        }


        /* =========================
           NAVBAR VIEWER / PUBLIK
        ========================= */

        .viewer-navbar {
            height: 72px;

            background: #FFFFFF;
            border-bottom: 1px solid #E3EAE5;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 6%;

            position: sticky;
            top: 0;
            z-index: 1000;
        }


        /* =========================
           BRAND / LOGO
        ========================= */

        .viewer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .viewer-brand img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .viewer-brand-text strong {
            display: block;

            color: #256B4A;

            font-size: 13px;
            font-weight: 800;
        }

        .viewer-brand-text span {
            display: block;

            margin-top: 2px;

            color: #7A877F;

            font-size: 9px;
        }


        /* =========================
           MENU VIEWER
        ========================= */

        .viewer-menu {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .viewer-menu > a,
        .viewer-dropdown > button {
            border: none;
            background: transparent;

            padding: 10px 13px;

            color: #526158;

            font-size: 11px;
            font-weight: 600;

            cursor: pointer;

            border-radius: 8px;
        }

        .viewer-menu > a:hover,
        .viewer-dropdown:hover > button {
            background: #EEF7F1;
            color: #256B4A;
        }

        .viewer-menu > a.active {
            color: #256B4A;
            background: #EEF7F1;
        }


        /* =========================
           DROPDOWN KEHUTANAN
        ========================= */

        .viewer-dropdown {
            position: relative;
        }

        .viewer-dropdown-menu {
            position: absolute;

            top: 100%;
            left: 0;

            min-width: 170px;

            padding: 7px;
            padding-top: 10px;

            background: #FFFFFF;

            border: 1px solid #E2EAE5;
            border-radius: 10px;

            box-shadow:
                0 10px 25px rgba(32, 59, 44, 0.10);

            display: none;
        }

        .viewer-dropdown::after {
            content: "";

            position: absolute;

            top: 100%;
            left: 0;

            width: 100%;
            height: 12px;
        }

        .viewer-dropdown:hover .viewer-dropdown-menu {
            display: block;
        }

        .viewer-dropdown-menu a {
            display: block;

            padding: 9px 11px;

            color: #526158;

            font-size: 10px;

            border-radius: 7px;
        }

        .viewer-dropdown-menu a:hover {
            background: #EEF7F1;
            color: #256B4A;
        }


        /* =========================
           CONTENT
        ========================= */

        .viewer-main {
            width: min(1180px, 88%);

            margin: 0 auto;

            padding: 35px 0 55px;
        }


        /* =========================
           FOOTER
        ========================= */

        .viewer-footer {
            padding: 24px 6%;

            border-top: 1px solid #E3EAE5;

            background: #FFFFFF;

            text-align: center;

            color: #8A958E;

            font-size: 9px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .viewer-navbar {
                height: auto;

                min-height: 72px;

                padding: 14px 5%;

                flex-wrap: wrap;

                gap: 12px;
            }

            .viewer-menu {
                width: 100%;

                justify-content: center;

                flex-wrap: wrap;
            }
        }


        @media (max-width: 600px) {

            .viewer-navbar {
                justify-content: center;
            }

            .viewer-brand {
                width: 100%;

                justify-content: center;
            }

            .viewer-menu {
                gap: 0;
            }

            .viewer-menu > a,
            .viewer-dropdown > button {
                padding: 8px 9px;

                font-size: 10px;
            }

            .viewer-main {
                width: 92%;

                padding-top: 22px;
            }
        }
    </style>

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

            <div style="
                margin-bottom:18px;
                padding:11px 14px;
                background:#EEF7F1;
                border:1px solid #D7EBDD;
                border-radius:8px;
                color:#347A55;
                font-size:10px;
            ">

                {{ session('success') }}

            </div>

        @endif


        {{-- ERROR MESSAGE --}}

        @if(session('error'))

            <div style="
                margin-bottom:18px;
                padding:11px 14px;
                background:#FFF1F0;
                border:1px solid #F1D6D4;
                border-radius:8px;
                color:#B44F4A;
                font-size:10px;
            ">

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