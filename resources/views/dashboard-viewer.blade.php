@extends('layouts.dashboard-viewer')

@section('title', 'Dashboard Ketahanan Pangan Malang Selatan')

@php
    /*
     * Data default (sesuai desain). Agar dinamis, kirim variabel dengan nama yang sama
     * dari controller, misalnya: return view('dashboard-viewer', compact('totalKawasan', ...));
     */
    $totalKawasan       = $totalKawasan       ?? 0;
    $totalLuasKawasan   = $totalLuasKawasan   ?? 0;
    $kecKawasanHutan    = $kecKawasanHutan    ?? 0;
    $kecLahanKritis     = $kecLahanKritis     ?? 9;
    $terakhirDiperbarui = $terakhirDiperbarui ?? '14 Oktober 2025';

    // Per kecamatan: [sangat kritis, kritis, agak kritis] dalam Ha
    $lahanPerKecamatan = $lahanPerKecamatan ?? [
        'Wajak'         => [4900, 6500, 8400],
        'Tirtoyudo'     => [1000, 2500, 3800],
        'Ampelgading'   => [1000, 2100, 3200],
        'Sumbermanjing' => [1000, 1600, 2100],
        'Dampit'        => [500, 1600, 2200],
        'Bantur'        => [2800, 4300, 6100],
        'Pagak'         => [800, 4300, 6100],
        'Kalipenes'     => [800, 1300, 1600],
        'Wonosari'      => [400, 1000, 1500],
    ];

    $ringkasan = $ringkasan ?? [
        ['label' => 'Sangat Kritis', 'ha' => 18932.34, 'color' => '#f2602a'],
        ['label' => 'Kritis',        'ha' => 34632.80, 'color' => '#fbab2e'],
        ['label' => 'Agak Kritis',   'ha' => 68421.17, 'color' => '#8cc22b'],
        ['label' => 'Tidak Kritis',  'ha' => 31870.93, 'color' => '#d9dee5'],
    ];
    $totalLuas = collect($ringkasan)->sum('ha');

    $r = fn ($name, $fallback = '#') => \Illuminate\Support\Facades\Route::has($name) ? route($name) : $fallback;
    $fmt = fn ($n) => number_format($n, 2, ',', '.');
@endphp

@section('content')

{{-- ===== Hero ===== --}}
<section class="dv-hero">
    <div class="dv-badge">Data Tersedia <small>Data tersimpan dalam sistem</small></div>

    <svg class="dv-hero__art" viewBox="0 0 700 204" preserveAspectRatio="xMaxYMax slice" aria-hidden="true">
        <circle cx="470" cy="60" r="34" fill="#cfe6f2" opacity=".55"/>
        <path d="M120 204 L330 60 Q380 20 440 50 L640 150 L700 120 V204Z" fill="#a9cdb2" opacity=".75"/>
        <path d="M0 204 Q150 110 300 150 T560 120 T700 150 V204Z" fill="#c4dec9"/>
        <path d="M200 204 Q380 120 520 170 T700 140 V204Z" fill="#8fbf9d"/>
        <g fill="#5d9a6e" opacity=".9">
            <circle cx="420" cy="140" r="12"/><circle cx="445" cy="132" r="14"/><circle cx="470" cy="138" r="12"/>
            <circle cx="500" cy="130" r="13"/><circle cx="530" cy="136" r="12"/>
        </g>
        <path d="M0 204 Q200 150 420 190 T700 170 V204Z" fill="#6fae85"/>
        <g fill="#14693f">
            <path d="M650 200 C640 150 640 110 660 60 C675 110 675 150 665 200Z"/>
            <path d="M660 150 C620 140 600 160 590 200 C630 195 650 180 660 150Z"/>
            <path d="M665 140 C700 130 710 160 700 200 C670 190 662 170 665 140Z"/>
        </g>
    </svg>

    <div class="dv-hero__eyebrow">RINGKASAN DATA</div>
<h1>Dashboard Ketahanan Pangan Malang Selatan</h1>
<p>Ringkasan informasi dan pemantauan data kawasan hutan dan lahan kritis di wilayah Malang Selatan.</p>
    <div class="dv-hero__note">
        <i class="bi bi-flower1"></i>
        <div class="dv-badge">Data Tersedia</div>
    </div>
</section>

{{-- ===== Statistik ===== --}}
<section class="dv-stats">
    <a href="{{ $r('kawasan-hutan.index') }}" class="dv-card dv-stat">
        <span class="dv-stat__icon"><i class="bi bi-tree-fill"></i></span>
        <span class="dv-stat__body">
            <div class="dv-stat__label">Total Kawasan Hutan</div>
            <div class="dv-stat__value">{{ number_format($totalKawasan, 0, ',', '.') }}</div>
            <div class="dv-stat__unit">Data kawasan</div>
        </span>
        <i class="bi bi-chevron-right dv-stat__go"></i>
    </a>
    <a href="{{ $r('kawasan-hutan.index') }}" class="dv-card dv-stat">
        <span class="dv-stat__icon"><i class="bi bi-map-fill"></i></span>
        <span class="dv-stat__body">
            <div class="dv-stat__label">Total Luas Kawasan</div>
            <div class="dv-stat__value">{{ $fmt($totalLuasKawasan) }}</div>
            <div class="dv-stat__unit">Hektare</div>
        </span>
        <i class="bi bi-chevron-right dv-stat__go"></i>
    </a>
    <a href="{{ $r('kawasan-hutan.index') }}" class="dv-card dv-stat">
        <span class="dv-stat__icon"><i class="bi bi-geo-alt-fill"></i></span>
        <span class="dv-stat__body">
            <div class="dv-stat__label">Kecamatan Kawasan Hutan</div>
            <div class="dv-stat__value">{{ $kecKawasanHutan }}</div>
            <div class="dv-stat__unit">Kecamatan</div>
        </span>
        <i class="bi bi-chevron-right dv-stat__go"></i>
    </a>
    <a href="{{ $r('lahan-kritis.index') }}" class="dv-card dv-stat">
        <span class="dv-stat__icon"><i class="bi bi-exclamation-triangle"></i></span>
        <span class="dv-stat__body">
            <div class="dv-stat__label">Kecamatan Lahan Kritis</div>
            <div class="dv-stat__value">{{ $kecLahanKritis }}</div>
            <div class="dv-stat__unit">Kecamatan</div>
        </span>
        <i class="bi bi-chevron-right dv-stat__go"></i>
    </a>
</section>

{{-- ===== Grafik ===== --}}
<section class="dv-grid">
    <div class="dv-card dv-panel">
        <div class="dv-panel__head">
            <div class="dv-panel__title">
                <i class="bi bi-bar-chart-fill"></i>
                <div><h2>Kondisi Lahan Kritis</h2><p>Perbandingan luas lahan berdasarkan tingkat kekritisan</p></div>
            </div>
            <div class="dv-legend">
                <span style="--c: var(--red)">Sangat Kritis</span>
                <span style="--c: var(--orange)">Kritis</span>
                <span style="--c: var(--green)">Agak Kritis</span>
            </div>
        </div>
        <div class="dv-bar-wrap"><canvas id="chartBar" aria-label="Grafik batang kondisi lahan kritis per kecamatan"></canvas></div>
    </div>

    <div class="dv-card dv-panel">
        <div class="dv-panel__head">
            <div class="dv-panel__title">
                <i class="bi bi-pie-chart-fill"></i>
                <div><h2>Ringkasan Luas Wilayah</h2><p>Komposisi tingkat kekritisan lahan</p></div>
            </div>
        </div>
        <div class="dv-donut">
            <div class="dv-donut__chart">
                <canvas id="chartDonut" aria-label="Grafik donat komposisi kekritisan lahan"></canvas>
                <div class="dv-donut__center"><span>Total Luas</span><b>{{ $fmt($totalLuas) }}</b><span>Ha</span></div>
            </div>
            <ul class="dv-donut__list">
                @foreach ($ringkasan as $row)
                    <li style="--c: {{ $row['color'] }}">
                        <i></i><span>{{ $row['label'] }}</span>
                        <span>{{ $fmt($row['ha']) }} Ha</span>
                        <em>{{ number_format($row['ha'] / max($totalLuas, 1) * 100, 1, ',', '.') }}%</em>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- ===== Akses data ===== --}}
<div class="dv-section">
    <i class="bi bi-grid-fill"></i>
    <div><h3>Akses Data</h3><p>Pilih menu untuk melihat dan mengelola data sesuai kebutuhan</p></div>
</div>

<section class="dv-access">
    <a href="{{ $r('kawasan-hutan.index') }}" class="dv-card dv-access__item">
        <span class="dv-access__icon"><i class="bi bi-tree-fill"></i></span>
        <span>
            <h4>Kawasan Hutan</h4>
            <p>Informasi lokasi, nama kawasan, jenis kawasan dan luas area.</p>
            <span class="dv-access__link">Lihat data <i class="bi bi-arrow-right"></i></span>
        </span>
        <i class="bi bi-chevron-right dv-access__chev"></i>
    </a>
    <a href="{{ $r('lahan-kritis.index') }}" class="dv-card dv-access__item">
        <span class="dv-access__icon"><i class="bi bi-flower2"></i></span>
        <span>
            <h4>Lahan Kritis</h4>
            <p>Informasi kondisi lahan berdasarkan tingkat kekritisan wilayah.</p>
            <span class="dv-access__link">Lihat data <i class="bi bi-arrow-right"></i></span>
        </span>
        <i class="bi bi-chevron-right dv-access__chev"></i>
    </a>
    <a href="{{ $r('lingkungan-hidup') }}" class="dv-card dv-access__item">
        <span class="dv-access__icon"><i class="bi bi-globe-asia-australia"></i></span>
        <span>
            <h4>Lingkungan Hidup</h4>
            <p>Data lingkungan hidup dan pengelolaan wilayah Malang Selatan.</p>
            <span class="dv-access__link">Lihat data <i class="bi bi-arrow-right"></i></span>
        </span>
        <i class="bi bi-chevron-right dv-access__chev"></i>
    </a>
</section>

<div class="dv-foot"><i class="bi bi-clock-history"></i> Pembaruan data terakhir: {{ $terakhirDiperbarui }}</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const kec = @json(array_keys($lahanPerKecamatan));
    const rows = @json(array_values($lahanPerKecamatan));
    const ringkasan = @json($ringkasan);
    const nf = new Intl.NumberFormat('id-ID');
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#3c4f45';

    new Chart(document.getElementById('chartBar'), {
        type: 'bar',
        data: {
            labels: kec,
            datasets: [
                { label: 'Sangat Kritis', data: rows.map(r => r[0]), backgroundColor: '#f43f4f', borderRadius: 2 },
                { label: 'Kritis',        data: rows.map(r => r[1]), backgroundColor: '#fbab2e', borderRadius: 2 },
                { label: 'Agak Kritis',   data: rows.map(r => r[2]), backgroundColor: '#1f9d6b', borderRadius: 2 },
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            categoryPercentage: .7, barPercentage: .95,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: c => ` ${c.dataset.label}: ${nf.format(c.parsed.y)} Ha` } }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Luas (Ha)', font: { size: 11 } },
                    ticks: { font: { size: 11 }, callback: v => nf.format(v) },
                    grid: { color: '#edf1ee' }, border: { display: false }
                }
            }
        }
    });

    new Chart(document.getElementById('chartDonut'), {
        type: 'doughnut',
        data: {
            labels: ringkasan.map(r => r.label),
            datasets: [{ data: ringkasan.map(r => r.ha), backgroundColor: ringkasan.map(r => r.color), borderWidth: 0 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: c => ` ${c.label}: ${nf.format(c.parsed)} Ha` } }
            }
        }
    });
</script>
@endpush