@extends('layouts.viewer')

@section('title', 'Dashboard')

@section('heading', 'Dashboard Malang Selatan')

@section('hidePageHeading', true)

@section('style')
    @vite('resources/css/pages/dashboard-viewer.css')
@endsection


@section('content')

<div class="viewer-dashboard">

    {{-- =====================================================
         HERO
    ====================================================== --}}

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
                Dashboard Malang Selatan
            </h2>


            <p class="hero-description">

                Sistem informasi ketahanan pangan yang menyajikan
                informasi kawasan hutan, lahan kritis, lingkungan
                hidup, dan sumber daya manusia wilayah Malang Selatan.

            </p>


            <div class="hero-summary">

                <div class="hero-summary-icon">
                    SI
                </div>

                <div>

                    <div class="hero-summary-title">
                        Sistem Informasi Ketahanan Pangan
                    </div>

                    <div class="hero-summary-text">
                        Informasi wilayah Malang Selatan yang
                        tersedia dalam sistem.
                    </div>

                </div>

            </div>

        </div>


        <div class="hero-status">

            <span></span>

            <div>

                <strong>
                    Data Sistem
                </strong>

                <small>
                    Malang Selatan
                </small>

            </div>

        </div>

    </section>


    {{-- =====================================================
         RINGKASAN
    ====================================================== --}}

    <section class="dashboard-panel">

        <div class="panel-header">

            <div class="panel-title-wrap">

                <span class="panel-mark"></span>

                <div>

                    <h3 class="panel-title">
                        Ringkasan Data
                    </h3>

                    <div class="panel-subtitle">
                        Informasi utama wilayah Malang Selatan
                    </div>

                </div>

            </div>

            <div class="panel-badge">
                MALANG SELATAN
            </div>

        </div>


        <div class="summary-grid">


            {{-- KAWASAN HUTAN --}}

            <div class="summary-item">

                <div class="summary-icon">
                    KH
                </div>

                <div class="summary-label">
                    Total Kawasan Hutan
                </div>

                <div class="summary-value">
                    {{ number_format($totalKawasan, 0, ',', '.') }}
                </div>

                <div class="summary-unit">
                    Data kawasan
                </div>

            </div>


            {{-- LUAS KAWASAN --}}

            <div class="summary-item">

                <div class="summary-icon">
                    Ha
                </div>

                <div class="summary-label">
                    Luas Kawasan Hutan
                </div>

                <div class="summary-value">
                    {{ number_format($totalLuasKawasan, 2, ',', '.') }}
                </div>

                <div class="summary-unit">
                    Hektare
                </div>

            </div>


            {{-- LAHAN KRITIS --}}

            <div class="summary-item">

                <div class="summary-icon">
                    LK
                </div>

                <div class="summary-label">
                    Total Lahan Kritis
                </div>

                <div class="summary-value">
                    {{ number_format($totalLahanKritis, 2, ',', '.') }}
                </div>

                <div class="summary-unit">
                    Hektare
                </div>

            </div>


            {{-- KECAMATAN --}}

            <div class="summary-item">

                <div class="summary-icon">
                    K
                </div>

                <div class="summary-label">
                    Jumlah Kecamatan
                </div>

                <div class="summary-value">

                    {{ number_format(
                        max(
                            $jumlahKecamatanKawasan,
                            $jumlahKecamatanLahanKritis
                        ),
                        0,
                        ',',
                        '.'
                    ) }}

                </div>

                <div class="summary-unit">
                    Kecamatan
                </div>

            </div>


        </div>

    </section>


    {{-- =====================================================
         GRAFIK
    ====================================================== --}}

    <section class="dashboard-panel">

        <div class="panel-header">

            <div class="panel-title-wrap">

                <span class="panel-mark"></span>

                <div>

                    <h3 class="panel-title">
                        Lahan Kritis per Kecamatan
                    </h3>

                    <div class="panel-subtitle">
                        Total luas lahan kritis berdasarkan kecamatan
                    </div>

                </div>

            </div>

            <div class="panel-badge">
                LAHAN KRITIS
            </div>

        </div>


        <div class="chart-area">

            <div class="chart-title">
                Luas Lahan Kritis (Ha)
            </div>

            <div class="chart-container">

                <canvas id="grafikLahanKritisViewer"></canvas>

            </div>

        </div>

    </section>

</div>

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const canvas =
        document.getElementById('grafikLahanKritisViewer');

    if (canvas) {

        new Chart(canvas, {

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