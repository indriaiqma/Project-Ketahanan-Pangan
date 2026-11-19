{{--
    Halaman list modul data generik (definisi di config/modul_data.php).
    Dipakai semua modul data; jangan menulis logika khusus satu modul di sini.
--}}
@extends('layouts.admin')

@section('title', $modul['nama'])

@php
    use App\Support\ModulData;

    $parameter = ['bidang' => $bidang['slug'], 'modul' => $modul['slug']];
    $warnaGrafik = ['#18774d', '#2f80c2', '#f5a524', '#e5484d', '#7cb82f'];
    $syaratBaik = collect($def['persentase'])->filter(fn ($p) => isset($p['target']))
        ->map(fn ($p) => $p['label'].' ≥ '.$p['target'].'%')->implode(' dan ');
@endphp

@section('content')

<x-page-header compact :title="$modul['nama']" :description="$def['deskripsi']">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.bidang.show', $bidang['slug']) }}">{{ $bidang['nama'] }}</a>
        @if ($modul['sub_nama'])
            <i class="bi bi-chevron-right"></i>
            <span>{{ $modul['sub_nama'] }}</span>
        @endif
        <i class="bi bi-chevron-right"></i>
        <span aria-current="page">{{ $modul['nama'] }}</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <a href="{{ route('admin.modul.export', $parameter + ['tahun' => $tahun, 'periode' => $periode]) }}" class="btn btn-outline">
            <i class="bi bi-download"></i> Export Excel
        </a>
        @if ($bisaUbah)
            <a href="{{ route('admin.modul.create', $parameter + ['tahun' => $tahun, 'periode' => $periode]) }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Input Data
            </a>
        @endif
    </x-slot:actions>
</x-page-header>

{{-- ===== Filter periode ===== --}}
<form method="GET" action="{{ route('admin.bidang.modul', $parameter) }}" class="card toolbar periode-form" role="search" aria-label="Filter periode">
    <label class="sr-only" for="f-tahun">Tahun</label>
    <select id="f-tahun" name="tahun" class="select">
        @foreach ($daftarTahun as $t)
            <option value="{{ $t }}" @selected($t === $tahun)>{{ $t }}</option>
        @endforeach
    </select>
    <label class="sr-only" for="f-periode">Periode</label>
    <select id="f-periode" name="periode" class="select">
        @foreach (ModulData::opsiPeriode($def) as $nilai => $label)
            <option value="{{ $nilai }}" @selected($nilai === $periode)>{{ $label }}</option>
        @endforeach
    </select>
    <label class="sr-only" for="f-status">Status</label>
    <select id="f-status" name="status" class="select">
        <option value="">Semua status</option>
        @foreach (ModulData::STATUS as $nilai => $label)
            <option value="{{ $nilai }}" @selected(request('status') === $nilai)>{{ $label }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Terapkan</button>
    <span class="muted" style="margin-left:auto;font-size:13px">
        <b style="color:var(--ink-900)">{{ $labelPeriode }}</b> ·
        {{ $jumlahWilayah - ($hitungStatus['belum'] ?? 0) }} dari {{ $jumlahWilayah }} wilayah melapor
    </span>
</form>

{{-- ===== Kartu metrik ===== --}}
@if (count($metrik))
    <section @class(['grid', 'grid-4' => count($metrik) >= 4, 'grid-3' => count($metrik) === 3, 'grid-2' => count($metrik) <= 2])>
        @foreach ($metrik as $i => $mt)
            @php($persen = $mt['info']['jenis'] === 'persen')
            <x-stat :icon="$persen ? 'percent' : ($i === 0 ? 'people-fill' : 'bar-chart-fill')"
                    :label="$mt['info']['label']"
                    :value="ModulData::format($def, $mt['kunci'], $mt['nilai'])"
                    :unit="$persen ? 'target '.($mt['info']['target'] ?? '–').'%' : ($mt['info']['satuan'] ?? '')"
                    :tone="$persen ? (($mt['nilai'] ?? 0) >= ($mt['info']['target'] ?? 0) ? null : 'amber') : ($i === 0 ? null : 'sky')" />
        @endforeach
    </section>
@endif

{{-- ===== Grafik per wilayah ===== --}}
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-bar-chart-fill"></i></span>
            <div><h2>Per Wilayah</h2><p>{{ $labelPeriode }}</p></div>
        </div>
        <div class="legend">
            @foreach ($grafik['datasets'] as $i => $ds)
                <span style="--c: {{ $warnaGrafik[$i % count($warnaGrafik)] }}">{{ $ds['label'] }}</span>
            @endforeach
        </div>
    </div>
    <div class="card-body">
        @if ($grafik['ada'])
            <div class="chart-box"><canvas id="grafik-modul" role="img" aria-label="Grafik {{ $modul['nama'] }} per wilayah"></canvas></div>
        @else
            <x-empty icon="bar-chart" title="Belum ada data pada periode ini">
                Pilih periode lain{{ $bisaUbah ? ', atau input data untuk periode ini' : '' }}.
            </x-empty>
        @endif
    </div>
</section>

{{-- ===== Tabel data ===== --}}
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-table"></i></span>
            <div>
                <h2>Data per Wilayah</h2>
                <p>Status "Baik" bila {{ $syaratBaik ?: 'data sudah dilaporkan' }}</p>
            </div>
        </div>
        <div style="display:flex;gap:6px;flex-wrap:wrap">
            <span class="status-pill baik"><span class="dot"></span>Baik {{ $hitungStatus['baik'] ?? 0 }}</span>
            <span class="status-pill bawah"><span class="dot"></span>Di bawah target {{ $hitungStatus['bawah'] ?? 0 }}</span>
            <span class="status-pill belum"><span class="dot"></span>Belum lapor {{ $hitungStatus['belum'] ?? 0 }}</span>
        </div>
    </div>

    @if ($baris->isEmpty())
        <x-empty icon="funnel" title="Tidak ada wilayah dengan status ini">Ubah filter status untuk melihat wilayah lain.</x-empty>
    @else
        <div class="table-wrap">
            <table class="table compact wrap-head">
                <thead>
                    <tr>
                        <th class="no">No</th>
                        <th>Wilayah</th>
                        @foreach ($def['tabel'] as $k)
                            <th class="r">{{ ModulData::info($def, $k)['label'] }}</th>
                        @endforeach
                        <th>Status</th>
                        <th class="r">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($baris as $r)
                        @php($d = $r['data'])
                        <tr>
                            <td class="no">{{ $loop->iteration }}</td>
                            <td class="nowrap">
                                <span class="strong">{{ $r['wilayah']->nama }}</span>
                                @if ($d)
                                    <span class="sub-info">
                                        {{ \Illuminate\Support\Str::limit($d->sumber_data ?: 'Sumber belum diisi', 34) }}
                                        @if ($d->lampiran)
                                            · <a href="{{ route('admin.modul.lampiran', $parameter + ['lampiran' => $d->lampiran->id]) }}" title="Unduh {{ $d->lampiran->nama_file }}">
                                                <i class="bi bi-paperclip"></i> Lampiran
                                            </a>
                                        @endif
                                    </span>
                                @endif
                            </td>
                            @foreach ($def['tabel'] as $k)
                                <td class="r">{{ $d ? ModulData::format($def, $k, ModulData::nilai($def, $d, $k)) : '–' }}</td>
                            @endforeach
                            <td>
                                <span @class(['status-pill', $r['status']])><span class="dot"></span>{{ ModulData::STATUS[$r['status']] }}</span>
                            </td>
                            <td>
                                <div class="actions">
                                    @if ($d)
                                        @if ($bisaUbah)
                                            <a href="{{ route('admin.modul.edit', $parameter + ['id' => $d->id]) }}" class="btn btn-outline btn-icon" title="Ubah" aria-label="Ubah data {{ $r['wilayah']->nama }}"><i class="bi bi-pencil"></i></a>
                                        @endif
                                        @if (auth()->user()->isAdmin())
                                            <form action="{{ route('admin.modul.destroy', $parameter + ['id' => $d->id]) }}" method="POST"
                                                  data-confirm="Hapus data {{ $modul['nama'] }} {{ $r['wilayah']->nama }} ({{ $labelPeriode }})? Tindakan ini tidak dapat dibatalkan.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-icon danger" title="Hapus" aria-label="Hapus data {{ $r['wilayah']->nama }}"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    @elseif ($bisaUbah)
                                        <a href="{{ route('admin.modul.create', $parameter + ['wilayah_id' => $r['wilayah']->id, 'tahun' => $tahun, 'periode' => $periode]) }}" class="btn btn-outline btn-sm">
                                            <i class="bi bi-plus-lg"></i> Input
                                        </a>
                                    @else
                                        <span class="muted" style="font-size:12.5px">–</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="card-foot">
        <i class="bi bi-info-circle"></i>
        Persentase dihitung otomatis dari angka yang diinput.
        <a href="{{ route('admin.modul.export', $parameter + ['periode' => 'semua']) }}" style="margin-left:6px">Export semua periode</a>
    </div>
</section>

@endsection

@if ($grafik['ada'])
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const warna = @json($warnaGrafik);
            const grafik = @json($grafik);
            SIKP.barChart(document.getElementById('grafik-modul'), {
                labels: grafik.labels,
                stacked: true,
                unit: @json(ModulData::info($def, $def['grafik'][0] ?? '')['satuan'] ?? ''),
                datasets: grafik.datasets.map((d, i) => ({ ...d, backgroundColor: warna[i % warna.length] })),
            });
        });
    </script>
    @endpush
@endif
