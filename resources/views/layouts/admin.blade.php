<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · Admin SIKP Malang Selatan</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@php
    $user = auth()->user();
    $inisial = strtoupper(mb_substr($user->name, 0, 1));

    $menu = [
        'Utama' => [
            ['admin.dashboard', 'admin.dashboard', 'grid-1x2', 'Dashboard'],
        ],
        'Data Kehutanan' => [
            ['admin.kawasan-hutan.index', 'admin.kawasan-hutan.*', 'tree', 'Kawasan Hutan'],
            ['admin.lahan-kritis.index', 'admin.lahan-kritis.*', 'exclamation-triangle', 'Lahan Kritis'],
        ],
        'Modul Lain' => [
            ['admin.lingkungan-hidup.index', 'admin.lingkungan-hidup.*', 'globe-asia-australia', 'Lingkungan Hidup', 'Segera'],
            ['admin.sdm.index', 'admin.sdm.*', 'people', 'SDM', 'Segera'],
        ],
        'Pengaturan' => array_values(array_filter([
            // Kelola pengguna khusus Admin
            $user->isAdmin() ? ['admin.users.index', 'admin.users.*', 'person-gear', 'Pengguna'] : null,
            ['admin.profile', 'admin.profile', 'person-circle', 'Profil Saya'],
        ])),
    ];
@endphp

<div class="admin">
    <aside class="sidebar" aria-label="Navigasi admin">
        <a href="{{ route('admin.dashboard') }}" class="logo" aria-label="Dashboard panel pengelola">
            <x-brand variant="dark" size="sm" sub="Panel Pengelola SIKP" />
        </a>

        <nav>
            @foreach ($menu as $grup => $items)
                <div class="group">{{ $grup }}</div>
                @foreach ($items as $item)
                    @php([$route, $pola, $ikon, $label] = $item)
                    <a href="{{ route($route) }}" @class(['active' => request()->routeIs($pola)])>
                        <i class="bi bi-{{ $ikon }}"></i> {{ $label }}
                        @isset($item[4])<span class="tag">{{ $item[4] }}</span>@endisset
                    </a>
                @endforeach
            @endforeach
        </nav>

        <div class="foot">
            <a href="{{ route('admin.profile') }}" class="me">
                <span class="avatar role-{{ $user->role }}">{{ $inisial }}</span>
                <span class="me-txt"><b>{{ $user->name }}</b><small>{{ $user->roleLabel() }}</small></span>
            </a>
            <a href="{{ route('dashboard') }}" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right"></i> Lihat Situs Publik
            </a>
        </div>
    </aside>
    <div class="backdrop"></div>

    <div class="admin-main">
        <header class="topbar">
            <button type="button" class="btn btn-ghost btn-icon sidebar-toggle" data-sidebar-toggle aria-label="Buka menu">
                <i class="bi bi-list" style="font-size:22px"></i>
            </button>
            <div class="title">@yield('title', 'Dashboard')</div>

            <div class="right">
                <span class="role-pill role-{{ $user->role }}"><span class="dot"></span>{{ $user->roleLabel() }}</span>
                <div class="dropdown">
                    <button type="button" class="user" data-dropdown-toggle aria-expanded="false">
                        <span class="avatar role-{{ $user->role }}">{{ $inisial }}</span>
                        <span class="nm">{{ $user->name }}<small>{{ $user->roleLabel() }}</small></span>
                        <i class="bi bi-chevron-down" style="font-size:11px;color:var(--ink-400)"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="head"><b>{{ $user->name }}</b><small>{{ $user->email }}</small></div>
                        <hr>
                        <a href="{{ route('admin.profile') }}"><i class="bi bi-person"></i> Profil Saya</a>
                        <a href="{{ route('dashboard') }}" target="_blank" rel="noopener"><i class="bi bi-globe2"></i> Situs Publik</a>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="admin-content">
            <x-alerts />
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
