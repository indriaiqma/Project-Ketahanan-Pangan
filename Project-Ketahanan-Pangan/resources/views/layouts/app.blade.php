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


    <style>

        /* =====================================================
           ROOT
        ===================================================== */

        :root {

    /* SIDEBAR - HIJAU FOREST ELEGAN */
    --green: #245B47;
    --green-dark: #173F31;
    --green-active: #3F8063;
    --green-hover: #2F6D53;
    --green-light: #7FB69A;
    --green-soft: #EAF3EE;

    /* CONTENT */
    --background: #F5F8F6;
    --white: #FFFFFF;
    --border: #DDE7E1;

    --heading: #1D3529;
    --text: #34483C;
    --muted: #718078;
}


        /* =====================================================
           RESET
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;

            font-family: Arial, Helvetica, sans-serif;

            background: var(--background);

            color: var(--text);
        }

        a {
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .sidebar {

    position: fixed;

    top: 0;
    left: 0;

    width: 255px;
    height: 100vh;

    display: flex;
    flex-direction: column;

    background: linear-gradient(
        180deg,
        #245B47 0%,
        #1F5541 48%,
        #194936 100%
    );

    color: #FFFFFF;

    z-index: 1000;

    box-shadow:
        4px 0 22px rgba(20, 60, 45, .16);

    overflow-y: auto;
    overflow-x: hidden;
}


        /* SCROLLBAR */

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.18);
            border-radius: 20px;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .sidebar-brand {

            min-height: 105px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 18px 20px;

            border-bottom:
                1px solid rgba(255,255,255,.13);
        }

        .sidebar-logo {

            display: block;

            width: 180px;
            max-width: 100%;

            height: auto;

            object-fit: contain;
        }


        /* =====================================================
           MENU AREA
        ===================================================== */

        .sidebar-menu {

            flex: 1;

            padding: 18px 13px;
        }


        /* MENU LABEL */

        .menu-label {

            margin: 4px 13px 10px;

            color: rgba(255,255,255,.60);

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.2px;
        }


        /* MENU ITEM */

        .menu-item {
            margin-bottom: 4px;
        }


        /* MENU LINK */

        .menu-link {

            min-height: 44px;

            display: flex;
            align-items: center;

            gap: 11px;

            padding: 0 13px;

            border-radius: 9px;

            color: rgba(255,255,255,.82);

            font-size: 12px;
            font-weight: 600;

            transition: .18s ease;
        }

        .menu-link:hover {

    color: #FFFFFF;

    background:
        #2F6D53;
}
        .menu-link.active {

    color: #FFFFFF;

    background:
        #3F8063;

    box-shadow:
        inset 3px 0 0 #8BC3A4;
}


        /* MENU ICON */

        .menu-icon {

            width: 24px;
            min-width: 24px;

            display: flex;
            align-items: center;
            justify-content: center;

            color: rgba(255,255,255,.88);

            font-size: 15px;
        }


        /* MENU TEXT */

        .menu-text {
            flex: 1;
        }


        /* MENU ARROW */

        .menu-arrow {

            font-size: 13px;

            opacity: .65;
        }


        /* =====================================================
           SUBMENU
        ===================================================== */

        .submenu {

            margin: 4px 0 8px 39px;

            padding:
                3px 0
                3px 11px;

            border-left:
                1px solid rgba(255,255,255,.18);
        }


        .submenu-link {

            position: relative;

            display: block;

            padding: 8px 11px;

            margin-bottom: 2px;

            border-radius: 7px;

            color: rgba(255,255,255,.66);

            font-size: 11px;
            font-weight: 500;

            transition: .18s ease;
        }


        .submenu-link:hover {

            color: #FFFFFF;

            background:
                rgba(255,255,255,.08);
        }


        .submenu-link.active {

            color: #FFFFFF;

            font-weight: 700;

            background:
                rgba(255,255,255,.15);
        }


        /* =====================================================
           SIDEBAR BOTTOM
        ===================================================== */

        .sidebar-bottom {

    padding: 13px;

    border-top:
        1px solid rgba(255,255,255,.10);

    background:
        rgba(10, 45, 34, .18);
}


        /* =====================================================
           USER BOX
        ===================================================== */

        .user-box {

            display: flex;
            align-items: center;

            gap: 10px;

            padding: 11px;

            margin-bottom: 7px;

            border:
                1px solid rgba(255,255,255,.07);

            border-radius: 10px;

            background:
                rgba(255,255,255,.10);
        }


        /* AVATAR */

        .user-avatar {

            width: 38px;
            height: 38px;
            min-width: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #86D3A3;

            color: #FFFFFF;

            font-size: 14px;
            font-weight: 700;
        }


        /* USER DATA */

        .user-data {

            flex: 1;

            min-width: 0;
        }


        .user-name {

            color: #FFFFFF;

            font-size: 12px;
            font-weight: 700;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        .user-role {

            margin-top: 3px;

            color:
                rgba(255,255,255,.62);

            font-size: 8px;
            font-weight: 700;

            letter-spacing: .3px;

            text-transform: uppercase;
        }


        /* =====================================================
           BOTTOM LINK
        ===================================================== */

        .bottom-link {

            width: 100%;
            min-height: 39px;

            display: flex;
            align-items: center;

            gap: 10px;

            padding: 0 11px;

            border: none;
            border-radius: 8px;

            background: transparent;

            color:
                rgba(255,255,255,.76);

            font-size: 11px;
            font-weight: 600;

            cursor: pointer;

            transition: .18s ease;
        }


        .bottom-link:hover {

            color: #FFFFFF;

            background:
                rgba(255,255,255,.09);
        }


        .bottom-icon {

            width: 21px;

            display: flex;
            align-items: center;
            justify-content: center;

            color:
                rgba(255,255,255,.82);

            font-size: 12px;
        }


        .logout-form {
            margin: 0;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .main-wrapper {

            min-height: 100vh;

            margin-left: 255px;

            display: flex;

            flex-direction: column;
        }


        /* =====================================================
           TOPBAR
        ===================================================== */

        .topbar {

            height: 64px;

            position: sticky;

            top: 0;

            z-index: 900;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 32px;

            background:
                rgba(255,255,255,.97);

            border-bottom:
                1px solid var(--border);

            box-shadow:
                0 2px 8px rgba(32,59,44,.025);
        }


        .topbar-left {

            display: flex;

            align-items: center;

            gap: 12px;
        }


        .system-title {

            color: var(--muted);

            font-size: 11px;

            font-weight: 700;

            letter-spacing: .4px;
        }


        .topbar-right {

            display: flex;

            align-items: center;

            gap: 8px;

            color: var(--muted);

            font-size: 12px;

            font-weight: 600;
        }


        .status-dot {

            width: 7px;
            height: 7px;

            border-radius: 50%;

            background:
                var(--green-light);
        }


        /* =====================================================
           PAGE HEADING
        ===================================================== */

        .page-heading {

            padding:
                29px 32px 22px;
        }


        .page-heading-inner {

            max-width: 1220px;

            margin: auto;
        }


        .eyebrow {

            margin-bottom: 7px;

            color:
                var(--green-active);

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.1px;
        }


        .page-heading h1 {

            margin: 0 0 6px;

            color:
                var(--heading);

            font-size: 27px;

            line-height: 1.25;
        }


        .page-heading p {

            margin: 0;

            color:
                var(--muted);

            font-size: 13px;

            line-height: 1.6;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .content {

            width: 100%;

            max-width: 1284px;

            margin: 0 auto;

            padding:
                0 32px 45px;

            flex: 1;
        }


        /* DEFAULT CARD */

        .card {

            background:
                var(--white);

            border:
                1px solid var(--border);

            border-radius: 12px;

            padding: 20px;

            margin-bottom: 20px;

            box-shadow:
                0 4px 14px
                rgba(32,59,44,.035);
        }


        /* =====================================================
           MOBILE MENU BUTTON
        ===================================================== */

        .menu-toggle {

            display: none;

            width: 38px;
            height: 38px;

            border: none;

            border-radius: 8px;

            align-items: center;
            justify-content: center;

            background:
                var(--green-soft);

            color:
                var(--green);

            font-size: 18px;

            cursor: pointer;
        }


        .sidebar-overlay {
            display: none;
        }


        /* =====================================================
           RESPONSIVE TABLET
        ===================================================== */

        @media(max-width: 950px) {

            .sidebar {

                transform:
                    translateX(-100%);

                transition:
                    transform .25s ease;
            }


            .sidebar.open {

                transform:
                    translateX(0);
            }


            .main-wrapper {

                margin-left: 0;
            }


            .menu-toggle {

                display: flex;
            }


            .sidebar-overlay {

                position: fixed;

                inset: 0;

                z-index: 950;

                background:
                    rgba(0,0,0,.35);
            }


            .sidebar-overlay.show {

                display: block;
            }


            .topbar {

                padding: 0 20px;
            }


            .system-title {

                display: none;
            }


            .page-heading {

                padding:
                    24px 20px 20px;
            }


            .content {

                padding:
                    0 20px 35px;
            }

        }


        /* =====================================================
           RESPONSIVE MOBILE
        ===================================================== */

        @media(max-width: 600px) {

            .topbar {

                height: 60px;

                padding:
                    0 15px;
            }


            .topbar-right span:last-child {

                display: none;
            }


            .page-heading {

                padding:
                    21px 15px 18px;
            }


            .page-heading h1 {

                font-size: 23px;
            }


            .content {

                padding:
                    0 15px 30px;
            }

        }

    </style>


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

        <div
            class="menu-label"
            style="margin-top: 22px;"
        >
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