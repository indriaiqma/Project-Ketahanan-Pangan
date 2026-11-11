@extends('layouts.viewer')

@section('title', 'Kawasan Hutan')

@section('heading', 'Data Kawasan Hutan Malang Selatan')

@section('hidePageHeading', true)

@section('style')

<style>

/* =========================================================
   HERO
========================================================= */

.dashboard-hero {
    position: relative;
    min-height: 285px;
    margin-bottom: 22px;
    padding: 36px 38px;

    display: flex;
    align-items: center;

    overflow: hidden;

    background: linear-gradient(
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

    font-size: 12px;
    font-weight: 800;
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

    font-size: 9px;
}

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


/* =========================================================
   ALERT
========================================================= */

.page-alert {
    display: flex;
    align-items: center;
    gap: 9px;

    margin-bottom: 18px;
    padding: 11px 14px;

    background: #EFF8F2;

    border: 1px solid #D9EBDF;
    border-radius: 9px;

    color: #347A55;

    font-size: 10px;
    font-weight: 600;
}

.page-alert-icon {
    width: 23px;
    height: 23px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #DCEFE3;

    border-radius: 50%;
}


/* =========================================================
   PANEL
========================================================= */

.dashboard-panel {
    margin-bottom: 18px;

    background: #FFFFFF;

    border: 1px solid #E1E9E4;
    border-radius: 12px;

    overflow: hidden;

    box-shadow:
        0 4px 16px rgba(32, 59, 44, 0.035);
}

.panel-header {
    min-height: 60px;

    padding: 0 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    border-bottom: 1px solid #E8EDE9;
}

.panel-title-wrap {
    display: flex;
    align-items: center;

    gap: 10px;
}

.panel-mark {
    width: 4px;
    height: 23px;

    background: #3E9B68;

    border-radius: 10px;
}

.panel-title {
    margin: 0 0 3px;

    color: #203B2C;

    font-size: 13px;
    font-weight: 700;
}

.panel-subtitle {
    color: #89958E;

    font-size: 10px;

    line-height: 1.5;
}

.panel-badge {
    padding: 6px 10px;

    background: #F0F7F2;

    border-radius: 20px;

    color: #4C805F;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .4px;
}


/* =========================================================
   SUMMARY
========================================================= */

.summary-grid {
    display: grid;

    grid-template-columns: repeat(4, 1fr);
}

.summary-item {
    position: relative;

    min-height: 115px;

    padding: 21px 20px;

    border-right: 1px solid #E8EDEA;
}

.summary-item:last-child {
    border-right: none;
}

.summary-icon {
    position: absolute;

    top: 18px;
    right: 18px;

    width: 35px;
    height: 35px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #EAF5EE;

    border-radius: 9px;

    color: #3E9B68;

    font-size: 10px;
    font-weight: 800;
}

.summary-label {
    margin-bottom: 10px;

    color: #7B877F;

    font-size: 10px;
    font-weight: 600;
}

.summary-value {
    padding-right: 40px;

    color: #203B2C;

    font-size: 24px;
    font-weight: 700;

    line-height: 1;
}

.summary-unit {
    margin-top: 8px;

    color: #9AA39D;

    font-size: 10px;
}


/* =========================================================
   CHART
========================================================= */

.chart-container {
    position: relative;

    height: 300px;

    padding: 18px 22px 22px;
}


/* =========================================================
   DATA HEADER
========================================================= */

.data-header {
    padding: 17px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    border-bottom: 1px solid #E8EDE9;
}

.data-title-wrap {
    display: flex;
    align-items: center;

    gap: 10px;
}

.data-title {
    margin: 0 0 3px;

    color: #203B2C;

    font-size: 13px;
    font-weight: 700;
}

.data-subtitle {
    color: #89958E;

    font-size: 10px;
}

.data-count {
    padding: 6px 10px;

    background: #EEF7F1;

    border-radius: 20px;

    color: #43805C;

    font-size: 9px;
    font-weight: 800;
}


/* =========================================================
   FILTER
========================================================= */

.filter-area {
    padding: 15px 20px;

    background: #FBFCFB;

    border-bottom: 1px solid #E8EDE9;
}

.filter-form {
    display: grid;

    grid-template-columns:
        210px
        minmax(260px, 1fr)
        auto;

    gap: 10px;

    align-items: end;
}

.form-group label {
    display: block;

    margin-bottom: 6px;

    color: #738078;

    font-size: 9px;
    font-weight: 800;

    letter-spacing: .3px;
}

.form-control {
    width: 100%;
    height: 35px;

    padding: 0 11px;

    background: #FFFFFF;

    border: 1px solid #DCE5DF;
    border-radius: 7px;

    outline: none;

    color: #4D5D53;

    font-family: inherit;

    font-size: 10px;
}

.form-control:focus {
    border-color: #69BE8B;

    box-shadow:
        0 0 0 3px rgba(105, 190, 139, .10);
}

.filter-actions {
    display: flex;

    gap: 6px;
}

.btn {
    min-height: 35px;

    padding: 0 12px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 5px;

    border: 1px solid transparent;
    border-radius: 7px;

    cursor: pointer;

    text-decoration: none;

    font-family: inherit;

    font-size: 10px;
    font-weight: 700;

    transition: .18s;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-primary {
    background: #3E9B68;

    border-color: #3E9B68;

    color: #FFFFFF;
}

.btn-primary:hover {
    background: #34875B;
}

.btn-secondary {
    background: #FFFFFF;

    border-color: #DCE5DF;

    color: #5D6B62;
}

.btn-secondary:hover {
    background: #F5F8F6;
}


/* =========================================================
   TABLE INFO
========================================================= */

.table-info {
    padding: 11px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    color: #89958E;

    font-size: 10px;
}


/* =========================================================
   TABLE
========================================================= */

.table-wrapper {
    overflow-x: auto;

    border-top: 1px solid #E8EDEA;
}

.data-table {
    width: 100%;

    min-width: 980px;

    border-collapse: collapse;
}

.data-table th {
    padding: 11px 12px;

    background: #F2F7F3;

    border-bottom: 1px solid #DDE7E0;

    color: #53675B;

    font-size: 9px;
    font-weight: 800;

    text-align: left;

    text-transform: uppercase;

    letter-spacing: .3px;

    white-space: nowrap;
}

.data-table td {
    padding: 12px;

    border-bottom: 1px solid #EDF1EE;

    color: #59675E;

    font-size: 10px;

    vertical-align: middle;
}

.data-table tbody tr:nth-child(even) {
    background: #FCFDFC;
}

.data-table tbody tr:hover {
    background: #F5FAF7;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.name-value {
    color: #294637;

    font-weight: 700;
}

.area-value {
    color: #347A55;

    font-weight: 700;

    white-space: nowrap;
}

.type-badge {
    display: inline-flex;

    padding: 5px 8px;

    background: #EAF5EE;

    border-radius: 20px;

    color: #397D55;

    font-size: 9px;
    font-weight: 700;

    white-space: nowrap;
}

.action-group {
    display: flex;
    align-items: center;

    gap: 5px;

    white-space: nowrap;
}

.action-detail {
    height: 27px;

    padding: 0 9px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    background: #EAF5EE;

    border: 1px solid #D6E9DC;
    border-radius: 6px;

    color: #347A55;

    text-decoration: none;

    font-size: 9px;
    font-weight: 700;

    transition: .15s;
}

.action-detail:hover {
    background: #DCEFE3;

    transform: translateY(-1px);
}

.empty-data {
    padding: 40px !important;

    color: #929D96 !important;

    text-align: center;
}


/* =========================================================
   RESPONSIVE
========================================================= */

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

    .filter-form {
        grid-template-columns: 1fr 1fr;
    }

    .filter-actions {
        grid-column: 1 / -1;
    }
}

@media(max-width: 750px) {

    .dashboard-hero {
        min-height: auto;

        padding: 28px 23px;
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

        margin-top: 18px;
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

    .filter-form {
        grid-template-columns: 1fr;
    }

    .filter-actions {
        grid-column: auto;
    }

    .data-header {
        flex-direction: column;

        align-items: flex-start;
    }

    .chart-container {
        height: 270px;

        padding: 15px;
    }

    .hero-description {
        font-size: 12px;
    }
}

</style>

@endsection


@section('content')

{{-- =========================================================
     SUCCESS
========================================================= --}}

@if(session('success'))

    <div class="page-alert">

        <div class="page-alert-icon">
            ✓
        </div>

        <div>
            {{ session('success') }}
        </div>

    </div>

@endif


{{-- =========================================================
     HERO
========================================================= --}}

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
            Data Kawasan Hutan Malang Selatan
        </h2>


        <p class="hero-description">

            Informasi kawasan hutan berdasarkan lokasi,
            jenis kawasan, luas wilayah, dan data pendukung
            kehutanan di Malang Selatan.

        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                KH
            </div>

            <div>

                <div class="hero-summary-title">
                    Data Kawasan Hutan
                </div>

                <div class="hero-summary-text">

                    Informasi kawasan hutan yang tersedia
                    dalam sistem informasi Malang Selatan.

                </div>

            </div>

        </div>

    </div>


    <div class="hero-status">

        <span></span>

        <div>

            <strong>
                Data Tersedia
            </strong>

            <small>
                {{ $totalKawasan }} data kawasan
            </small>

        </div>

    </div>

</section>


{{-- =========================================================
     RINGKASAN
========================================================= --}}

<section class="dashboard-panel">

    <div class="panel-header">

        <div class="panel-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Ringkasan Kawasan Hutan
                </h3>

                <div class="panel-subtitle">
                    Informasi utama data kehutanan Malang Selatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            INFORMASI PUBLIK
        </div>

    </div>


    <div class="summary-grid">


        <div class="summary-item">

            <div class="summary-icon">
                KH
            </div>

            <div class="summary-label">
                Total Kawasan
            </div>

            <div class="summary-value">
                {{ $totalKawasan }}
            </div>

            <div class="summary-unit">
                Data kawasan
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon">
                Ha
            </div>

            <div class="summary-label">
                Total Luas
            </div>

            <div class="summary-value">
                {{ number_format($totalLuas, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon">
                K
            </div>

            <div class="summary-label">
                Jumlah Kecamatan
            </div>

            <div class="summary-value">
                {{ $jumlahKecamatan }}
            </div>

            <div class="summary-unit">
                Kecamatan
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon">
                JK
            </div>

            <div class="summary-label">
                Jenis Kawasan
            </div>

            <div class="summary-value">
                {{ $jumlahJenisKawasan }}
            </div>

            <div class="summary-unit">
                Jenis kawasan
            </div>

        </div>


    </div>

</section>


{{-- =========================================================
     GRAFIK
========================================================= --}}

<section class="dashboard-panel">

    <div class="panel-header">

        <div class="panel-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Luas Kawasan per Kecamatan
                </h3>

                <div class="panel-subtitle">
                    Perbandingan luas kawasan hutan berdasarkan kecamatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            HEKTARE (HA)
        </div>

    </div>


    <div class="chart-container">

        <canvas id="grafikKecamatan"></canvas>

    </div>

</section>


{{-- =========================================================
     DATA PUBLIK
========================================================= --}}

<section class="dashboard-panel">


    {{-- DATA HEADER --}}

    <div class="data-header">

        <div class="data-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="data-title">
                    Data Kawasan Hutan
                </h3>

                <div class="data-subtitle">
                    Daftar kawasan hutan Malang Selatan
                </div>

            </div>

        </div>


        <div class="data-count">
            {{ $kawasanHutans->count() }} DATA
        </div>

    </div>


    {{-- FILTER --}}

    <div class="filter-area">

        <form
            action="{{ route('kawasan-hutan.index') }}"
            method="GET"
            class="filter-form"
        >


            <div class="form-group">

                <label>
                    KECAMATAN
                </label>

                <select
                    name="kecamatan"
                    class="form-control"
                >

                    <option value="">
                        Semua Kecamatan
                    </option>


                    @foreach($daftarKecamatan as $kecamatan)

                        <option
                            value="{{ $kecamatan }}"
                            {{ request('kecamatan') == $kecamatan ? 'selected' : '' }}
                        >

                            {{ $kecamatan }}

                        </option>

                    @endforeach

                </select>

            </div>


            <div class="form-group">

                <label>
                    PENCARIAN DATA
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Cari nama kawasan, desa atau kecamatan..."
                >

            </div>


            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Cari Data
                </button>


                <a
                    href="{{ route('kawasan-hutan.index') }}"
                    class="btn btn-secondary"
                >
                    Reset
                </a>

            </div>


        </form>

    </div>


    {{-- TABLE INFO --}}

    <div class="table-info">

        <span>
            Daftar kawasan hutan yang tersedia untuk publik
        </span>


        <span class="data-count">
            {{ $kawasanHutans->count() }} DATA
        </span>

    </div>


    {{-- TABLE --}}

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Kabupaten
                    </th>

                    <th>
                        Kecamatan
                    </th>

                    <th>
                        Desa
                    </th>

                    <th>
                        Nama Kawasan
                    </th>

                    <th>
                        Jenis Kawasan
                    </th>

                    <th>
                        Luas
                    </th>

                    <th>
                        Keterangan
                    </th>

                    <th>
                        Detail
                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($kawasanHutans as $data)

                    <tr>


                        <td>
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            {{ $data->kabupaten }}
                        </td>


                        <td>
                            {{ $data->kecamatan }}
                        </td>


                        <td>
                            {{ $data->desa ?? '-' }}
                        </td>


                        <td>

                            <span class="name-value">
                                {{ $data->nama_kawasan }}
                            </span>

                        </td>


                        <td>

                            <span class="type-badge">
                                {{ $data->jenis_kawasan }}
                            </span>

                        </td>


                        <td>

                            <span class="area-value">

                                {{ number_format($data->luas_ha, 2, ',', '.') }}

                                Ha

                            </span>

                        </td>


                        <td>
                            {{ $data->keterangan ?? '-' }}
                        </td>


                        <td>

                            <div class="action-group">

                                <a
                                    href="{{ route('kawasan-hutan.show', $data->id) }}"
                                    class="action-detail"
                                >
                                    Detail
                                </a>

                            </div>

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="empty-data"
                        >

                            Belum ada data kawasan hutan.

                        </td>

                    </tr>

                @endforelse


            </tbody>

        </table>

    </div>


</section>

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
    document.getElementById('grafikKecamatan');


if (ctx) {

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($labelGrafik),

            datasets: [{

                label: 'Luas Kawasan (Ha)',

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