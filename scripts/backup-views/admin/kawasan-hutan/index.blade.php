@extends('layouts.app')

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

    background: rgba(255, 255, 255, 0.94);

    border: 1px solid #DFEAE3;

    border-radius: 30px;

    box-shadow:
        0 5px 16px rgba(37, 107, 74, 0.06);
}


.hero-status > span {
    width: 8px;
    height: 8px;

    flex-shrink: 0;

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

    flex-shrink: 0;

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
    flex-shrink: 0;

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

    grid-template-columns:
        repeat(4, minmax(0, 1fr));
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

    width: 100%;
    height: 320px;

    padding: 18px 22px 22px;
}


.chart-container canvas {
    display: block;

    width: 100% !important;
    height: 100% !important;
}


/* =========================================================
   DATA HEADER
========================================================= */

.data-header {
    min-height: 60px;

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
   BUTTON
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


.form-group {
    min-width: 0;
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

    flex-wrap: wrap;
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

    min-width: 1080px;

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


/* =========================================================
   ACTION
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

    text-align: center;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 1000px) {

    .summary-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }


    .summary-item:nth-child(2) {
        border-right: none;
    }


    .summary-item:nth-child(1),
    .summary-item:nth-child(2) {
        border-bottom: 1px solid #E8EDEA;
    }


    .filter-form {
        grid-template-columns:
            1fr 1fr;
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

        border-bottom: 1px solid #E8EDE9;
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


    .hero-description {
        font-size: 12px;
    }

}


@media(max-width: 500px) {

    .dashboard-hero {
        padding: 23px 17px;
    }


    .dashboard-hero h2 {
        font-size: 22px;
    }


    .hero-summary {
        width: 100%;
    }


    .panel-header {
        padding: 14px;
    }


    .summary-item {
        padding: 18px;
    }


    .data-header {
        padding: 15px;
    }


    .filter-area,
    .import-area,
    .table-info {
        padding-left: 15px;
        padding-right: 15px;
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

            Informasi dan pengelolaan data kawasan hutan berdasarkan
            lokasi, jenis kawasan, luas wilayah, dan data pendukung
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

                    Informasi kawasan hutan yang tersimpan
                    dan dikelola melalui sistem.

                </div>

            </div>

        </div>


    </div>


    <div class="hero-status">

        <span></span>

        <div>

            <strong>
                Mode Administrator
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
            ADMINISTRATOR
        </div>


    </div>



    <div class="summary-grid">


        {{-- TOTAL KAWASAN --}}

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



        {{-- TOTAL LUAS --}}

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



        {{-- JUMLAH KECAMATAN --}}

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



        {{-- JENIS KAWASAN --}}

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
     DATA KAWASAN HUTAN
========================================================= --}}

<section class="dashboard-panel">


    {{-- HEADER --}}

    <div class="data-header">


        <div class="data-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="data-title">
                    Data Kawasan Hutan
                </h3>

                <div class="data-subtitle">
                    Kelola data kawasan hutan Malang Selatan
                </div>

            </div>

        </div>


        <div class="data-actions">


            <a
                href="{{ route('admin.kawasan-hutan.create') }}"
                class="btn btn-primary"
            >
                + Tambah Data
            </a>


            <a
                href="{{ route('admin.kawasan-hutan.export') }}"
                class="btn btn-secondary"
            >
                Export Excel
            </a>


        </div>


    </div>



    {{-- FILTER --}}

    <div class="filter-area">


        <form
            action="{{ route('admin.kawasan-hutan.index') }}"
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
                    href="{{ route('admin.kawasan-hutan.index') }}"
                    class="btn btn-secondary"
                >
                    Reset
                </a>


            </div>


        </form>


    </div>



    {{-- IMPORT --}}

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
            action="{{ route('admin.kawasan-hutan.import') }}"
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



    {{-- TABLE INFO --}}

    <div class="table-info">


        <span>
            Daftar kawasan hutan yang tersedia
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
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($kawasanHutans as $index => $kawasan)


                    <tr>


                        {{-- NO --}}

                        <td>
                            {{ $index + 1 }}
                        </td>


                        {{-- KABUPATEN --}}

                        <td>
                            {{ $kawasan->kabupaten ?? '-' }}
                        </td>


                        {{-- KECAMATAN --}}

                        <td>
                            {{ $kawasan->kecamatan ?? '-' }}
                        </td>


                        {{-- DESA --}}

                        <td>
                            {{ $kawasan->desa ?? '-' }}
                        </td>


                        {{-- NAMA KAWASAN --}}

                        <td>

                            <span class="name-value">

                                {{ $kawasan->nama_kawasan ?? '-' }}

                            </span>

                        </td>


                        {{-- JENIS KAWASAN --}}

                        <td>

                            <span class="type-badge">

                                {{ $kawasan->jenis_kawasan ?? '-' }}

                            </span>

                        </td>


                        {{-- LUAS --}}

                        <td>

                            <span class="area-value">

                                {{ number_format((float) ($kawasan->luas_ha ?? 0), 2, ',', '.') }}

                                Ha

                            </span>

                        </td>


                        {{-- KETERANGAN --}}

                        <td>

                            {{ $kawasan->keterangan ?? '-' }}

                        </td>


                        {{-- AKSI --}}

                        <td>


                            <div class="action-group">


                                {{-- EDIT --}}

                                <a
                                    href="{{ route('admin.kawasan-hutan.edit', $kawasan->id) }}"
                                    class="action-btn action-edit"
                                >
                                    Edit
                                </a>


                                {{-- HAPUS --}}

                                <form
                                    action="{{ route('admin.kawasan-hutan.destroy', $kawasan->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data kawasan hutan ini?')"
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



{{-- =========================================================
     CHART.JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {


    const canvas =
        document.getElementById('grafikKecamatan');


    if (!canvas) {

        return;

    }


    /*
     * DATA GRAFIK DARI CONTROLLER
     *
     * Controller kamu sudah menyediakan:
     *
     * $labelGrafik
     * $dataGrafik
     *
     * Jadi kita langsung menggunakan data tersebut.
     */

    const labels =
        @json($labelGrafik);


    const values =
        @json($dataGrafik);



    /*
     * Pastikan hasil JSON berupa array.
     */

    const chartLabels =
        Array.isArray(labels)
            ? labels
            : Object.values(labels);


    const chartValues =
        Array.isArray(values)
            ? values
            : Object.values(values);



    /*
     * Kalau tidak ada data.
     */

    if (
        chartLabels.length === 0 ||
        chartValues.length === 0
    ) {

        const container =
            canvas.parentElement;


        container.innerHTML = `

            <div style="
                width:100%;
                height:100%;
                display:flex;
                align-items:center;
                justify-content:center;
                color:#89958E;
                font-size:12px;
            ">

                Belum ada data kawasan hutan
                untuk ditampilkan.

            </div>

        `;

        return;

    }



    /*
     * Buat grafik.
     */

    new Chart(canvas, {

        type: 'bar',


        data: {

            labels: chartLabels,


            datasets: [

                {

                    label: 'Luas Kawasan (Ha)',


                    data: chartValues,


                    backgroundColor:
                        'rgba(62, 155, 104, 0.78)',


                    borderColor:
                        '#3E9B68',


                    borderWidth: 1,


                    borderRadius: 7,


                    borderSkipped: false,


                    maxBarThickness: 60

                }

            ]

        },


        options: {

            responsive: true,


            maintainAspectRatio: false,


            animation: {

                duration: 700

            },


            plugins: {

                legend: {

                    display: false

                },


                tooltip: {

                    backgroundColor:
                        '#203B2C',


                    titleColor:
                        '#FFFFFF',


                    bodyColor:
                        '#FFFFFF',


                    padding: 10,


                    displayColors: false,


                    callbacks: {

                        label: function(context) {


                            const value =
                                Number(context.raw || 0);


                            return 'Luas: ' +

                                value.toLocaleString(
                                    'id-ID',
                                    {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }
                                ) +

                                ' Ha';

                        }

                    }

                }

            },


            scales: {

                x: {

                    grid: {

                        display: false

                    },


                    border: {

                        display: false

                    },


                    ticks: {

                        color:
                            '#718078',


                        font: {

                            size: 10,

                            weight: '600'

                        },


                        maxRotation: 0,

                        minRotation: 0

                    }

                },


                y: {

                    beginAtZero: true,


                    border: {

                        display: false

                    },


                    grid: {

                        color:
                            'rgba(65, 105, 80, 0.08)'

                    },


                    ticks: {

                        color:
                            '#89958E',


                        font: {

                            size: 9

                        },


                        callback:
                            function(value) {

                                return Number(value)
                                    .toLocaleString(
                                        'id-ID'
                                    );

                            }

                    },


                    title: {

                        display: true,


                        text:
                            'Luas (Hektare)',


                        color:
                            '#718078',


                        font: {

                            size: 10,

                            weight: '600'

                        }

                    }

                }

            }

        }

    });


});

</script>


@endsection