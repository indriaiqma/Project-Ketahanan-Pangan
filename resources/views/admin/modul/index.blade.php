{{--
    Halaman list modul data generik (definisi di config/modul_data.php).
    Dipakai semua modul data; jangan menulis logika khusus satu modul di sini.
--}}
@extends(($publik ?? false) ? 'layouts.public' : 'layouts.admin')

@section('title', $modul['nama'])

@php
    use App\Support\ModulData;

    $parameter = ['bidang' => $bidang['slug'], 'modul' => $modul['slug']];

    // Tampilan publik (/data/...) memakai route publik & tanpa tombol ubah/hapus
    $publik = $publik ?? false;
    $rute = $publik
        ? ['bidang' => 'data.bidang', 'modul' => 'data.modul', 'export' => 'data.export', 'lampiran' => 'data.lampiran']
        : ['bidang' => 'admin.bidang.show', 'modul' => 'admin.bidang.modul', 'export' => 'admin.modul.export', 'lampiran' => 'admin.modul.lampiran'];
    $bolehHapus = ! $publik && $bisaUbah; // Admin & petugas di sub bidang tugasnya
    // Export & lampiran khusus pengguna login (Admin/Petugas) yang boleh melihat sub bidang ini
    $bisaUnduh = ! $publik || \App\Support\Bidang::bolehLihatSub(auth()->user(), $bidang['slug'], $modul['sub']);
    $adaAksi = $bisaUbah || $bolehHapus;
    $warnaGrafik = ['#18774d', '#2f80c2', '#f5a524', '#e5484d', '#7cb82f'];
    $syaratBaik = ModulData::syaratBaik($def);
@endphp

@section('content')

<x-page-header compact :title="$modul['nama']" :description="$def['deskripsi']">
    <x-slot:breadcrumb>
        @if ($publik)<a href="{{ route('data.index') }}">Data Bidang</a><i class="bi bi-chevron-right"></i>@endif
        <a href="{{ route($rute['bidang'], $bidang['slug']) }}">{{ $bidang['nama'] }}</a>
        @if ($modul['sub_nama'])
            <i class="bi bi-chevron-right"></i>
            <span>{{ $modul['sub_nama'] }}</span>
        @endif
        <i class="bi bi-chevron-right"></i>
        <span aria-current="page">{{ $modul['nama'] }}</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        @if ($bisaUnduh)
            <a href="{{ route($rute['export'], $parameter + ['tahun' => $tahun, 'periode' => $periode]) }}" class="btn btn-outline">
                <i class="bi bi-download"></i> Export Excel
            </a>
        @else
            <span class="mode-chip"><i class="bi bi-globe2"></i> Data publik</span>
        @endif
        @if ($bisaUbah)
            <a href="{{ route('admin.modul.create', $parameter + ['tahun' => $tahun, 'periode' => $periode]) }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Input Data
            </a>
        @endif
    </x-slot:actions>
</x-page-header>

{{-- ===== Filter periode ===== --}}
<form method="GET" action="{{ route($rute['modul'], $parameter) }}" class="card toolbar periode-form" role="search" aria-label="Filter periode">
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
        @foreach (array_keys(ModulData::STATUS) as $nilai)
            @continue($nilai === 'bawah' && ! ModulData::punyaTarget($def))
            <option value="{{ $nilai }}" @selected(request('status') === $nilai)>{{ ModulData::labelStatus($def, $nilai) }}</option>
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
                    :unit="$persen ? ModulData::labelTarget($mt['info']) : ($mt['info']['satuan'] ?? '')"
                    :tone="$persen ? (ModulData::capaiTarget($mt['info'], $mt['nilai']) ? null : 'amber') : ($i === 0 ? null : 'sky')" />
        @endforeach
    </section>
@endif

{{-- ===== Grafik per wilayah ===== --}}
@if (! empty($def['grafik']))
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
@endif

{{-- ===== Tabel data ===== --}}
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-table"></i></span>
            <div>
                <h2>Data per Wilayah</h2>
                <p>{{ $syaratBaik ? 'Status "Baik" bila '.$syaratBaik : 'Status menunjukkan wilayah yang sudah dan belum melapor' }}</p>
            </div>
        </div>
        <div style="display:flex;gap:6px;flex-wrap:wrap">
            <span class="status-pill baik"><span class="dot"></span>{{ ModulData::labelStatus($def, 'baik') }} {{ $hitungStatus['baik'] ?? 0 }}</span>
            @if (ModulData::punyaTarget($def))
                <span class="status-pill bawah"><span class="dot"></span>Di bawah target {{ $hitungStatus['bawah'] ?? 0 }}</span>
            @endif
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
                        @if ($adaAksi)<th class="r">Aksi</th>@endif
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
                                        @if ($d->lampiran && $bisaUnduh)
                                            · <a href="{{ route($rute['lampiran'], $parameter + ['lampiran' => $d->lampiran->id]) }}" title="Unduh {{ $d->lampiran->nama_file }}">
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
                                <span @class(['status-pill', $r['status']])><span class="dot"></span>{{ ModulData::labelStatus($def, $r['status']) }}</span>
                            </td>
                            @if ($adaAksi)
                            <td>
                                <div class="actions">
                                    @if ($d)
                                        @if ($bisaUbah)
                                            <a href="{{ route('admin.modul.edit', $parameter + ['id' => $d->id]) }}" class="btn btn-outline btn-icon" title="Ubah" aria-label="Ubah data {{ $r['wilayah']->nama }}"><i class="bi bi-pencil"></i></a>
                                        @endif
                                        @if ($bolehHapus)
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
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="card-foot">
        <i class="bi bi-info-circle"></i>
        Persentase dihitung otomatis dari angka yang diinput.
        @if ($bisaUnduh)
            <a href="{{ route($rute['export'], $parameter + ['periode' => 'semua']) }}" style="margin-left:6px">Export semua periode</a>
        @endif
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
