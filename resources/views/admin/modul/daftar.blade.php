{{--
    Halaman list modul data jenis "daftar" (definisi di config/modul_data.php).
    Dipakai semua modul daftar; jangan menulis logika khusus satu modul di sini.
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
    $fFilter = $def['filter'] ? $def['fields'][$def['filter']] : null;
    $difilter = request()->filled('cari') || request()->filled('filter');
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
            <a href="{{ route($rute['export'], $parameter) }}" class="btn btn-outline"><i class="bi bi-download"></i> Export Excel</a>
        @else
            <span class="mode-chip"><i class="bi bi-globe2"></i> Data publik</span>
        @endif
        @if ($bisaUbah)
            <a href="{{ route('admin.modul.create', $parameter) }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Data</a>
        @endif
    </x-slot:actions>
</x-page-header>

{{-- ===== Kartu metrik ===== --}}
@if (count($metrik))
    <section @class(['grid', 'grid-4' => count($metrik) >= 4, 'grid-3' => count($metrik) === 3, 'grid-2' => count($metrik) <= 2])>
        @foreach ($metrik as $i => $mt)
            <x-stat :icon="$mt['icon'] ?? 'collection'" :label="$mt['label']"
                    :value="$mt['hasil'] === null ? '–' : angka($mt['hasil'], ($mt['agregat'] ?? '') === 'avg' ? 1 : (fmod($mt['hasil'], 1) !== 0.0 ? 2 : 0))"
                    :unit="$mt['satuan'] ?? 'data'" :tone="[null, 'sky', 'amber', null][$i % 4]" />
        @endforeach
    </section>
@endif

{{-- ===== Grafik per kategori ===== --}}
@if ($grafik['ada'])
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-bar-chart-fill"></i></span>
                <div><h2>{{ $grafik['judul'] }}</h2><p>Seluruh data {{ mb_strtolower($modul['nama']) }}</p></div>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-box sm"><canvas id="grafik-daftar" role="img" aria-label="{{ $grafik['judul'] }}"></canvas></div>
        </div>
    </section>
@endif

{{-- ===== Tabel ===== --}}
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-table"></i></span>
            <div>
                <h2>Daftar {{ $modul['nama'] }}</h2>
                <p>{{ $difilter ? 'Hasil filter: '.angka($entri->count(), 0).' dari '.angka($jumlahSemua, 0) : angka($jumlahSemua, 0) }} data</p>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route($rute['modul'], $parameter) }}" class="toolbar" role="search">
        @if (count($def['cari']))
            <div class="input-group grow">
                <i class="bi bi-search lead"></i>
                <input type="search" name="cari" value="{{ request('cari') }}" class="input" placeholder="Cari {{ collect($def['cari'])->map(fn ($f) => mb_strtolower($def['fields'][$f]['label']))->implode(', ') }}…" aria-label="Cari data">
            </div>
        @endif
        @if ($fFilter)
            <select name="filter" class="select" aria-label="Filter {{ mb_strtolower($fFilter['label']) }}">
                <option value="">Semua {{ mb_strtolower($fFilter['label']) }}</option>
                @foreach ($fFilter['opsi'] as $opsi)
                    <option value="{{ $opsi }}" @selected(request('filter') === $opsi)>{{ $opsi }}</option>
                @endforeach
            </select>
        @endif
        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Terapkan</button>
        @if ($difilter)
            <a href="{{ route($rute['modul'], $parameter) }}" class="btn btn-ghost"><i class="bi bi-x-lg"></i> Reset</a>
        @endif
    </form>

    @if ($entri->isEmpty())
        <x-empty :icon="$modul['icon'] ?? 'inbox'" :title="$difilter ? 'Tidak ada data yang cocok' : 'Belum ada data'">
            @if ($difilter)
                Ubah kata kunci atau filter.
            @elseif ($bisaUbah)
                Mulai dengan menambahkan data pertama.
            @else
                Data akan tampil setelah diinput oleh petugas.
            @endif
            @if ($bisaUbah && ! $difilter)
                <x-slot:action>
                    <a href="{{ route('admin.modul.create', $parameter) }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Data</a>
                </x-slot:action>
            @endif
        </x-empty>
    @else
        <div class="table-wrap">
            <table class="table compact wrap-head">
                <thead>
                    <tr>
                        <th class="no">No</th>
                        @foreach ($def['tabel'] as $k)
                            @php($tipe = $def['fields'][$k]['tipe'] ?? 'teks')
                            <th @class(['r' => in_array($tipe, ['angka', 'desimal', 'persen', 'tahun'])])>{{ $def['fields'][$k]['label'] }}</th>
                        @endforeach
                        @if ($adaAksi)<th class="r">Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entri as $e)
                        <tr>
                            <td class="no">{{ $loop->iteration }}</td>
                            @foreach ($def['tabel'] as $k)
                                @php($tipe = $def['fields'][$k]['tipe'] ?? 'teks')
                                <td @class([
                                    'r' => in_array($tipe, ['angka', 'desimal', 'persen', 'tahun']),
                                    'strong' => $loop->first,
                                    'clip' => $tipe === 'teks_panjang',
                                ])>
                                    @if ($tipe === 'pilihan' && $e->{$k})
                                        <span class="badge">{{ $e->{$k} }}</span>
                                    @else
                                        {{ ModulData::tampilDaftar($def, $e, $k, $wilayah) }}
                                    @endif
                                    @if ($loop->first && $e->lampiran && $bisaUnduh)
                                        <a href="{{ route($rute['lampiran'], $parameter + ['lampiran' => $e->lampiran->id]) }}" class="sub-info" title="Unduh {{ $e->lampiran->nama_file }}">
                                            <i class="bi bi-paperclip"></i> Lampiran
                                        </a>
                                    @endif
                                </td>
                            @endforeach
                            @if ($adaAksi)
                            <td>
                                <div class="actions">
                                    @if ($bisaUbah)
                                        <a href="{{ route('admin.modul.edit', $parameter + ['id' => $e->id]) }}" class="btn btn-outline btn-icon" title="Ubah" aria-label="Ubah data"><i class="bi bi-pencil"></i></a>
                                    @endif
                                    @if ($bolehHapus)
                                        <form action="{{ route('admin.modul.destroy', $parameter + ['id' => $e->id]) }}" method="POST"
                                              data-confirm="Hapus data ini dari {{ $modul['nama'] }}? Tindakan ini tidak dapat dibatalkan.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-icon danger" title="Hapus" aria-label="Hapus data"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                    @if (! $bisaUbah && ! $bolehHapus)
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
</section>

@endsection

@if ($grafik['ada'])
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const grafik = @json($grafik);
            const chart = SIKP.barChart(document.getElementById('grafik-daftar'), {
                labels: grafik.labels,
                unit: 'data',
                datasets: grafik.datasets,
            });
            // Jumlah data selalu bilangan bulat
            chart.options.scales.y.ticks.precision = 0;
            chart.update();
        });
    </script>
    @endpush
@endif
