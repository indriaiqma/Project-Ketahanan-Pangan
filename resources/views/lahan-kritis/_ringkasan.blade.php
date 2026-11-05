{{-- Statistik + grafik lahan kritis (dipakai halaman publik & admin) --}}
<section class="grid grid-4">
    <x-stat icon="layers-fill" label="Total Luas Lahan" :value="angka($totalLahan)" unit="hektare (semua kategori)" />
    <x-stat icon="exclamation-octagon-fill" label="Sangat Kritis" :value="angka($totalSangatKritis)" unit="hektare" tone="red" />
    <x-stat icon="exclamation-triangle-fill" label="Kritis" :value="angka($totalKritis)" unit="hektare" tone="amber" />
    <x-stat icon="geo-alt-fill" label="Kecamatan Terdata" :value="angka($jumlahKecamatan, 0)" unit="kecamatan" />
</section>

@include('partials.chart-lahan-kritis', [
    'labels' => $labelGrafik,
    'sangat' => $dataGrafik['sangat_kritis'],
    'kritis' => $dataGrafik['kritis'],
    'agak'   => $dataGrafik['agak_kritis'],
])
