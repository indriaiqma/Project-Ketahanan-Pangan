<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Sistem Informasi Ketahanan Pangan')
    </title>

    {{-- CSS global (Tailwind) + CSS layout admin --}}
    @vite([
        'resources/css/app.css',
        'resources/css/admin.css',
        'resources/js/app.js',
    ])

    {{-- CSS khusus halaman --}}
    @yield('style')

</head>


<body>


{{-- =========================================================
     SIDEBAR ADMIN
========================================================= --}}

<aside
    class="sidebar"
    id="sidebar"
>


    {{-- LOGO --}}

    <div class="sidebar-brand">

        <img
            src="{{ asset('images/logo-bakorwil.png') }}"
            alt="Bakorwil III Malang"
            class="sidebar-logo"
        >

    </div>


    {{-- MENU --}}

    <div class="sidebar-menu">


        <div class="menu-label">
            MENU UTAMA
        </div>


        {{-- DASHBOARD --}}

        <div class="menu-item">

            <a
                href="{{ route('admin.dashboard') }}"
                class="menu-link
                {{ request()->is('admin') ? 'active' : '' }}"
            >

                <span class="menu-icon">
                    ▦
                </span>

                <span class="menu-text">
                    Dashboard
                </span>

            </a>

        </div>


        {{-- KEHUTANAN --}}

        <div class="menu-item">

            <div
                class="menu-link
                {{
                    request()->is('admin/kawasan-hutan*') ||
                    request()->is('admin/lahan-kritis*')
                    ? 'active'
                    : ''
                }}"
            >

                <span class="menu-icon">
                    ♣
                </span>

                <span class="menu-text">
                    Kehutanan
                </span>

                <span class="menu-arrow">
                    ›
                </span>

            </div>


            <div class="submenu">

                {{-- KAWASAN HUTAN --}}

                <a
                    href="{{ route('admin.kawasan-hutan.index') }}"
                    class="submenu-link
                    {{
                        request()->is('admin/kawasan-hutan*')
                        ? 'active'
                        : ''
                    }}"
                >
                    Kawasan Hutan
                </a>


                {{-- LAHAN KRITIS --}}

                <a
                    href="{{ url('/admin/lahan-kritis') }}"
                    class="submenu-link
                    {{
                        request()->is('admin/lahan-kritis*')
                        ? 'active'
                        : ''
                    }}"
                >
                    Lahan Kritis
                </a>

            </div>

        </div>


        {{-- LINGKUNGAN HIDUP --}}

        <div class="menu-item">

            <a
                href="{{ url('/admin/lingkungan-hidup') }}"
                class="menu-link
                {{
                    request()->is('admin/lingkungan-hidup*')
                    ? 'active'
                    : ''
                }}"
            >

                <span class="menu-icon">
                    ◇
                </span>

                <span class="menu-text">
                    Lingkungan Hidup
                </span>

            </a>

        </div>


        {{-- SDM --}}

        <div class="menu-item">

            <a
                href="{{ url('/admin/sdm') }}"
                class="menu-link
                {{
                    request()->is('admin/sdm*')
                    ? 'active'
                    : ''
                }}"
            >

                <span class="menu-icon">
                    ♙
                </span>

                <span class="menu-text">
                    SDM
                </span>

            </a>

        </div>


        {{-- ADMINISTRASI --}}

        <div class="menu-label menu-label-spaced">
            ADMINISTRASI
        </div>


        {{-- KELOLA PENGGUNA --}}

        <div class="menu-item">

            <a
                href="{{ route('admin.users.index') }}"
                class="menu-link
                {{
                    request()->is('admin/users*')
                    ? 'active'
                    : ''
                }}"
            >

                <span class="menu-icon">
                    ⚙
                </span>

                <span class="menu-text">
                    Kelola Pengguna
                </span>

            </a>

        </div>


    </div>


    {{-- =====================================================
         USER BOTTOM
    ====================================================== --}}

    <div class="sidebar-bottom">


        {{-- USER CARD --}}

        <div class="user-box">

            <div class="user-avatar">

                {{
                    strtoupper(
                        substr(
                            auth()->user()->name,
                            0,
                            1
                        )
                    )
                }}

            </div>


            <div class="user-data">

                <div class="user-name">

                    {{ auth()->user()->name }}

                </div>


                <div class="user-role">

                    Administrator

                </div>

            </div>

        </div>


        {{-- PROFILE --}}

        <a
            href="{{ route('admin.profile') }}"
            class="bottom-link"
        >

            <span class="bottom-icon">
                ○
            </span>

            <span>
                Profil Saya
            </span>

        </a>


        {{-- LOGOUT --}}

        <form
            action="{{ route('logout') }}"
            method="POST"
            class="logout-form"
        >

            @csrf

            <button
                type="submit"
                class="bottom-link"
            >

                <span class="bottom-icon">
                    ↪
                </span>

                <span>
                    Keluar
                </span>

            </button>

        </form>


    </div>

</aside>


{{-- MOBILE OVERLAY --}}

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
    onclick="closeSidebar()"
></div>


{{-- =========================================================
     MAIN WRAPPER
========================================================= --}}

<div class="main-wrapper">


    {{-- TOPBAR --}}

    <header class="topbar">

        <div class="topbar-left">

            <button
                type="button"
                class="menu-toggle"
                onclick="toggleSidebar()"
            >
                ☰
            </button>


            <div class="system-title">

                SISTEM INFORMASI KETAHANAN PANGAN MALANG SELATAN

            </div>

        </div>


        <div class="topbar-right">

            <span class="status-dot"></span>

            <span>
                Bakorwil III Malang
            </span>

        </div>

    </header>


    {{-- =====================================================
         PAGE HEADING
    ====================================================== --}}

    @if(!View::hasSection('hidePageHeading'))

        <section class="page-heading">

            <div class="page-heading-inner">

                <div class="eyebrow">

                    BAKORWIL III MALANG

                </div>


                <h1>

                    @yield('heading')

                </h1>


                <p>

                    Sistem Informasi Ketahanan Pangan Malang Selatan

                </p>

            </div>

        </section>

    @endif


    {{-- CONTENT --}}

    <main class="content">

        @yield('content')

    </main>


</div>


{{-- =========================================================
     JAVASCRIPT SIDEBAR
========================================================= --}}

<script>

    function toggleSidebar() {

        document
            .getElementById('sidebar')
            .classList
            .toggle('open');


        document
            .getElementById('sidebarOverlay')
            .classList
            .toggle('show');

    }


    function closeSidebar() {

        document
            .getElementById('sidebar')
            .classList
            .remove('open');


        document
            .getElementById('sidebarOverlay')
            .classList
            .remove('show');

    }

</script>


@yield('script')


</body>

</html>