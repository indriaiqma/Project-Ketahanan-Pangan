@extends('layouts.admin')

@section('title', 'Dashboard')

@php
    $user = auth()->user();
    $jam = (int) now()->format('H');
    $salam = match (true) {
        $jam < 11 => 'Selamat pagi',
        $jam < 15 => 'Selamat siang',
        $jam < 18 => 'Selamat sore',
        default   => 'Selamat malam',
    };

    // Ringkasan peran untuk banner
    $peran = [
        'admin'   => ['shield-fill-check', 'Anda memiliki akses penuh: mengelola data, menghapus data, dan mengatur akun pengguna.'],
        'petugas' => ['person-badge-fill', 'Anda dapat menambah, memperbarui, serta mengimpor dan mengekspor data.'],
        'viewer'  => ['eye-fill', 'Akun Anda bersifat hanya-baca: melihat seluruh data dan mengunduh export Excel.'],
    ][$user->role] ?? ['person-fill', 'Selamat datang di panel pengelola.'];

    // Matriks hak akses (ditampilkan sesuai role yang sedang login)
    $hakAkses = [
        ['Melihat dashboard & data', true],
        ['Export data ke Excel', true],
        ['Tambah & ubah data', $user->canEditData()],
        ['Import data dari Excel', $user->canEditData()],
        ['Hapus data', $user->isAdmin()],
        ['Kelola akun pengguna', $user->isAdmin()],
    ];
@endphp

@section('content')

{{-- ===== Banner sambutan ===== --}}
<section class="welcome role-{{ $user->role }}">
    <div class="welcome-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span></div>

    <div class="welcome-copy">
        <span class="role-chip"><i class="bi bi-{{ $peran[0] }}"></i> {{ $user->roleLabel() }}</span>
        <h1>{{ $salam }}, {{ $user->name }}</h1>
        <p>{{ $peran[1] }}</p>
        <div class="welcome-meta">
            <span><i class="bi bi-calendar3"></i> {{ now()->translatedFormat('l, d F Y') }}</span>
            <span><i class="bi bi-clock-history"></i> {{ $terakhirDiperbarui ? 'Data diperbarui ' . $terakhirDiperbarui . ' WIB' : 'Belum ada data' }}</span>
        </div>
    </div>

    <div class="welcome-actions">
        @if ($user->canEditData())
            <a href="{{ route('admin.kawasan-hutan.create') }}" class="quick">
                <i class="bi bi-tree"></i><span><b>Tambah Kawasan</b><small>Data kawasan hutan baru</small></span>
            </a>
            <a href="{{ route('admin.lahan-kritis.create') }}" class="quick">
                <i class="bi bi-exclamation-triangle"></i><span><b>Tambah Lahan Kritis</b><small>Data per kecamatan</small></span>
            </a>
        @else
            <a href="{{ route('admin.kawasan-hutan.export') }}" class="quick">
                <i class="bi bi-download"></i><span><b>Export Kawasan</b><small>Unduh file Excel</small></span>
            </a>
            <a href="{{ route('admin.lahan-kritis.export') }}" class="quick">
                <i class="bi bi-download"></i><span><b>Export Lahan Kritis</b><small>Unduh file Excel</small></span>
            </a>
        @endif
        @if ($user->isAdmin())
            <a href="{{ route('admin.users.create') }}" class="quick">
                <i class="bi bi-person-plus"></i><span><b>Tambah Pengguna</b><small>Admin, petugas, viewer</small></span>
            </a>
        @else
            <a href="{{ route('dashboard') }}" target="_blank" rel="noopener" class="quick">
                <i class="bi bi-globe2"></i><span><b>Situs Publik</b><small>Lihat tampilan pengunjung</small></span>
            </a>
        @endif
    </div>
</section>

{{-- ===== Statistik ===== --}}
<section class="grid grid-4">
    <x-stat icon="tree-fill" label="Kawasan Hutan" :value="angka($totalKawasan, 0)" unit="data kawasan" :href="route('admin.kawasan-hutan.index')" />
    <x-stat icon="map-fill" label="Total Luas Kawasan" :value="angka($totalLuasKawasan)" unit="hektare" tone="sky" :href="route('admin.kawasan-hutan.index')" />
    <x-stat icon="exclamation-triangle-fill" label="Total Lahan Kritis" :value="angka($totalLahanKritis)" unit="hektare" tone="amber" :href="route('admin.lahan-kritis.index')" />
    <x-stat icon="geo-alt-fill" label="Kecamatan Terdata" :value="angka($jumlahKecamatanLahanKritis, 0)" unit="kecamatan" :href="route('admin.lahan-kritis.index')" />
</section>

{{-- ===== Grafik ===== --}}
<section class="grid grid-main">
    @include('partials.chart-lahan-kritis', [
        'labels' => array_keys($lahanPerKecamatan),
        'sangat' => array_column($lahanPerKecamatan, 0),
        'kritis' => array_column($lahanPerKecamatan, 1),
        'agak'   => array_column($lahanPerKecamatan, 2),
    ])
    @include('partials.chart-komposisi', ['ringkasan' => $ringkasan])
</section>

<section class="grid grid-main">
    @include('partials.chart-kawasan', ['labels' => array_keys($kawasanPerKecamatan), 'values' => array_values($kawasanPerKecamatan)])

    {{-- ===== Hak akses ===== --}}
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-key-fill"></i></span>
                <div><h2>Hak Akses Anda</h2><p>Sebagai {{ $user->roleLabel() }}</p></div>
            </div>
        </div>
        <ul class="perm-list">
            @foreach ($hakAkses as [$fitur, $boleh])
                <li @class(['yes' => $boleh, 'no' => ! $boleh])>
                    <i class="bi bi-{{ $boleh ? 'check-circle-fill' : 'x-circle' }}"></i>
                    <span>{{ $fitur }}</span>
                </li>
            @endforeach
        </ul>
        @unless ($user->isAdmin())
            <div class="card-foot">Perlu akses lebih? Hubungi Administrator sistem.</div>
        @endunless
    </section>
</section>

{{-- ===== Modul ===== --}}
<div class="section-title">
    <div>
        <span class="kicker">Modul</span>
        <h2>{{ $user->canEditData() ? 'Kelola modul data' : 'Lihat modul data' }}</h2>
        <p>Akses cepat ke setiap modul</p>
    </div>
</div>

<section class="grid grid-4">
    <a href="{{ route('admin.kawasan-hutan.index') }}" class="card tile">
        <span class="ico"><i class="bi bi-tree-fill"></i></span>
        <span><h3>Kawasan Hutan</h3><p>{{ angka($totalKawasan, 0) }} data · {{ angka($jumlahKecamatanKawasan, 0) }} kecamatan</p><span class="more">{{ $user->canEditData() ? 'Kelola' : 'Lihat' }} <i class="bi bi-arrow-right"></i></span></span>
    </a>
    <a href="{{ route('admin.lahan-kritis.index') }}" class="card tile">
        <span class="ico"><i class="bi bi-exclamation-triangle-fill"></i></span>
        <span><h3>Lahan Kritis</h3><p>{{ angka($jumlahKecamatanLahanKritis, 0) }} kecamatan terdata</p><span class="more">{{ $user->canEditData() ? 'Kelola' : 'Lihat' }} <i class="bi bi-arrow-right"></i></span></span>
    </a>
    <a href="{{ route('admin.lingkungan-hidup.index') }}" class="card tile">
        <span class="ico"><i class="bi bi-globe-asia-australia"></i></span>
        <span><h3>Lingkungan Hidup</h3><p>Modul disiapkan, menunggu data</p><span class="more">Lihat <i class="bi bi-arrow-right"></i></span></span>
    </a>
    @if ($user->isAdmin())
        <a href="{{ route('admin.users.index') }}" class="card tile">
            <span class="ico"><i class="bi bi-person-gear"></i></span>
            <span><h3>Pengguna</h3><p>Kelola akun admin, petugas, dan viewer</p><span class="more">Kelola <i class="bi bi-arrow-right"></i></span></span>
        </a>
    @else
        <a href="{{ route('admin.profile') }}" class="card tile">
            <span class="ico"><i class="bi bi-person-circle"></i></span>
            <span><h3>Profil Saya</h3><p>Ubah nama, email, dan password akun Anda</p><span class="more">Buka <i class="bi bi-arrow-right"></i></span></span>
        </a>
    @endif
</section>

@endsection
