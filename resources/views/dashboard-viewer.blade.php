@extends('layouts.public')

@section('title', 'Beranda')

@php
    $totalKomposisi = collect($ringkasan)->sum('ha');

    // Kecamatan wilayah Malang Selatan (sama dengan daftar di import lahan kritis)
    $wilayah = ['Ampelgading', 'Bantur', 'Dampit', 'Donomulyo', 'Gedangan', 'Kalipare', 'Pagak', 'Sumbermanjing Wetan', 'Tirtoyudo'];
    $kecamatanTerdata = array_unique(array_merge(array_keys($lahanPerKecamatan), array_keys($kawasanPerKecamatan)));

    $user = auth()->user();
    $jumlahModul = $bidangPublik->sum('jumlah_modul');
    $jumlahDataBidang = $bidangPublik->sum('jumlah_data');
@endphp

{{-- ===================== HERO ===================== --}}
@section('hero')
<section class="landing-hero">
    <div class="hero-bg" aria-hidden="true">
        <span class="blob b1"></span><span class="blob b2"></span><span class="blob b3"></span>
        <span class="hero-grid"></span>
    </div>

    <div class="container hero-inner">
        <div class="hero-copy">
            <span class="hero-chip">
                <span class="pulse"></span>
                @if ($terakhirDiperbarui)
                    Data diperbarui {{ $terakhirDiperbarui }} WIB
                @else
                    Data terbuka untuk publik
                @endif
            </span>

            <h1>Ketahanan Pangan <span class="grad-text">Malang Selatan</span> dalam satu dashboard</h1>
            <p>Pantau data {{ $bidangPublik->count() }} bidang, mulai dari pemerintahan, ekonomi, kemasyarakatan, hingga kehutanan di {{ count($wilayah) }} kecamatan Malang Selatan. Data resmi Bakorwil III Malang, Provinsi Jawa Timur.</p>

            <div class="hero-actions">
                @auth
                    <a href="{{ route('data.index') }}" class="btn btn-light btn-lg"><i class="bi bi-grid-1x2"></i> Lihat Data Bidang</a>
                    <a href="#ringkasan" class="btn btn-glass btn-lg">Ringkasan Kehutanan <i class="bi bi-arrow-down"></i></a>
                @else
                    <a href="#ringkasan" class="btn btn-light btn-lg"><i class="bi bi-bar-chart-line"></i> Lihat Ringkasan</a>
                    <a href="#data-bidang" class="btn btn-glass btn-lg">Data Bidang <i class="bi bi-arrow-right"></i></a>
                @endauth
            </div>

            <div class="hero-trust">
                <div><b data-count-to="{{ $totalKawasan }}">{{ angka($totalKawasan, 0) }}</b><span>kawasan hutan</span></div>
                <div><b data-count-to="{{ count($wilayah) }}">{{ count($wilayah) }}</b><span>kecamatan</span></div>
                <div><b data-count-to="{{ $jumlahModul }}">{{ $jumlahModul }}</b><span>modul data</span></div>
            </div>
        </div>

        <div class="hero-visual" aria-hidden="true">
            <div class="glass-card main float">
                <div class="gc-head">
                    <span class="gc-ico"><i class="bi bi-pie-chart-fill"></i></span>
                    <div>
                        <small>Total luas lahan terdata</small>
                        <b>{{ angka($totalKomposisi) }} <em>Ha</em></b>
                    </div>
                </div>
                <ul class="gc-bars">
                    @foreach ($ringkasan as $row)
                        @php($pct = $totalKomposisi > 0 ? $row['ha'] / $totalKomposisi * 100 : 0)
                        <li>
                            <span>{{ $row['label'] }}</span>
                            <span class="bar"><i style="--w: {{ round($pct, 1) }}%; --c: {{ $row['color'] }}"></i></span>
                            <em>{{ angka($pct, 1) }}%</em>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="glass-card mini m1 float-slow">
                <span class="gc-ico sm"><i class="bi bi-tree-fill"></i></span>
                <div><b>{{ angka($totalLuasKawasan) }} Ha</b><small>luas kawasan hutan</small></div>
            </div>
            <div class="glass-card mini m2 float-slower">
                <span class="gc-ico sm warn"><i class="bi bi-exclamation-triangle-fill"></i></span>
                <div><b>{{ angka($totalSangatKritis) }} Ha</b><small>lahan sangat kritis</small></div>
            </div>
        </div>
    </div>

    <a href="#ringkasan" class="scroll-cue" aria-label="Gulir ke ringkasan"><span></span></a>
</section>
@endsection

{{-- ===================== KONTEN ===================== --}}
@section('content')

<section class="grid grid-4 overlap" id="ringkasan">
    <x-stat icon="tree-fill" label="Kawasan Hutan" :value="angka($totalKawasan, 0)" unit="data kawasan" :href="route('kawasan-hutan.index')" />
    <x-stat icon="map-fill" label="Total Luas Kawasan" :value="angka($totalLuasKawasan)" unit="hektare" :href="route('kawasan-hutan.index')" tone="sky" />
    <x-stat icon="exclamation-triangle-fill" label="Total Lahan Kritis" :value="angka($totalLahanKritis)" unit="hektare" :href="route('lahan-kritis.index')" tone="amber" />
    <x-stat icon="exclamation-octagon-fill" label="Sangat Kritis" :value="angka($totalSangatKritis)" unit="hektare" :href="route('lahan-kritis.index')" tone="red" />
</section>

<div class="section-title">
    <div>
        <span class="kicker">Sekilas Data</span>
        <h2>Kondisi lahan kritis per kecamatan</h2>
        <p>Perbandingan luas lahan menurut tingkat kekritisan, di dalam dan di luar kawasan hutan.</p>
    </div>
</div>

<section class="grid grid-main">
    @include('partials.chart-lahan-kritis', [
        'labels' => array_keys($lahanPerKecamatan),
        'sangat' => array_column($lahanPerKecamatan, 0),
        'kritis' => array_column($lahanPerKecamatan, 1),
        'agak'   => array_column($lahanPerKecamatan, 2),
    ])
    @include('partials.chart-komposisi', ['ringkasan' => $ringkasan])
</section>

<div class="section-title" id="data-bidang">
    <div>
        <span class="kicker">Data Bidang</span>
        <h2>Hasil pendataan {{ $bidangPublik->count() }} bidang</h2>
        <p>{{ angka($jumlahDataBidang, 0) }} data dari {{ $jumlahModul }} modul, diinput langsung oleh Admin dan Petugas setiap bidang.</p>
    </div>
    @auth
        <a href="{{ route('data.index') }}" class="btn btn-outline btn-sm">Semua bidang <i class="bi bi-arrow-right"></i></a>
    @else
        <span class="lock-note"><i class="bi bi-lock"></i> Masuk untuk melihat data lengkap</span>
    @endauth
</div>

<section class="grid grid-3">
    @foreach ($bidangPublik as $r)
        @php($pct = $r['jumlah_modul'] ? round($r['modul_terisi'] / $r['jumlah_modul'] * 100) : 0)
        <a href="{{ route('data.bidang', $r['bidang']['slug']) }}" class="card tile bidang-tile">
            <span class="ico"><i class="bi bi-{{ $r['bidang']['icon'] }}"></i></span>
            <span style="flex:1;min-width:0">
                <h3>{{ $r['bidang']['nama'] }}</h3>
                <p>{{ $r['bidang']['tagline'] }}</p>
                <span class="stats">
                    <span><b>{{ $r['jumlah_modul'] }}</b> modul</span>
                    <span><b>{{ angka($r['jumlah_data'], 0) }}</b> data</span>
                    <span><b>{{ $r['modul_terisi'] }}</b> terisi</span>
                </span>
                <span class="meter" title="{{ $pct }}% modul berisi data"><i style="--w: {{ $pct }}%"></i></span>
                <span class="more">@auth Lihat data @else Masuk untuk melihat @endauth <i class="bi bi-arrow-right"></i></span>
            </span>
        </a>
    @endforeach
</section>

<div class="section-title">
    <div>
        <span class="kicker">Cakupan Wilayah</span>
        <h2>{{ count($wilayah) }} kecamatan di Malang Selatan</h2>
        <p>Titik hijau menandakan kecamatan yang datanya sudah tersedia di sistem.</p>
    </div>
</div>

<section class="card region-card">
    <div class="region-list">
        @foreach ($wilayah as $kec)
            @php($ada = in_array($kec, $kecamatanTerdata))
            <a href="{{ route('lahan-kritis.index', ['kecamatan' => $kec]) }}" @class(['region', 'has-data' => $ada])>
                <span class="dot"></span>
                <span>
                    <b>{{ $kec }}</b>
                    <small>{{ $ada ? 'Data tersedia' : 'Belum ada data' }}</small>
                </span>
                <i class="bi bi-arrow-up-right"></i>
            </a>
        @endforeach
    </div>
</section>

<section class="cta-band">
    <div class="cta-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span></div>
    @if ($user && ! $user->isStaff())
        <div class="cta-copy">
            <h2>Halo, {{ $user->name }}</h2>
            <p>Akun Anda dapat melihat dan mengunduh seluruh data bidang yang diinput oleh Admin dan Petugas.</p>
        </div>
        <a href="{{ route('data.index') }}" class="btn btn-light btn-lg"><i class="bi bi-grid-1x2"></i> Buka Data Bidang</a>
    @elseif ($user)
        <div class="cta-copy">
            <h2>Kelola data bidang Anda</h2>
            <p>Buka panel pengelola untuk menambah, memperbarui, serta mengimpor dan mengekspor data.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg"><i class="bi bi-speedometer2"></i> Buka Panel Pengelola</a>
    @else
        <div class="cta-copy">
            <h2>Akses data lengkap seluruh bidang</h2>
            <p>Viewer dapat melihat hasil pendataan semua bidang. Admin dan Petugas mengelola data melalui panel pengelola.</p>
        </div>
        <a href="{{ route('login') }}" class="btn btn-light btn-lg"><i class="bi bi-box-arrow-in-right"></i> Masuk</a>
    @endif
</section>

@endsection
