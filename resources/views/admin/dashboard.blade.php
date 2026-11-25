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

    // Daftar sub bidang tugas petugas, mis. "Sub Bidang Pemerintahan I, Sub Bidang Sarpras II"
    $namaTugas = collect($tugas)->map(fn ($k) => $k['sub']['nama'] ?? $k['bidang']['nama'])->implode(', ');
    $modulTugas = collect($tugas)->flatMap(fn ($k) => $k['modul']);

    // Ringkasan peran untuk banner
    $peran = [
        'admin'   => ['shield-fill-check', 'Anda memiliki akses penuh: mengelola data, menghapus data, dan mengatur akun pengguna.'],
        'petugas' => ['person-badge-fill', $namaTugas
            ? 'Anda bertugas menginput dan memperbarui data di '.$namaTugas.'.'
            : 'Akun Anda belum ditugaskan ke sub bidang mana pun. Hubungi Administrator.'],
    ][$user->role] ?? ['person-fill', 'Selamat datang di panel pengelola.'];

    // Matriks hak akses (ditampilkan sesuai role yang sedang login)
    $hakAkses = $user->isPetugas()
        ? [
            ['Melihat data sub bidang tugas', true],
            ['Tambah, ubah & hapus data sub bidang tugas', true],
            ['Import & export data Excel', true],
            ['Melihat sub bidang lain', ! $dibatasi],
            ['Kelola akun pengguna', false],
        ]
        : [
            ['Melihat dashboard & seluruh data', true],
            ['Export data ke Excel', true],
            ['Tambah & ubah data', $user->isAdmin()],
            ['Import data dari Excel', $user->isAdmin()],
            ['Hapus data', $user->isAdmin()],
            ['Kelola akun pengguna', $user->isAdmin()],
        ];

    // Tombol cepat petugas: input data ke modul tugasnya (maks. 2)
    $inputCepat = $modulTugas->filter(fn ($m) => $m['input'])->take(2);
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
            @if ($dibatasi)
                <span><i class="bi bi-grid-3x3-gap"></i> {{ $modulTugas->count() }} modul ditugaskan</span>
            @else
                <span><i class="bi bi-clock-history"></i> {{ $terakhirDiperbarui ? 'Data diperbarui ' . $terakhirDiperbarui . ' WIB' : 'Belum ada data' }}</span>
            @endif
        </div>
    </div>

    <div class="welcome-actions">
        @if ($dibatasi)
            @foreach ($inputCepat as $m)
                <a href="{{ $m['input'] }}" class="quick">
                    <i class="bi bi-{{ $m['icon'] ?? 'plus-lg' }}"></i><span><b>Input {{ $m['nama'] }}</b><small>{{ $m['sub_nama'] ?? $m['bidang_nama'] }}</small></span>
                </a>
            @endforeach
        @elseif ($user->isAdmin())
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
                <i class="bi bi-person-plus"></i><span><b>Tambah Pengguna</b><small>Administrator & petugas</small></span>
            </a>
        @else
            <a href="{{ route('admin.profile') }}" class="quick">
                <i class="bi bi-person-circle"></i><span><b>Profil Saya</b><small>Ubah nama, email, password</small></span>
            </a>
        @endif
    </div>
</section>

@if ($dibatasi)
    {{-- ===================== DASHBOARD PETUGAS ===================== --}}
    <section class="grid grid-main">
        <div class="stack">
            @forelse ($tugas as $k)
                <section class="card">
                    <div class="card-head">
                        <div class="card-title">
                            <span class="ico"><i class="bi bi-{{ $k['bidang']['icon'] }}"></i></span>
                            <div>
                                <h2>{{ $k['sub']['nama'] ?? $k['bidang']['nama'] }}</h2>
                                <p>{{ $k['bidang']['nama'] }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.bidang.show', $k['bidang']['slug']) }}" class="btn btn-outline btn-sm">Ringkasan <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <ul class="modul-list">
                        @foreach ($k['modul'] as $m)
                            <li>
                                <div class="modul-row">
                                    <span class="st"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i></span>
                                    <a href="{{ $m['href'] }}" class="info" style="color:inherit">
                                        <b>{{ $m['nama'] }}</b>
                                        <small>{{ $m['ringkasan']['teks'] }}</small>
                                    </a>
                                    @if ($m['input'])
                                        <a href="{{ $m['input'] }}" class="btn btn-outline btn-sm"><i class="bi bi-plus-lg"></i> Input</a>
                                    @endif
                                    <a href="{{ $m['href'] }}" class="btn btn-ghost btn-icon" aria-label="Buka {{ $m['nama'] }}"><i class="bi bi-chevron-right"></i></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @empty
                <section class="card">
                    <x-empty icon="person-exclamation" title="Belum ada penugasan">
                        Akun Anda belum ditugaskan ke sub bidang mana pun, sehingga belum ada modul yang dapat dikelola. Hubungi Administrator untuk mengatur penugasan.
                    </x-empty>
                </section>
            @endforelse
        </div>

        @include('admin._hak-akses')
    </section>

    @if ($lihatKehutanan)
        <div class="section-title">
            <div>
                <span class="kicker">Sub Bidang Sarpras II</span>
                <h2>Ringkasan data kehutanan</h2>
                <p>Kawasan hutan dan lahan kritis Malang Selatan</p>
            </div>
        </div>
        <section class="grid grid-4">
            <x-stat icon="tree-fill" label="Kawasan Hutan" :value="angka($totalKawasan, 0)" unit="data kawasan" :href="route('admin.kawasan-hutan.index')" />
            <x-stat icon="map-fill" label="Total Luas Kawasan" :value="angka($totalLuasKawasan)" unit="hektare" tone="sky" :href="route('admin.kawasan-hutan.index')" />
            <x-stat icon="exclamation-triangle-fill" label="Total Lahan Kritis" :value="angka($totalLahanKritis)" unit="hektare" tone="amber" :href="route('admin.lahan-kritis.index')" />
            <x-stat icon="geo-alt-fill" label="Kecamatan Terdata" :value="angka($jumlahKecamatanLahanKritis, 0)" unit="kecamatan" :href="route('admin.lahan-kritis.index')" />
        </section>
    @endif
@else
    {{-- ===================== DASHBOARD ADMIN ===================== --}}

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
        @include('admin._hak-akses')
    </section>

    {{-- ===== Bidang ===== --}}
    <div class="section-title">
        <div>
            <span class="kicker">Bidang</span>
            <h2>{{ $user->isAdmin() ? 'Kelola data per bidang' : 'Lihat data per bidang' }}</h2>
            <p>Akses cepat ke ringkasan setiap bidang</p>
        </div>
    </div>

    <section class="grid grid-3">
        @foreach (\App\Support\Bidang::untuk($user) as $b)
            <a href="{{ route('admin.bidang.show', $b['slug']) }}" class="card tile">
                <span class="ico"><i class="bi bi-{{ $b['icon'] }}"></i></span>
                <span>
                    <h3>{{ $b['nama'] }}</h3>
                    <p>{{ $b['tagline'] }} · {{ \App\Support\Bidang::modulBidang($b)->count() }} modul</p>
                    <span class="more">Buka <i class="bi bi-arrow-right"></i></span>
                </span>
            </a>
        @endforeach
        @if ($user->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="card tile">
                <span class="ico"><i class="bi bi-person-gear"></i></span>
                <span><h3>Pengguna</h3><p>Kelola akun administrator, petugas, dan penugasan bidang</p><span class="more">Kelola <i class="bi bi-arrow-right"></i></span></span>
            </a>
        @endif
    </section>
@endif

@endsection
