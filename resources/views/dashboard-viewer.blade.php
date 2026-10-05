@extends('layouts.viewer')

@section('title', 'Dashboard')

@section('heading', 'Dashboard Malang Selatan')

@section('hidePageHeading', true)

@section('style')

<style>

    .viewer-dashboard {
        padding-bottom: 30px;
    }

    /* =====================================================
       HERO
    ===================================================== */

    .dashboard-hero {
        position: relative;
        min-height: 285px;
        margin-bottom: 22px;
        padding: 36px 38px;

        display: flex;
        align-items: center;

        overflow: hidden;

        background:
            linear-gradient(
                120deg,
                #FFFFFF 0%,
                #FBFDFC 52%,
                #EEF7F1 100%
            );

        border: 1px solid #DFE9E2;
        border-radius: 16px;

        box-shadow:
            0 8px 28px rgba(37,107,74,0.06);
    }

    .hero-content {
        position: relative;
        z-index: 3;
        width: 72%;
    }

    .hero-label {
        display: flex;
        align-items: center;
        gap: 10px;

        margin-bottom: 13px;

        color: #6F8176;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .hero-label-line {
        width: 31px;
        height: 4px;

        display: inline-block;

        border-radius: 10px;

        background: #3E9B68;
    }

    .dashboard-hero h2 {
        max-width: 820px;

        margin: 0 0 11px;

        color: #173D2A;

        font-size: 30px;
        font-weight: 750;
        line-height: 1.25;
    }

    .hero-description {
        max-width: 720px;

        margin: 0;

        color: #738279;

        font-size: 13px;
        line-height: 1.7;
    }

    .hero-summary {
        width: fit-content;
        max-width: 650px;

        margin-top: 25px;
        padding: 12px 17px 12px 12px;

        display: flex;
        align-items: center;
        gap: 13px;

        background: rgba(234,245,238,0.82);

        border: 1px solid #E0EEE5;
        border-radius: 11px;
    }

    .hero-summary-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background: #D9EEE1;
        color: #2F8B5A;

        font-size: 11px;
        font-weight: 800;
    }

    .hero-summary-title {
        margin-bottom: 3px;

        color: #254633;

        font-size: 13px;
        font-weight: 750;
    }

    .hero-summary-text {
        color: #718078;

        font-size: 11px;
        line-height: 1.5;
    }

    /* =====================================================
       HERO STATUS
    ===================================================== */

    .hero-status {
        position: absolute;

        top: 27px;
        right: 30px;

        z-index: 5;

        display: flex;
        align-items: center;
        gap: 9px;

        padding: 11px 15px;

        background: rgba(255,255,255,0.92);

        border: 1px solid #E1EAE4;
        border-radius: 30px;

        box-shadow:
            0 5px 18px rgba(40,90,65,0.06);
    }

    .hero-status > span {
        width: 9px;
        height: 9px;

        border-radius: 50%;

        background: #D5A13A;
    }

    .hero-status strong {
        display: block;

        color: #34483C;

        font-size: 11px;
        font-weight: 750;
    }

    .hero-status small {
        display: block;

        margin-top: 2px;

        color: #8A968F;

        font-size: 9px;
    }

    /* =====================================================
       HERO DECORATION
    ===================================================== */

    .hero-decoration {
        position: absolute;

        border-radius: 50%;

        pointer-events: none;
    }

    .hero-decoration-one {
        width: 250px;
        height: 250px;

        right: -10px;
        bottom: -145px;

        background: rgba(96,181,132,0.12);
    }

    .hero-decoration-two {
        width: 190px;
        height: 190px;

        right: 40px;
        bottom: -20px;

        background: rgba(78,163,116,0.08);
    }

    .hero-decoration-three {
        width: 160px;
        height: 160px;

        right: 80px;
        top: 75px;

        background: rgba(115,192,148,0.08);
    }

    /* =====================================================
       PANEL
    ===================================================== */

    .dashboard-panel {
        margin-bottom: 22px;

        background: #FFFFFF;

        border: 1px solid #E0E9E3;
        border-radius: 16px;

        overflow: hidden;

        box-shadow:
            0 7px 25px rgba(37,107,74,0.045);
    }

    .panel-header {
        min-height: 64px;

        padding: 14px 22px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        border-bottom: 1px solid #E8EDEA;
    }

    .panel-title-wrap {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .panel-mark {
        width: 4px;
        height: 26px;

        display: inline-block;

        border-radius: 10px;

        background: #3E9B68;
    }

    .panel-title {
        margin: 0;

        color: #254633;

        font-size: 14px;
        font-weight: 750;
    }

    .panel-subtitle {
        margin-top: 3px;

        color: #829087;

        font-size: 10px;
    }

    .panel-badge {
        padding: 7px 13px;

        border-radius: 20px;

        background: #EEF7F1;

        color: #317852;

        font-size: 9px;
        font-weight: 800;
    }

    /* =====================================================
       SUMMARY
    ===================================================== */

    .summary-grid {
        display: grid;

        grid-template-columns:
            repeat(4, 1fr);
    }

    .summary-item {
        min-height: 155px;

        padding: 22px;

        border-right: 1px solid #E8EDEA;
    }

    .summary-item:last-child {
        border-right: none;
    }

    .summary-icon {
        width: 38px;
        height: 38px;

        margin-bottom: 13px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;

        background: #E7F3EB;

        color: #31815A;

        font-size: 10px;
        font-weight: 800;
    }

    .summary-label {
        margin-bottom: 7px;

        color: #7B887F;

        font-size: 10px;
        font-weight: 650;
    }

    .summary-value {
        color: #173D2A;

        font-size: 25px;
        font-weight: 800;
        line-height: 1;
    }

    .summary-unit {
        margin-top: 6px;

        color: #9AA49E;

        font-size: 9px;
    }

    /* =====================================================
       GRAFIK
    ===================================================== */

    .chart-area {
        padding: 24px;
    }

    .chart-title {
        margin-bottom: 18px;

        color: #254633;

        font-size: 13px;
        font-weight: 750;
    }

    .chart-container {
        position: relative;

        height: 300px;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media(max-width: 1000px) {

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .summary-item:nth-child(2) {
            border-right: none;
        }

        .summary-item:nth-child(1),
        .summary-item:nth-child(2) {
            border-bottom: 1px solid #E8EDEA;
        }
    }

    @media(max-width: 750px) {

        .dashboard-hero {
            min-height: auto;
            padding: 28px 23px;

            display: block;
        }

        .hero-content {
            width: 100%;
        }

        .dashboard-hero h2 {
            font-size: 25px;
        }

        .hero-status {
            position: relative;

            top: auto;
            right: auto;

            width: fit-content;

            margin-top: 20px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .summary-item {
            border-right: none;
            border-bottom: 1px solid #E8EDEA;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .chart-container {
            height: 260px;
        }
    }

</style>

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