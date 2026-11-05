{{-- Statistik + grafik kawasan hutan (dipakai halaman publik & admin) --}}
<section class="grid grid-4">
    <x-stat icon="tree-fill" label="Total Kawasan" :value="angka($totalKawasan, 0)" unit="data kawasan" />
    <x-stat icon="map-fill" label="Total Luas" :value="angka($totalLuas)" unit="hektare" tone="sky" />
    <x-stat icon="geo-alt-fill" label="Jumlah Kecamatan" :value="angka($jumlahKecamatan, 0)" unit="kecamatan" />
    <x-stat icon="tags-fill" label="Jenis Kawasan" :value="angka($jumlahJenisKawasan, 0)" unit="jenis" tone="amber" />
</section>

@include('partials.chart-kawasan', ['labels' => $labelGrafik, 'values' => $dataGrafik])
