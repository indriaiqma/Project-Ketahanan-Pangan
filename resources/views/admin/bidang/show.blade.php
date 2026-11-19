@extends('layouts.admin')

@section('title', $bidang['nama'])

@section('content')

<section class="page-head page-head--compact bidang-head">
    <div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <span>Bidang</span>
            <i class="bi bi-chevron-right"></i>
            <span aria-current="page">{{ $bidang['nama'] }}</span>
        </nav>
        <div class="head-row">
            <span class="ico-box" aria-hidden="true"><i class="bi bi-{{ $bidang['icon'] }}"></i></span>
            <div>
                <h1>{{ $bidang['nama'] }}</h1>
                <p>{{ $bidang['tagline'] }}</p>
            </div>
        </div>
    </div>
</section>

<section class="grid grid-3">
    <x-stat icon="diagram-3" label="Jumlah Sub Bidang" :value="$jumlahSub ?: '–'" :unit="$jumlahSub ? 'sub bidang' : 'tanpa sub bidang'" />
    <x-stat icon="check2-circle" label="Modul Aktif" :value="$jumlahAktif.' / '.$jumlahModul" unit="modul siap dipakai" tone="sky" />
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
                    <p>
                        @if ($bisaUbah($k['sub']['slug'] ?? null))
                            Anda dapat menginput data di sub bidang ini
                        @else
                            Hanya dapat dilihat
                        @endif
                    </p>
                </div>
            </div>
            <span class="muted" style="font-size:13px">{{ $k['jumlah_aktif'] }} dari {{ count($k['modul']) }} aktif</span>
        </div>

        @if (empty($k['modul']))
            <x-empty icon="inbox" title="Belum ada modul">Modul untuk sub bidang ini belum ditentukan.</x-empty>
        @else
            <ul class="modul-list">
                @foreach ($k['modul'] as $m)
                    <li>
                        @if ($m['aktif'])
                            <a href="{{ $m['href'] }}" class="modul-row">
                                <span class="st"><i class="bi bi-{{ $m['icon'] ?? 'check2-circle' }}"></i></span>
                                <span class="info">
                                    <b>{{ $m['nama'] }}</b>
                                    <small>{{ $m['ringkasan']['teks'] }}</small>
                                </span>
                                <span class="badge green"><span class="dot"></span>Aktif</span>
                                <i class="bi bi-chevron-right go" aria-hidden="true"></i>
                            </a>
                        @else
                            <div class="modul-row segera">
                                <span class="st"><i class="bi bi-{{ $m['icon'] ?? 'hourglass-split' }}"></i></span>
                                <span class="info">
                                    <b>{{ $m['nama'] }}</b>
                                    <small>{{ $m['ringkasan']['teks'] }}</small>
                                </span>
                                <span class="badge amber"><span class="dot"></span>Segera</span>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endforeach

@endsection
