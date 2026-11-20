{{--
    Data Bidang (situs publik, hanya-baca): seluruh bidang beserta jumlah data per modul.
    Halaman utama role Viewer setelah login.
--}}
@extends('layouts.public')

@section('title', 'Data Bidang')

@section('content')

<x-page-header eyebrow="Data Bidang" title="Hasil pendataan seluruh bidang"
    description="Data yang diinput oleh Admin dan Petugas Bakorwil III Malang, disajikan per bidang dan sub bidang.">
    <x-slot:breadcrumb>
        <a href="{{ route('dashboard') }}">Beranda</a>
        <i class="bi bi-chevron-right"></i>
        <span aria-current="page">Data Bidang</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <span class="mode-chip"><i class="bi bi-eye"></i> Mode lihat saja</span>
    </x-slot:actions>
</x-page-header>

<section class="grid grid-4">
    <x-stat icon="grid-1x2-fill" label="Bidang" :value="$total['bidang']" unit="bidang tersedia" />
    <x-stat icon="collection-fill" label="Modul Data" :value="$total['modul']" unit="modul di seluruh bidang" tone="sky" />
    <x-stat icon="check2-circle" label="Modul Berisi Data" :value="$total['terisi'].' / '.$total['modul']" unit="modul sudah diinput" tone="amber" />
    <x-stat icon="clock-history" label="Update Terakhir"
            :value="$total['terakhir'] ? $total['terakhir']->translatedFormat('d M Y') : '–'"
            :unit="$total['terakhir'] ? 'pukul '.$total['terakhir']->format('H:i').' WIB' : 'belum ada data'" />
</section>

@foreach ($ringkasan as $r)
    @php($b = $r['bidang'])
    @php($pct = $r['jumlah_modul'] ? round($r['modul_terisi'] / $r['jumlah_modul'] * 100) : 0)
    <section class="card bidang-panel" id="{{ $b['slug'] }}">
        <div class="bidang-panel-head">
            <span class="ico-box" aria-hidden="true"><i class="bi bi-{{ $b['icon'] }}"></i></span>
            <div class="bp-title">
                <h2>{{ $b['nama'] }}</h2>
                <p>{{ $b['tagline'] }}</p>
            </div>
            <div class="bp-meter" title="{{ $r['modul_terisi'] }} dari {{ $r['jumlah_modul'] }} modul berisi data">
                <span><b>{{ $r['modul_terisi'] }}</b>/{{ $r['jumlah_modul'] }} modul berisi data</span>
                <span class="meter"><i style="--w: {{ $pct }}%"></i></span>
            </div>
            <a href="{{ route('data.bidang', $b['slug']) }}" class="btn btn-outline btn-sm">Lihat bidang <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="modul-grid">
            @foreach ($r['modul'] as $m)
                @php($s = $m['statistik'])
                <a href="{{ $m['href_publik'] }}" @class(['modul-chip', 'kosong' => ! $s['jumlah']])>
                    <span class="mc-ico"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i></span>
                    <span class="mc-info">
                        <b>{{ $m['nama'] }}</b>
                        <small>
                            @if ($s['jumlah'])
                                {{ angka($s['jumlah'], 0) }} data · {{ $s['terakhir']?->diffForHumans() ?? '' }}
                            @else
                                Belum ada data
                            @endif
                        </small>
                    </span>
                    <i class="bi bi-chevron-right mc-go" aria-hidden="true"></i>
                </a>
            @endforeach
        </div>
    </section>
@endforeach

@if ($ringkasan->isEmpty())
    <section class="card">
        <x-empty icon="inbox" title="Belum ada bidang yang dapat ditampilkan">Hubungi Administrator untuk informasi akses data.</x-empty>
    </section>
@endif

@endsection
