@extends('layouts.public')

@section('title', 'Beranda')

@php
    $totalKomposisi = collect($ringkasan)->sum('ha');

    // Kecamatan wilayah Malang Selatan (sama dengan daftar di import lahan kritis)
    $wilayah = ['Ampelgading', 'Bantur', 'Dampit', 'Donomulyo', 'Gedangan', 'Kalipare', 'Pagak', 'Sumbermanjing Wetan', 'Tirtoyudo'];
    $kecamatanTerdata = array_unique(array_merge(array_keys($lahanPerKecamatan), array_keys($kawasanPerKecamatan)));
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
            <p>Pantau kawasan hutan dan kondisi lahan kritis di {{ count($wilayah) }} kecamatan Malang Selatan. Data resmi Bakorwil III Malang, Provinsi Jawa Timur.</p>

            <div class="hero-actions">
                <a href="#ringkasan" class="btn btn-light btn-lg"><i class="bi bi-bar-chart-line"></i> Lihat Ringkasan</a>
                <a href="{{ route('lahan-kritis.index') }}" class="btn btn-glass btn-lg">Data Lahan Kritis <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="hero-trust">
                <div><b data-count-to="{{ $totalKawasan }}">{{ angka($totalKawasan, 0) }}</b><span>kawasan hutan</span></div>
                <div><b data-count-to="{{ count($wilayah) }}">{{ count($wilayah) }}</b><span>kecamatan</span></div>
                <div><b>2</b><span>modul aktif</span></div>
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

<div class="section-title">
    <div>
        <span class="kicker">Modul Data</span>
        <h2>Jelajahi data sesuai kebutuhan</h2>
        <p>Setiap modul menyajikan tabel, grafik, dan detail per lokasi.</p>
    </div>
</div>

<section class="grid grid-4">
    @foreach ([
        ['kawasan-hutan.index', 'tree-fill', 'Kawasan Hutan', 'Lokasi, nama dan jenis kawasan, serta luas area.', true],
        ['lahan-kritis.index', 'exclamation-triangle-fill', 'Lahan Kritis', 'Kondisi lahan per kecamatan berdasarkan tingkat kekritisan.', true],
        ['lingkungan-hidup', 'globe-asia-australia', 'Lingkungan Hidup', 'Data lingkungan hidup wilayah Malang Selatan.', false],
        ['sdm', 'people-fill', 'Sumber Daya Manusia', 'Data SDM pendukung ketahanan pangan.', false],
    ] as [$rute, $ikon, $judul, $teks, $aktif])
        <a href="{{ route($rute) }}" class="card tile">
            <span class="ico"><i class="bi bi-{{ $ikon }}"></i></span>
            <span>
                <h3>{{ $judul }} @unless ($aktif)<span class="badge amber" style="height:20px;margin-left:4px">Segera</span>@endunless</h3>
                <p>{{ $teks }}</p>
                <span class="more">{{ $aktif ? 'Lihat data' : 'Lihat modul' }} <i class="bi bi-arrow-right"></i></span>
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
    <div class="cta-copy">
        <h2>Petugas Bakorwil III Malang?</h2>
        <p>Masuk ke panel pengelola untuk menambah, memperbarui, serta mengimpor dan mengekspor data.</p>
    </div>
    @auth
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg"><i class="bi bi-speedometer2"></i> Buka Panel Pengelola</a>
    @else
        <a href="{{ route('login') }}" class="btn btn-light btn-lg"><i class="bi bi-box-arrow-in-right"></i> Masuk Pengelola</a>
    @endauth
</section>

@endsection
