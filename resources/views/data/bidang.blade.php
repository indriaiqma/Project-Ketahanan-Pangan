{{-- Data Bidang: ringkasan satu bidang per sub bidang (situs publik, hanya-baca). --}}
@extends('layouts.public')

@section('title', $bidang['nama'])

@section('content')

<x-page-header :title="$bidang['nama']" :description="$bidang['tagline']">
    <x-slot:breadcrumb>
        <a href="{{ route('dashboard') }}">Beranda</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ route('data.index') }}">Data Bidang</a>
        <i class="bi bi-chevron-right"></i>
        <span aria-current="page">{{ $bidang['nama'] }}</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <span class="mode-chip"><i class="bi bi-globe2"></i> Terbuka untuk publik</span>
    </x-slot:actions>
</x-page-header>

{{-- Pindah cepat antar bidang --}}
@if ($semuaBidang->count() > 1)
    <nav class="bidang-tabs" aria-label="Pilih bidang">
        @foreach ($semuaBidang as $sb)
            <a href="{{ route('data.bidang', $sb['slug']) }}" @class(['active' => $sb['slug'] === $bidang['slug']])>
                <i class="bi bi-{{ $sb['icon'] }}"></i> {{ $sb['nama'] }}
            </a>
        @endforeach
    </nav>
@endif

<section class="grid grid-3">
    <x-stat icon="diagram-3" label="Sub Bidang" :value="count($bidang['sub_bidang']) ?: '–'" :unit="count($bidang['sub_bidang']) ? 'sub bidang' : 'tanpa sub bidang'" />
    <x-stat icon="collection" label="Modul Data" :value="$jumlahModul" unit="modul" tone="sky" />
    <x-stat icon="clock-history" label="Update Terakhir"
            :value="$terakhir ? $terakhir->translatedFormat('d M Y') : '–'"
            :unit="$terakhir ? 'pukul '.$terakhir->format('H:i').' WIB' : 'belum ada data diinput'" tone="amber" />
</section>

@foreach ($kelompok as $k)
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-{{ $k['sub'] ? 'diagram-3' : 'grid' }}"></i></span>
                <div>
                    <h2>{{ $k['sub']['nama'] ?? 'Daftar Modul' }}</h2>
                    <p>{{ count($k['modul']) }} modul data</p>
                </div>
            </div>
        </div>

        @if (empty($k['modul']))
            <x-empty icon="inbox" title="Belum ada modul">Modul untuk sub bidang ini belum ditentukan.</x-empty>
        @else
            <ul class="modul-list">
                @foreach ($k['modul'] as $m)
                    @php($ada = $m['ringkasan']['teks'] !== 'Belum ada data')
                    <li>
                        <a href="{{ $m['href_publik'] }}" class="modul-row">
                            <span class="st"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i></span>
                            <span class="info">
                                <b>{{ $m['nama'] }}</b>
                                <small>
                                    {{ $m['ringkasan']['teks'] }}
                                    @if ($m['ringkasan']['terakhir'])
                                        · diperbarui {{ $m['ringkasan']['terakhir']->diffForHumans() }}
                                    @endif
                                </small>
                            </span>
                            @if ($ada)
                                <span class="badge green"><span class="dot"></span>Ada data</span>
                            @else
                                <span class="badge amber"><span class="dot"></span>Belum diinput</span>
                            @endif
                            <i class="bi bi-chevron-right go" aria-hidden="true"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endforeach

@endsection
