{{--
    Data Bidang (situs publik, hanya-baca, tanpa login): seluruh bidang beserta jumlah data per modul.
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
        <span class="mode-chip"><i class="bi bi-globe2"></i> Terbuka untuk publik</span>
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
    @include('data._panel')
@endforeach

@if ($khusus->isNotEmpty())
    <div class="section-title" id="menu-khusus">
        <div>
            <span class="kicker">Menu Khusus</span>
            <h2>{{ $khusus->pluck('bidang.nama')->implode(', ') }}</h2>
            <p>Data sektoral yang dikelola tersendiri, di luar struktur bidang.</p>
        </div>
    </div>
    @foreach ($khusus as $r)
        @include('data._panel')
    @endforeach
@endif

@if ($ringkasan->isEmpty())
    <section class="card">
        <x-empty icon="inbox" title="Belum ada bidang yang dapat ditampilkan">Hubungi Administrator untuk informasi akses data.</x-empty>
    </section>
@endif

@endsection
