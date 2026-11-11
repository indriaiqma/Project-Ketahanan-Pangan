@extends('layouts.app')

@section('title', 'Dashboard')

@section('heading', 'Dashboard Ketahanan Pangan Malang Selatan')
@section('hidePageHeading', true)

@section('style')
    @vite('resources/css/pages/dashboard.css')
@endsection


@section('content')

{{-- HERO DASHBOARD --}}
<section class="dashboard-hero">

    <div class="hero-decoration hero-decoration-one"></div>
    <div class="hero-decoration hero-decoration-two"></div>
    <div class="hero-decoration hero-decoration-three"></div>

    <div class="hero-content">

        <div class="hero-label">
            <span class="hero-label-line"></span>
            SISTEM INFORMASI KETAHANAN PANGAN
        </div>

        <h2>
            Dashboard Ketahanan Pangan Malang Selatan
        </h2>

        <p class="hero-description">
            Ringkasan informasi dan pemantauan data kehutanan
            dan lahan kritis di wilayah Malang Selatan.
        </p>

        <div class="hero-summary">

            <div class="hero-summary-icon">
                ▥
            </div>

            <div>
                <div class="hero-summary-title">
                    Ringkasan Data
                </div>

                <div class="hero-summary-text">
                    Informasi utama kondisi kehutanan dan lahan kritis
                    wilayah Malang Selatan.
                </div>
            </div>

        </div>

    </div>

    <div class="hero-status">
        <span></span>

        <div>
            <strong>Data Tersedia</strong>
            <small>Data tersimpan dalam sistem</small>
        </div>
    </div>

</section>


{{-- ==========================================
     KEHUTANAN
========================================== --}}
<section class="summary-panel">

    <div class="panel-header">

        <div class="panel-heading">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Ringkasan Kehutanan
                </h3>

                <div class="panel-subtitle">
                    Data kawasan hutan yang tersimpan dalam sistem
                </div>

            </div>

        </div>

    </div>


    <div class="summary-grid">

        <div class="summary-item">

            <div class="summary-label">
                Total Kawasan Hutan
            </div>

            <div class="summary-value">
                {{ $totalKawasan }}
            </div>

            <div class="summary-unit">
                Data kawasan
            </div>

            <div class="summary-icon">
                H
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-label">
                Total Luas Kawasan
            </div>

            <div class="summary-value">
                {{ number_format($totalLuasKawasan, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

            <div class="summary-icon">
                Ha
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-label">
                Kecamatan Kawasan Hutan
            </div>

            <div class="summary-value">
                {{ $jumlahKecamatanKawasan }}
            </div>

            <div class="summary-unit">
                Kecamatan
            </div>

            <div class="summary-icon">
                K
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-label">
                Kecamatan Lahan Kritis
            </div>

            <div class="summary-value">
                {{ $jumlahKecamatanLahanKritis }}
            </div>

            <div class="summary-unit">
                Kecamatan
            </div>

            <div class="summary-icon">
                LK
            </div>

        </div>

    </div>

</section>


{{-- ==========================================
     LAHAN KRITIS
========================================== --}}
<section class="summary-panel">

    <div class="panel-header">

        <div class="panel-heading">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Ringkasan Lahan Kritis
                </h3>

                <div class="panel-subtitle">
                    Kondisi tingkat kekritisan lahan Malang Selatan
                </div>

            </div>

        </div>

    </div>


    <div class="summary-grid">

        <div class="summary-item">

            <div class="summary-label">
                Total Lahan
            </div>

            <div class="summary-value">
                {{ number_format($totalLahanKritis, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

            <div class="summary-icon">
                Ha
            </div>

        </div>


        <div class="summary-item danger">

            <div class="summary-label">
                Sangat Kritis
            </div>

            <div class="summary-value">
                {{ number_format($totalSangatKritis, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

            <div class="summary-icon">
                !
            </div>

        </div>


        <div class="summary-item warning">

            <div class="summary-label">
                Kritis
            </div>

            <div class="summary-value">
                {{ number_format($totalKritis, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

            <div class="summary-icon">
                !
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-label">
                Cakupan Kecamatan
            </div>

            <div class="summary-value">
                {{ $jumlahKecamatanLahanKritis }}
            </div>

            <div class="summary-unit">
                Kecamatan
            </div>

            <div class="summary-icon">
                K
            </div>

        </div>

    </div>

</section>


{{-- ==========================================
     GRAFIK
========================================== --}}
<section class="chart-panel">

    <div class="chart-header">

        <div>

            <h3 class="chart-title">
                Grafik Total Lahan per Kecamatan
            </h3>

            <div class="chart-description">
                Perbandingan total luas lahan pada setiap kecamatan
            </div>

        </div>

        <div class="chart-unit">
            HEKTARE (HA)
        </div>

    </div>


    <div class="chart-body">
        <canvas id="grafikLahanKritis"></canvas>
    </div>

</section>


{{-- ==========================================
     MENU DATA
========================================== --}}
<section class="module-panel">

    <div class="panel-header">

        <div class="panel-heading">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Menu Data
                </h3>

                <div class="panel-subtitle">
                    Akses data berdasarkan kategori
                </div>

            </div>

        </div>

    </div>


    <div class="module-grid">

        <div class="module-item">

            <div class="module-icon">
                KH
            </div>

            <h3>
                Kawasan Hutan
            </h3>

            <p>
                Informasi lokasi, nama kawasan,
                jenis kawasan dan luas area.
            </p>

            <a
                href="{{ route('kawasan-hutan.index') }}"
                class="module-link"
            >
                Lihat Data →
            </a>

        </div>


        <div class="module-item">

            <div class="module-icon">
                LK
            </div>

            <h3>
                Lahan Kritis
            </h3>

            <p>
                Informasi kondisi lahan berdasarkan
                tingkat kekritisan wilayah.
            </p>

            <a
                href="{{ route('lahan-kritis.index') }}"
                class="module-link"
            >
                Lihat Data →
            </a>

        </div>


        <div class="module-item">

            <div class="module-icon">
                LH
            </div>

            <h3>
                Lingkungan Hidup
            </h3>

            <p>
                Modul informasi lingkungan hidup
                Malang Selatan.
            </p>

            <span class="module-coming">
                SEGERA HADIR
            </span>

        </div>


        <div class="module-item">

            <div class="module-icon">
                SDM
            </div>

            <h3>
                SDM
            </h3>

            <p>
                Modul informasi sumber daya manusia
                akan tersedia setelah data dimasukkan.
            </p>

            <span class="module-coming">
                SEGERA HADIR
            </span>

        </div>

    </div>

</section>

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('grafikLahanKritis');

    if (ctx) {

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: @json($labelGrafik),

                datasets: [{
                    label: 'Total Lahan (Ha)',

                    data: @json($dataGrafik),

                    backgroundColor:
                        'rgba(62, 155, 104, 0.72)',

                    borderColor:
                        '#3E9B68',

                    borderWidth: 1,

                    borderRadius: 5,

                    maxBarThickness: 48
                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {
                        displayColors: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        grid: {
                            color: '#EEF2EF'
                        },

                        border: {
                            display: false
                        },

                        ticks: {
                            color: '#7B877F',

                            font: {
                                size: 10
                            }
                        },

                        title: {
                            display: true,
                            text: 'Luas (Ha)',
                            color: '#7B877F'
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        },

                        ticks: {
                            color: '#7B877F',

                            maxRotation: 35,
                            minRotation: 15,

                            font: {
                                size: 10
                            }
                        }

                    }

                }

            }

        });

    }
</script>

@endsection