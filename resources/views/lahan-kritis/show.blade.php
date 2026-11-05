@extends(auth()->user()?->isStaff() ? 'layouts.admin' : 'layouts.public')

@section('title', 'Lahan Kritis ' . $lahanKritis->kecamatan)

@section('content')

@php
    $isStaff = (bool) auth()->user()?->isStaff();
    $kategori = [
        'sangat_kritis'    => ['Sangat Kritis',    '#e5484d'],
        'kritis'           => ['Kritis',           '#f5a524'],
        'agak_kritis'      => ['Agak Kritis',      '#7cb82f'],
        'potensial_kritis' => ['Potensial Kritis', '#2f80c2'],
        'tidak_kritis'     => ['Tidak Kritis',     '#c9d1cc'],
    ];
    $ringkasan = collect($kategori)->map(fn ($m, $k) => [
        'label' => $m[0],
        'ha'    => (float) $lahanKritis->{'dalam_' . $k} + (float) $lahanKritis->{'luar_' . $k},
        'color' => $m[1],
    ])->values()->all();
@endphp

<x-page-header eyebrow="Detail Lahan Kritis" :title="'Kecamatan ' . $lahanKritis->kecamatan" :description="$lahanKritis->kabupaten">
    <x-slot:breadcrumb>
        @if ($isStaff)
            <a href="{{ route('admin.lahan-kritis.index') }}">Lahan Kritis</a>
        @else
            <a href="{{ route('dashboard') }}">Beranda</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('lahan-kritis.index') }}">Lahan Kritis</a>
        @endif
        <i class="bi bi-chevron-right"></i>
        <span>Detail</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <a href="{{ route($isStaff ? 'admin.lahan-kritis.index' : 'lahan-kritis.index') }}" class="btn btn-outline"><i class="bi bi-arrow-left"></i> Kembali</a>
        @if (auth()->user()?->canEditData())
            <a href="{{ route('admin.lahan-kritis.edit', $lahanKritis) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Ubah Data</a>
        @endif
    </x-slot:actions>
</x-page-header>

<section class="grid grid-4">
    <x-stat icon="layers-fill" label="Total Luas" :value="angka($lahanKritis->total_ha)" unit="hektare" />
    <x-stat icon="exclamation-octagon-fill" label="Sangat Kritis" :value="angka($ringkasan[0]['ha'])" unit="hektare" tone="red" />
    <x-stat icon="exclamation-triangle-fill" label="Kritis" :value="angka($ringkasan[1]['ha'])" unit="hektare" tone="amber" />
    <x-stat icon="shield-check" label="Agak Kritis" :value="angka($ringkasan[2]['ha'])" unit="hektare" />
</section>

<section class="grid grid-main">
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-table"></i></span>
                <div><h2>Rincian per Kategori</h2><p>Luas lahan (Ha) di dalam dan di luar kawasan hutan</p></div>
            </div>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tingkat Kekritisan</th>
                        <th class="r">Dalam Kawasan</th>
                        <th class="r">Luar Kawasan</th>
                        <th class="r">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $kolom => [$label, $warna])
                        <tr>
                            <td><span class="legend"><span style="--c: {{ $warna }}">{{ $label }}</span></span></td>
                            <td class="r">{{ angka($lahanKritis->{'dalam_' . $kolom}) }}</td>
                            <td class="r">{{ angka($lahanKritis->{'luar_' . $kolom}) }}</td>
                            <td class="r strong">{{ angka($ringkasan[$loop->index]['ha']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total</td>
                        <td class="r">{{ angka(collect(array_keys($kategori))->sum(fn ($k) => $lahanKritis->{'dalam_' . $k})) }}</td>
                        <td class="r">{{ angka(collect(array_keys($kategori))->sum(fn ($k) => $lahanKritis->{'luar_' . $k})) }}</td>
                        <td class="r">{{ angka($lahanKritis->total_ha) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-foot">
            <i class="bi bi-clock-history"></i>
            Terakhir diperbarui {{ $lahanKritis->updated_at?->translatedFormat('d F Y, H:i') ?? '–' }} WIB
        </div>
    </section>

    @include('partials.chart-komposisi', ['ringkasan' => $ringkasan])
</section>

@endsection
