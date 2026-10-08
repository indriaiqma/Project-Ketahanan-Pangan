@extends('layouts.viewer')

@section('title', 'Dashboard')

@section('heading', 'Dashboard Ketahanan Pangan Malang Selatan')
@section('hidePageHeading', true)

@section('style')
<style>
    /* =========================================
       MODERN DASHBOARD HERO
    ========================================= */

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
            0 8px 28px rgba(37, 107, 74, 0.06);
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

        background: rgba(234, 245, 238, 0.82);
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

        font-size: 18px;
        font-weight: 700;
    }

    .hero-summary-title {
        margin-bottom: 3px;
        color: #254633;
        font-size: 12px;
        font-weight: 700;
    }

    .hero-summary-text {
        color: #77857C;
        font-size: 10px;
        line-height: 1.5;
    }


    /* STATUS */

    .hero-status {
        position: absolute;
        z-index: 4;

        top: 25px;
        right: 27px;

        display: flex;
        align-items: center;
        gap: 9px;

        padding: 10px 14px;

        background: rgba(255, 255, 255, 0.86);
        border: 1px solid #DFEAE3;
        border-radius: 30px;

        box-shadow:
            0 5px 16px rgba(37, 107, 74, 0.06);
    }

    .hero-status > span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #42A66D;
    }

    .hero-status strong {
        display: block;
        color: #315640;
        font-size: 10px;
    }

    .hero-status small {
        display: block;
        margin-top: 2px;
        color: #89958E;
        font-size: 8px;
    }


    /* =========================================
       DEKORASI LANDSCAPE
    ========================================= */

    .hero-decoration {
        position: absolute;
        pointer-events: none;
    }

    .hero-decoration-one {
        width: 370px;
        height: 210px;

        right: -55px;
        bottom: -115px;

        border-radius: 50% 50% 0 0;
        background: rgba(92, 174, 126, 0.13);

        transform: rotate(-7deg);
    }

    .hero-decoration-two {
        width: 330px;
        height: 170px;

        right: 120px;
        bottom: -115px;

        border-radius: 55% 55% 0 0;
        background: rgba(121, 194, 151, 0.11);

        transform: rotate(7deg);
    }

    .hero-decoration-three {
        width: 230px;
        height: 230px;

        right: 40px;
        top: 70px;

        border-radius: 50%;
        background: rgba(105, 190, 139, 0.07);
    }


    /* =========================================
       DASHBOARD
    ========================================= */

    .dashboard-intro {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 18px;
    }

    .dashboard-intro h2 {
        margin: 0 0 5px;
        color: #203B2C;
        font-size: 18px;
    }

    .dashboard-intro p {
        margin: 0;
        color: #7B877F;
        font-size: 12px;
        line-height: 1.6;
    }

    .dashboard-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 7px 11px;

        border: 1px solid #D8E9DE;
        border-radius: 20px;

        background: #F2F8F4;

        color: #347A55;
        font-size: 10px;
        font-weight: 700;

        white-space: nowrap;
    }

    .dashboard-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #55B982;
    }


    /* =========================================
       SUMMARY PANEL
    ========================================= */

    .summary-panel {
        background: #FFFFFF;
        border: 1px solid #E1E9E4;
        border-radius: 12px;
        margin-bottom: 18px;
        overflow: hidden;

        box-shadow:
            0 4px 14px rgba(32, 59, 44, 0.035);
    }

    .panel-header {
        min-height: 57px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;
        padding: 0 20px;

        border-bottom: 1px solid #E7ECE9;
    }

    .panel-heading {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .panel-mark {
        width: 4px;
        height: 21px;

        border-radius: 4px;
        background: #3E9B68;
    }

    .panel-title {
        margin: 0;
        color: #203B2C;
        font-size: 14px;
        font-weight: 700;
    }

    .panel-subtitle {
        color: #8A958E;
        font-size: 10px;
    }


    /* =========================================
       STATS
    ========================================= */

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .summary-item {
        min-height: 118px;
        position: relative;
        padding: 20px;

        border-right: 1px solid #E8EDEA;
    }

    .summary-item:last-child {
        border-right: none;
    }

    .summary-label {
        margin-bottom: 9px;
        color: #78857D;
        font-size: 11px;
        font-weight: 600;
    }

    .summary-value {
        color: #203B2C;
        font-size: 25px;
        font-weight: 700;
        line-height: 1;
    }

    .summary-unit {
        margin-top: 8px;
        color: #9AA39D;
        font-size: 10px;
    }

    .summary-icon {
        position: absolute;

        top: 20px;
        right: 18px;

        width: 34px;
        height: 34px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 9px;
        background: #EAF5EE;
        color: #3E9B68;

        font-size: 15px;
        font-weight: 700;
    }

    .summary-item.warning .summary-icon {
        background: #FFF5E7;
        color: #D28A25;
    }

    .summary-item.danger .summary-icon {
        background: #FFF0EF;
        color: #C9514D;
    }


    /* =========================================
       CHART
    ========================================= */

    .chart-panel {
        background: #FFFFFF;
        border: 1px solid #E1E9E4;
        border-radius: 12px;
        margin-bottom: 18px;
        overflow: hidden;

        box-shadow:
            0 4px 14px rgba(32, 59, 44, 0.035);
    }

    .chart-header {
        min-height: 61px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;
        padding: 0 20px;

        border-bottom: 1px solid #E7ECE9;
    }

    .chart-title {
        margin: 0 0 4px;
        color: #203B2C;
        font-size: 14px;
    }

    .chart-description {
        color: #8A958E;
        font-size: 10px;
    }

    .chart-unit {
        padding: 6px 10px;
        border-radius: 20px;

        background: #F0F7F2;
        color: #4C8160;

        font-size: 10px;
        font-weight: 700;
    }

    .chart-body {
        height: 320px;
        padding: 20px 22px 18px;
    }


    /* =========================================
       MODULE
    ========================================= */

    .module-panel {
        background: #FFFFFF;
        border: 1px solid #E1E9E4;
        border-radius: 12px;
        overflow: hidden;

        box-shadow:
            0 4px 14px rgba(32, 59, 44, 0.035);
    }

    .module-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .module-item {
        min-height: 180px;
        padding: 20px;

        border-right: 1px solid #E8EDEA;

        display: flex;
        flex-direction: column;
    }

    .module-item:last-child {
        border-right: none;
    }

    .module-icon {
        width: 37px;
        height: 37px;

        display: flex;
        align-items: center;
        justify-content: center;

        margin-bottom: 15px;

        border-radius: 9px;

        background: #EAF5EE;
        color: #347A55;

        font-size: 16px;
        font-weight: 700;
    }

    .module-item h3 {
        margin: 0 0 7px;
        color: #203B2C;
        font-size: 13px;
    }

    .module-item p {
        margin: 0 0 15px;
        color: #808C84;
        font-size: 10px;
        line-height: 1.6;
        flex: 1;
    }

    .module-link {
        color: #347A55;
        font-size: 10px;
        font-weight: 700;
    }

    .module-link:hover {
        color: #256B4A;
    }

    .module-coming {
        color: #9AA39D;
        font-size: 10px;
        font-weight: 700;
    }


    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 1050px) {

        .summary-grid,
        .module-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .summary-item:nth-child(2),
        .module-item:nth-child(2) {
            border-right: none;
        }

        .summary-item:nth-child(-n+2),
        .module-item:nth-child(-n+2) {
            border-bottom: 1px solid #E8EDEA;
        }
    }

    @media (max-width: 850px) {

        .dashboard-hero {
            min-height: auto;
            padding: 30px 25px;
        }

        .hero-content {
            width: 100%;
        }

        .dashboard-hero h2 {
            padding-right: 0;
            font-size: 26px;
        }

        .hero-status {
            position: relative;
            top: auto;
            right: auto;
            width: fit-content;
            margin-top: 18px;
        }

        .hero-decoration-one,
        .hero-decoration-two,
        .hero-decoration-three {
            opacity: 0.7;
        }
    }

    @media (max-width: 650px) {

        .dashboard-intro {
            align-items: flex-start;
            flex-direction: column;
        }

        .summary-grid,
        .module-grid {
            grid-template-columns: 1fr;
        }

        .summary-item,
        .module-item {
            border-right: none;
            border-bottom: 1px solid #E8EDEA;
        }

        .summary-item:last-child,
        .module-item:last-child {
            border-bottom: none;
        }

        .panel-header,
        .chart-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 15px 17px;
        }

        .chart-body {
            height: 280px;
            padding: 15px;
        }

        .dashboard-hero {
            padding: 24px 20px;
            border-radius: 13px;
        }

        .dashboard-hero h2 {
            font-size: 23px;
        }

        .hero-description {
            font-size: 12px;
        }

        .hero-summary {
            width: 100%;
        }
    }
</style>
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