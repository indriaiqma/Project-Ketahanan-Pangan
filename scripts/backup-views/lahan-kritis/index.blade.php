@extends('layouts.viewer')

@section('title', 'Lahan Kritis')

@section('heading', 'Data Lahan Kritis Malang Selatan')

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
    box-shadow: 0 8px 28px rgba(37,107,74,0.06);
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
    background: rgba(255,255,255,0.86);
    border: 1px solid #DFEAE3;
    border-radius: 30px;
    box-shadow: 0 5px 16px rgba(37,107,74,0.06);
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


/* =========================================================
   HERO DECORATION
========================================================= */

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
    background: rgba(92,174,126,0.13);
    transform: rotate(-7deg);
}

.hero-decoration-two {
    width: 330px;
    height: 170px;
    right: 120px;
    bottom: -115px;
    border-radius: 55% 55% 0 0;
    background: rgba(121,194,151,0.11);
    transform: rotate(7deg);
}

.hero-decoration-three {
    width: 230px;
    height: 230px;
    right: 40px;
    top: 70px;
    border-radius: 50%;
    background: rgba(105,190,139,0.07);
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
    overflow: hidden;
    background: #FFFFFF;
    border: 1px solid #E1E9E4;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(32,59,44,0.035);
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
    border-radius: 10px;
    background: #3E9B68;
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
    white-space: nowrap;
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
    border-radius: 9px;
    background: #EAF5EE;
    color: #3E9B68;
    font-size: 10px;
    font-weight: 800;
}

.summary-icon.critical {
    background: #FFF0EE;
    color: #C85C54;
}

.summary-icon.warning {
    background: #FFF6E8;
    color: #B77C25;
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

.data-actions {
    display: flex;
    align-items: center;
    gap: 7px;
    flex-wrap: wrap;
}


/* =========================================================
   BUTTONS
========================================================= */

.btn {
    min-height: 33px;
    padding: 0 11px;
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
        0 0 0 3px rgba(105,190,139,.10);
}

.filter-actions {
    display: flex;
    gap: 6px;
}


/* =========================================================
   IMPORT
========================================================= */

.import-area {
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    background: #F5FAF7;
    border-bottom: 1px solid #E8EDE9;
}

.import-title {
    margin-bottom: 2px;
    color: #3D5546;
    font-size: 10px;
    font-weight: 700;
}

.import-description {
    color: #8C9790;
    font-size: 9px;
}

.import-form {
    display: flex;
    align-items: center;
    gap: 7px;
}

.file-control {
    max-width: 270px;
    padding: 6px;
    background: #FFFFFF;
    border: 1px solid #DCE5DF;
    border-radius: 7px;
    color: #748078;
    font-size: 9px;
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

.data-count {
    padding: 5px 9px;
    background: #EEF7F1;
    border-radius: 20px;
    color: #43805C;
    font-size: 9px;
    font-weight: 800;
}


/* =========================================================
   TABLE
========================================================= */

.table-wrapper {
    width: 100%;
    overflow-x: auto;
    border-top: 1px solid #E8EDEA;
}

.data-table {
    width: 100%;
    min-width: 1650px;
    border-collapse: collapse;
}

.data-table th {
    padding: 10px 9px;
    background: #F2F7F3;
    border-right: 1px solid #E3EAE5;
    border-bottom: 1px solid #DDE7E0;
    color: #53675B;
    font-size: 9px;
    font-weight: 800;
    text-align: center;
    white-space: nowrap;
}

.data-table th:last-child {
    border-right: none;
}

.data-table .group-header {
    background: #E7F2EA;
    color: #347A55;
    font-size: 9px;
    letter-spacing: .3px;
}

.data-table td {
    padding: 11px 9px;
    border-right: 1px solid #F0F2F0;
    border-bottom: 1px solid #EDF1EE;
    color: #59675E;
    font-size: 10px;
    text-align: center;
    vertical-align: middle;
}

.data-table td:last-child {
    border-right: none;
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

.kecamatan {
    color: #294637 !important;
    font-weight: 700;
    text-align: left !important;
    white-space: nowrap;
}

.angka-ha {
    white-space: nowrap;
}

.total-ha {
    color: #347A55 !important;
    font-weight: 800;
    white-space: nowrap;
}


/* =========================================================
   ACTION BUTTONS
========================================================= */

.action-group {
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.action-group form {
    margin: 0;
}

.action-btn {
    height: 27px;
    padding: 0 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid transparent;
    border-radius: 6px;
    cursor: pointer;
    text-decoration: none;
    font-family: inherit;
    font-size: 9px;
    font-weight: 700;
    transition: .15s;
}

.action-btn:hover {
    transform: translateY(-1px);
}

.action-detail {
    background: #EAF5EE;
    border-color: #D6E9DC;
    color: #347A55;
}

.action-edit {
    background: #FFF7E9;
    border-color: #F0DFC1;
    color: #A97121;
}

.action-delete {
    background: #FFF2F1;
    border-color: #F0D6D3;
    color: #B54B47;
}

.empty-data {
    padding: 40px !important;
    color: #929D96 !important;
    text-align: center !important;
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

    .hero-description {
        font-size: 12px;
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

    .data-header,
    .import-area {
        flex-direction: column;
        align-items: flex-start;
    }

    .import-form {
        width: 100%;
        flex-wrap: wrap;
    }

    .chart-container {
        height: 270px;
        padding: 15px;
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
            Data Lahan Kritis Malang Selatan
        </h2>


        <p class="hero-description">

            Informasi kondisi lahan kritis berdasarkan kecamatan
            serta kategori tingkat kekritisan lahan di dalam dan
            di luar kawasan hutan Malang Selatan.

        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                LK
            </div>

            <div>

                <div class="hero-summary-title">
                    Data Lahan Kritis
                </div>

                <div class="hero-summary-text">

                    Informasi kondisi dan tingkat kekritisan
                    lahan yang tersimpan dalam sistem.

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
                {{ $jumlahKecamatan }} kecamatan
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
                    Ringkasan Lahan Kritis
                </h3>

                <div class="panel-subtitle">
                    Informasi utama kondisi lahan kritis Malang Selatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            LAHAN KRITIS
        </div>

    </div>


    <div class="summary-grid">


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
                Ha
            </div>

            <div class="summary-label">
                Total Luas Lahan
            </div>

            <div class="summary-value">
                {{ number_format($totalLahan, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon critical">
                !
            </div>

            <div class="summary-label">
                Total Sangat Kritis
            </div>

            <div class="summary-value">
                {{ number_format($totalSangatKritis, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon warning">
                !
            </div>

            <div class="summary-label">
                Total Kritis
            </div>

            <div class="summary-value">
                {{ number_format($totalKritis, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
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
                    Total Lahan per Kecamatan
                </h3>

                <div class="panel-subtitle">
                    Perbandingan total luas lahan berdasarkan kecamatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            HEKTARE (HA)
        </div>

    </div>


    <div class="chart-container">

        <canvas id="grafikLahanKritis"></canvas>

    </div>

</section>


{{-- =========================================================
     DATA LAHAN KRITIS
========================================================= --}}

<section class="dashboard-panel">


    {{-- HEADER --}}

    <div class="data-header">

        <div class="data-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="data-title">
                    Data Lahan Kritis
                </h3>

                <div class="data-subtitle">
                    Data kondisi lahan berdasarkan kategori tingkat kekritisan
                </div>

            </div>

        </div>


        {{-- KHUSUS ADMIN --}}

        @if(auth()->check() && auth()->user()->role === 'admin')

        <div class="data-actions">

            <a
                href="/lahan-kritis/tambah"
                class="btn btn-primary"
            >
                + Tambah Data
            </a>


            <a
                href="/lahan-kritis/export"
                class="btn btn-secondary"
            >
                Export Excel
            </a>

        </div>

        @endif

    </div>


    {{-- =====================================================
         FILTER
    ===================================================== --}}

    <div class="filter-area">

        <form
            action="/lahan-kritis"
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
                    placeholder="Cari kabupaten atau kecamatan..."
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
                    href="/lahan-kritis"
                    class="btn btn-secondary"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- =====================================================
         IMPORT EXCEL - KHUSUS ADMIN
    ===================================================== --}}

    @if(auth()->check() && auth()->user()->role === 'admin')

    <div class="import-area">

        <div>

            <div class="import-title">
                Import Data Excel
            </div>

            <div class="import-description">
                Gunakan file .xlsx, .xls atau .csv
            </div>

        </div>


        <form
            action="/lahan-kritis/import"
            method="POST"
            enctype="multipart/form-data"
            class="import-form"
        >

            @csrf


            <input
                type="file"
                name="file"
                accept=".xlsx,.xls,.csv"
                required
                class="file-control"
            >


            <button
                type="submit"
                class="btn btn-primary"
            >
                Import Excel
            </button>

        </form>

    </div>

    @endif


    {{-- =====================================================
         TABLE INFO
    ===================================================== --}}

    <div class="table-info">

        <span>
            Daftar data lahan kritis yang tersedia
        </span>


        <span class="data-count">

            {{ $lahanKritis->count() }} DATA

        </span>

    </div>


    {{-- =====================================================
         TABLE
    ===================================================== --}}

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>

                    <th rowspan="2">
                        No
                    </th>

                    <th rowspan="2">
                        Kabupaten
                    </th>

                    <th rowspan="2">
                        Kecamatan
                    </th>


                    <th
                        colspan="5"
                        class="group-header"
                    >
                        Dalam Kawasan
                    </th>


                    <th
                        colspan="5"
                        class="group-header"
                    >
                        Luar Kawasan
                    </th>


                    <th rowspan="2">
                        Total (Ha)
                    </th>


                    <th rowspan="2">
                        Aksi
                    </th>

                </tr>


                <tr>

                    <th>
                        Sangat Kritis
                    </th>

                    <th>
                        Kritis
                    </th>

                    <th>
                        Agak Kritis
                    </th>

                    <th>
                        Potensial Kritis
                    </th>

                    <th>
                        Tidak Kritis
                    </th>


                    <th>
                        Sangat Kritis
                    </th>

                    <th>
                        Kritis
                    </th>

                    <th>
                        Agak Kritis
                    </th>

                    <th>
                        Potensial Kritis
                    </th>

                    <th>
                        Tidak Kritis
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($lahanKritis as $data)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td>
                        {{ $data->kabupaten }}
                    </td>


                    <td class="kecamatan">
                        {{ $data->kecamatan }}
                    </td>


                    {{-- DALAM KAWASAN --}}

                    <td class="angka-ha">
                        {{ number_format($data->dalam_sangat_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_agak_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_potensial_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_tidak_kritis, 2, ',', '.') }}
                    </td>


                    {{-- LUAR KAWASAN --}}

                    <td class="angka-ha">
                        {{ number_format($data->luar_sangat_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_agak_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_potensial_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_tidak_kritis, 2, ',', '.') }}
                    </td>


                    {{-- TOTAL --}}

                    <td class="total-ha">
                        {{ number_format($data->total_ha, 2, ',', '.') }}
                    </td>


                    {{-- AKSI --}}

                    <td>

                        <div class="action-group">


                            {{-- DETAIL
                                 BISA DIAKSES PUBLIK --}}

                            <a
                                href="/lahan-kritis/{{ $data->id }}"
                                class="action-btn action-detail"
                            >
                                Detail
                            </a>


                            {{-- EDIT & HAPUS
                                 KHUSUS ADMIN --}}

                            @if(auth()->check() && auth()->user()->role === 'admin')


                            <a
                                href="/lahan-kritis/{{ $data->id }}/edit"
                                class="action-btn action-edit"
                            >
                                Edit
                            </a>


                            <form
                                action="/lahan-kritis/{{ $data->id }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="action-btn action-delete"
                                >
                                    Hapus
                                </button>

                            </form>


                            @endif

                        </div>

                    </td>

                </tr>


                @empty


                <tr>

                    <td
                        colspan="15"
                        class="empty-data"
                    >
                        Belum ada data lahan kritis.
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
    document.getElementById('grafikLahanKritis');


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