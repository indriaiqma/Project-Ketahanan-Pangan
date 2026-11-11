@extends('layouts.app')

@section('title', 'SDM')
@section('heading', 'Data SDM Malang Selatan')
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
    justify-content: space-between;

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


/* =========================================================
   HERO CONTENT
========================================================= */

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


/* =========================================================
   HERO SUMMARY
========================================================= */

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
    font-weight: 800;
}

.hero-summary-text {
    color: #7A887F;
    font-size: 10px;
    line-height: 1.5;
}


/* =========================================================
   HERO STATUS
========================================================= */

.hero-status {
    position: relative;
    z-index: 3;

    min-width: 175px;

    padding: 14px 16px;

    display: flex;
    align-items: center;
    gap: 10px;

    background: #F8FBF9;
    border: 1px solid #E0EAE3;
    border-radius: 11px;
}

.hero-status > span {
    width: 9px;
    height: 9px;
    min-width: 9px;

    display: block;

    border-radius: 50%;

    background: #D5A62A;
    box-shadow: 0 0 0 4px rgba(213, 166, 42, 0.10);
}

.hero-status strong {
    display: block;

    margin-bottom: 3px;

    color: #52645A;
    font-size: 10px;
    font-weight: 800;
}

.hero-status small {
    color: #9AA59E;
    font-size: 9px;
}


/* =========================================================
   HERO DECORATION
========================================================= */

.hero-decoration {
    position: absolute;
    z-index: 1;

    border-radius: 50%;

    pointer-events: none;
}

.hero-decoration-one {
    width: 190px;
    height: 190px;

    top: -105px;
    right: -45px;

    background: rgba(62, 155, 104, 0.055);
}

.hero-decoration-two {
    width: 135px;
    height: 135px;

    right: 190px;
    bottom: -85px;

    background: rgba(62, 155, 104, 0.045);
}

.hero-decoration-three {
    width: 80px;
    height: 80px;

    right: 90px;
    top: 55px;

    border: 1px solid rgba(62, 155, 104, 0.08);
}


/* =========================================================
   DATA PANEL
========================================================= */

.dashboard-panel {
    position: relative;

    margin-bottom: 22px;

    background: #FFFFFF;

    border: 1px solid #E1EAE4;
    border-radius: 16px;

    overflow: hidden;

    box-shadow:
        0 7px 25px rgba(37, 107, 74, 0.045);
}


/* =========================================================
   PANEL HEADER
========================================================= */

.panel-header {
    min-height: 65px;

    padding: 15px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    border-bottom: 1px solid #E8EDE9;
}

.panel-title-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}

.panel-mark {
    width: 7px;
    height: 28px;

    display: inline-block;

    border-radius: 8px;

    background: #3E9B68;
}

.panel-title {
    margin: 0 0 3px;

    color: #203B2C;
    font-size: 14px;
    font-weight: 750;
}

.panel-subtitle {
    color: #89958E;
    font-size: 10px;
}

.panel-badge {
    padding: 7px 10px;

    border-radius: 7px;

    background: #EEF7F1;
    border: 1px solid #DDEBE2;

    color: #347A55;

    font-size: 9px;
    font-weight: 800;
    letter-spacing: .4px;
}


/* =========================================================
   EMPTY DATA
========================================================= */

.empty-data {
    min-height: 275px;

    padding: 55px 25px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    text-align: center;
}

.empty-icon {
    width: 68px;
    height: 68px;

    margin-bottom: 17px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #EAF5EE;
    border: 1px solid #DCEBE1;

    color: #3E9B68;

    font-size: 16px;
    font-weight: 800;
}

.empty-data h3 {
    margin: 0 0 8px;

    color: #294637;

    font-size: 16px;
    font-weight: 750;
}

.empty-data p {
    max-width: 560px;

    margin: 0;

    color: #89958E;

    font-size: 11px;
    line-height: 1.7;
}


/* =========================================================
   INFO ROW
========================================================= */

.info-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);

    border-top: 1px solid #E8EDE9;
}

.info-item {
    min-height: 65px;

    padding: 15px 20px;

    border-right: 1px solid #E8EDE9;
}

.info-item:last-child {
    border-right: none;
}

.info-label {
    display: block;

    margin-bottom: 5px;

    color: #9AA39D;

    font-size: 9px;
    font-weight: 800;
    letter-spacing: .7px;
}

.info-value {
    color: #53675B;

    font-size: 11px;
    font-weight: 700;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .dashboard-hero {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }

    .hero-content {
        width: 100%;
    }

    .hero-status {
        width: 100%;
        box-sizing: border-box;
    }

    .info-row {
        grid-template-columns: 1fr;
    }

    .info-item {
        border-right: none;
        border-bottom: 1px solid #E8EDE9;
    }

    .info-item:last-child {
        border-bottom: none;
    }
}


@media (max-width: 600px) {

    .dashboard-hero {
        min-height: auto;

        padding: 28px 22px;
    }

    .dashboard-hero h2 {
        font-size: 24px;
    }

    .hero-description {
        font-size: 12px;
    }

    .hero-summary {
        width: 100%;
        box-sizing: border-box;
    }

    .panel-header {
        align-items: flex-start;
    }

    .empty-data {
        min-height: 240px;
        padding: 45px 20px;
    }
}

</style>

@endsection


@section('content')

{{-- =========================================================
     HERO
========================================================= --}}

<section class="dashboard-hero">

    {{-- DEKORASI --}}
    <div class="hero-decoration hero-decoration-one"></div>
    <div class="hero-decoration hero-decoration-two"></div>
    <div class="hero-decoration hero-decoration-three"></div>


    {{-- HERO CONTENT --}}
    <div class="hero-content">

        <div class="hero-label">

            <span class="hero-label-line"></span>

            SISTEM INFORMASI KETAHANAN PANGAN

        </div>


        <h2>
            Data SDM Malang Selatan
        </h2>


        <p class="hero-description">
            Modul informasi sumber daya manusia sebagai bagian dari
            Sistem Informasi Ketahanan Pangan Malang Selatan.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                SDM
            </div>

            <div>

                <div class="hero-summary-title">
                    Sumber Daya Manusia
                </div>

                <div class="hero-summary-text">
                    Modul informasi sumber daya manusia untuk mendukung
                    pengelolaan data wilayah Malang Selatan.
                </div>

            </div>

        </div>

    </div>


    {{-- STATUS --}}
    <div class="hero-status">

        <span></span>

        <div>

            <strong>
                Menunggu Data
            </strong>

            <small>
                Data belum tersedia
            </small>

        </div>

    </div>

</section>



{{-- =========================================================
     DATA SDM
========================================================= --}}

<section class="dashboard-panel">

    {{-- HEADER --}}
    <div class="panel-header">

        <div class="panel-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Data Sumber Daya Manusia
                </h3>

                <div class="panel-subtitle">
                    Informasi SDM wilayah Malang Selatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            SDM
        </div>

    </div>


    {{-- EMPTY STATE --}}
    <div class="empty-data">

        <div class="empty-icon">
            SDM
        </div>


        <h3>
            Data Sumber Daya Manusia Belum Tersedia
        </h3>


        <p>
            Modul data sumber daya manusia telah disiapkan.
            Data akan ditampilkan setelah data resmi tersedia
            dan dimasukkan ke dalam sistem.
        </p>

    </div>


    {{-- INFO --}}
    <div class="info-row">

        <div class="info-item">

            <span class="info-label">
                MODUL
            </span>

            <span class="info-value">
                Sumber Daya Manusia
            </span>

        </div>


        <div class="info-item">

            <span class="info-label">
                WILAYAH
            </span>

            <span class="info-value">
                Malang Selatan
            </span>

        </div>


        <div class="info-item">

            <span class="info-label">
                STATUS
            </span>

            <span class="info-value">
                Menunggu Ketersediaan Data
            </span>

        </div>

    </div>

</section>

@endsection