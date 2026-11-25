{{--
    Landing page: portal hasil input Admin & Petugas di seluruh bidang.
    Data dari App\Support\RingkasanBidang::landing(). Terbuka untuk semua pengunjung
    tanpa login; login hanya untuk Admin & Petugas yang mengelola data.
--}}
@extends('layouts.public')

@section('title', 'Beranda')

@php
    $user = auth()->user();
    $warnaBidang = ['#4ade80', '#38bdf8', '#facc15', '#a78bfa', '#fb923c', '#f472b6'];
    $kecamatanTerdata = $wilayah->where('jumlah', '>', 0)->count();
    $maksWilayah = max(1, $wilayah->max('jumlah'));
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
                @if ($total['terakhir'])
                    Data diperbarui {{ $total['terakhir']->translatedFormat('d F Y, H:i') }} WIB
                @else
                    Portal data Bakorwil III Malang
                @endif
            </span>

            <h1>Portal Data Pembangunan <span class="grad-text">Malang Selatan</span></h1>
            <p>Hasil pendataan {{ $total['bidang'] }} bidang Bakorwil III Malang, mulai dari pemerintahan, ekonomi, dan kemasyarakatan hingga sarana prasarana. Data diinput langsung oleh petugas setiap bidang dan terbuka untuk umum.</p>

            <div class="hero-actions">
                <a href="{{ route('data.index') }}" class="btn btn-light btn-lg"><i class="bi bi-grid-1x2"></i> Lihat Data Bidang</a>
                <a href="#sorotan" class="btn btn-glass btn-lg">Sorotan Data <i class="bi bi-arrow-down"></i></a>
            </div>

            <div class="hero-trust">
                <div><b data-count-to="{{ $total['bidang'] }}">{{ $total['bidang'] }}</b><span>bidang</span></div>
                <div><b data-count-to="{{ $total['modul'] }}">{{ $total['modul'] }}</b><span>modul data</span></div>
                <div><b data-count-to="{{ $total['data'] }}">{{ angka($total['data'], 0) }}</b><span>data diinput</span></div>
                <div><b data-count-to="{{ $wilayah->count() }}">{{ $wilayah->count() }}</b><span>kecamatan</span></div>
            </div>
        </div>

        <div class="hero-visual" aria-hidden="true">
            <div class="glass-card main float">
                <div class="gc-head">
                    <span class="gc-ico"><i class="bi bi-clipboard-data-fill"></i></span>
                    <div>
                        <small>Kelengkapan data per bidang</small>
                        <b>{{ $total['terisi'] }}<em> / {{ $total['modul'] }} modul terisi</em></b>
                    </div>
                </div>
                <ul class="gc-bars wide">
                    @foreach ($bidang as $i => $r)
                        @php($pct = $r['jumlah_modul'] ? $r['modul_terisi'] / $r['jumlah_modul'] * 100 : 0)
                        <li>
                            <span>{{ \Illuminate\Support\Str::after($r['bidang']['nama'], 'Bidang ') }}</span>
                            <span class="bar"><i style="--w: {{ round($pct, 1) }}%; --c: {{ $warnaBidang[$i % count($warnaBidang)] }}"></i></span>
                            <em>{{ round($pct) }}%</em>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="glass-card mini m1 float-slow">
                <span class="gc-ico sm"><i class="bi bi-database-fill-check"></i></span>
                <div><b>{{ angka($total['data'], 0) }} data</b><small>dari seluruh bidang</small></div>
            </div>
            <div class="glass-card mini m2 float-slower">
                <span class="gc-ico sm warn"><i class="bi bi-geo-alt-fill"></i></span>
                <div><b>{{ $kecamatanTerdata }} / {{ $wilayah->count() }} kecamatan</b><small>sudah melapor data</small></div>
            </div>
        </div>
    </div>

    <a href="#ringkasan" class="scroll-cue" aria-label="Gulir ke ringkasan"><span></span></a>
</section>
@endsection

{{-- ===================== KONTEN ===================== --}}
@section('content')

<section class="grid grid-4 overlap" id="ringkasan">
    <x-stat icon="grid-1x2-fill" label="Bidang" :value="$total['bidang']" unit="bidang pembangunan" />
    <x-stat icon="collection-fill" label="Modul Berisi Data" :value="$total['terisi'].' / '.$total['modul']" unit="modul sudah diinput" tone="sky" />
    <x-stat icon="database-fill" label="Total Data" :value="angka($total['data'], 0)" unit="baris data diinput" tone="amber" />
    <x-stat icon="geo-alt-fill" label="Kecamatan Melapor" :value="$kecamatanTerdata.' / '.$wilayah->count()" unit="kecamatan Malang Selatan" />
</section>

{{-- ===== Sorotan indikator ===== --}}
<div class="section-title" id="sorotan">
    <div>
        <span class="kicker">Sorotan Data</span>
        <h2>Indikator terbaru dari setiap bidang</h2>
        <p>Angka periode terakhir dari modul yang baru diperbarui, dijumlahkan dari seluruh kecamatan.</p>
    </div>
    <a href="{{ route('data.index') }}" class="btn btn-outline btn-sm">Semua data <i class="bi bi-arrow-right"></i></a>
</div>

@if ($sorotan->isEmpty())
    <section class="card">
        <x-empty icon="clipboard-data" title="Belum ada data yang diinput">Sorotan indikator akan tampil setelah petugas menginput data.</x-empty>
    </section>
@else
    <section class="grid grid-4 sorotan-grid">
        @foreach ($sorotan as $s)
            <a href="{{ $s['href'] }}" class="card sorotan">
                <div class="so-head">
                    <span class="so-ico"><i class="bi bi-{{ $s['icon'] }}"></i></span>
                    <span class="so-modul"><b>{{ $s['nama'] }}</b><small>{{ $s['sub_nama'] }}</small></span>
                </div>
                <div class="so-label">
                    <span>{{ $s['label'] }}</span>
                    @if ($s['status'])
                        <span @class(['badge', 'green' => $s['status']['baik'], 'amber' => ! $s['status']['baik']]) title="{{ $s['status']['target'] }}">
                            <span class="dot"></span>{{ $s['status']['baik'] ? 'Capai target' : 'Di bawah target' }}
                        </span>
                    @endif
                </div>
                <div class="so-nilai">
                    {{ $s['nilai'] }}<small>{{ $s['satuan'] }}</small>
                </div>
                <div class="so-foot">
                    <span><i class="bi bi-calendar3"></i> {{ $s['periode'] }}</span>
                </div>
            </a>
        @endforeach
    </section>
@endif

{{-- ===== Bidang ===== --}}
<div class="section-title" id="data-bidang">
    <div>
        <span class="kicker">Data Bidang</span>
        <h2>Hasil pendataan {{ $total['bidang'] }} bidang</h2>
        <p>{{ angka($total['data'], 0) }} data dari {{ $total['modul'] }} modul, diinput langsung oleh Admin dan Petugas setiap bidang.</p>
    </div>
    <a href="{{ route('data.index') }}" class="btn btn-outline btn-sm">Semua bidang <i class="bi bi-arrow-right"></i></a>
</div>

<section class="grid grid-3">
    @foreach ($bidang as $r)
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
                <span class="more">Lihat data <i class="bi bi-arrow-right"></i></span>
            </span>
        </a>
    @endforeach
</section>

{{-- ===== Menu khusus (di luar struktur bidang) ===== --}}
@foreach ($khusus as $k)
    <div class="section-title" id="{{ $k['bidang']['slug'] }}">
        <div>
            <span class="kicker">Menu Khusus</span>
            <h2>{{ $k['bidang']['nama'] }}</h2>
            <p>{{ $k['bidang']['tagline'] }}. {{ angka($k['jumlah_data'], 0) }} data dari {{ $k['jumlah_modul'] }} modul.</p>
        </div>
        <a href="{{ route('data.bidang', $k['bidang']['slug']) }}" class="btn btn-outline btn-sm">Ringkasan <i class="bi bi-arrow-right"></i></a>
    </div>

    <section class="grid grid-2">
        @foreach ($k['modul'] as $m)
            @php($st = $m['statistik'])
            <a href="{{ $m['href_publik'] }}" class="card tile bidang-tile">
                <span class="ico"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i></span>
                <span style="flex:1;min-width:0">
                    <h3>{{ $m['nama'] }}</h3>
                    <p>{{ \App\Support\ModulData::def($m['data'])['deskripsi'] }}</p>
                    <span class="stats">
                        <span><b>{{ angka($st['jumlah'], 0) }}</b> data</span>
                        @if (! empty($m['rincian']))<span><i class="bi bi-list-ul"></i> {{ $m['rincian']['nama'] }}</span>@endif
                        @if ($st['terakhir'])<span>diperbarui {{ $st['terakhir']->diffForHumans() }}</span>@endif
                    </span>
                    <span class="more">Lihat data <i class="bi bi-arrow-right"></i></span>
                </span>
            </a>
        @endforeach
    </section>
@endforeach

{{-- ===== Pembaruan & cakupan wilayah ===== --}}
<section class="grid grid-main">
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-activity"></i></span>
                <div><h2>Pembaruan Terbaru</h2><p>Data yang terakhir diinput petugas</p></div>
            </div>
        </div>
        @if ($pembaruan->isEmpty())
            <x-empty icon="clock-history" title="Belum ada pembaruan">Aktivitas input data akan tampil di sini.</x-empty>
        @else
            <ul class="timeline">
                @foreach ($pembaruan as $p)
                    <li>
                        <span class="tl-ico"><i class="bi bi-{{ $p['icon'] }}"></i></span>
                        <a href="{{ $p['href'] }}" class="tl-info">
                            <b>{{ $p['nama'] }}</b>
                            <small>{{ $p['bidang_nama'] }} · {{ $p['keterangan'] }}</small>
                        </a>
                        <time datetime="{{ $p['waktu']->toIso8601String() }}" title="{{ $p['waktu']->translatedFormat('d F Y, H:i') }} WIB">{{ $p['waktu']->diffForHumans() }}</time>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-geo-alt"></i></span>
                <div><h2>Cakupan Wilayah</h2><p>Jumlah data per kecamatan</p></div>
            </div>
            <span class="muted" style="font-size:13px">{{ $kecamatanTerdata }}/{{ $wilayah->count() }} melapor</span>
        </div>
        <ul class="wilayah-list">
            @foreach ($wilayah->sortByDesc('jumlah') as $w)
                <li @class(['kosong' => ! $w['jumlah']])>
                    <span class="wl-nama"><span class="dot"></span>{{ $w['nama'] }}</span>
                    <span class="meter"><i style="--w: {{ round($w['jumlah'] / $maksWilayah * 100) }}%"></i></span>
                    <b>{{ angka($w['jumlah'], 0) }}</b>
                </li>
            @endforeach
        </ul>
    </section>
</section>

<section class="cta-band">
    <div class="cta-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span></div>
    @if ($user)
        <div class="cta-copy">
            <h2>Kelola data bidang Anda</h2>
            <p>Buka panel pengelola untuk menambah, memperbarui, serta mengimpor dan mengekspor data.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-lg"><i class="bi bi-speedometer2"></i> Buka Panel Pengelola</a>
    @else
        <div class="cta-copy">
            <h2>Jelajahi data seluruh bidang</h2>
            <p>Tabel, grafik, dan capaian target setiap modul dapat dilihat langsung tanpa perlu login.</p>
        </div>
        <a href="{{ route('data.index') }}" class="btn btn-light btn-lg"><i class="bi bi-grid-1x2"></i> Buka Data Bidang</a>
    @endif
</section>

@endsection
