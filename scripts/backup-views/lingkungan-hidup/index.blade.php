@extends('layouts.viewer')

@section('title', 'Lingkungan Hidup')

@section('heading', 'Data Lingkungan Hidup Malang Selatan')

@section('hidePageHeading', true)

@section('style')

<style>

/* =========================================================
   HERO
   SAMA DENGAN DASHBOARD, KAWASAN HUTAN & LAHAN KRITIS
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

    box-shadow: 0 8px 28px rgba(37,107,74,.06);
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

    background: rgba(234,245,238,.82);

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


/* =========================================================
   STATUS HERO
========================================================= */

.hero-status {
    position: absolute;
    z-index: 4;

    top: 25px;
    right: 27px;

    display: flex;
    align-items: center;
    gap: 9px;

    padding: 10px 14px;

    background: rgba(255,255,255,.86);

    border: 1px solid #DFEAE3;
    border-radius: 30px;

    box-shadow: 0 5px 16px rgba(37,107,74,.06);
}

.hero-status > span {
    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: #D8A545;
}

.hero-status strong {
    display: block;

    color: #5D604A;

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

    background: rgba(92,174,126,.13);

    transform: rotate(-7deg);
}

.hero-decoration-two {
    width: 330px;
    height: 170px;

    right: 120px;
    bottom: -115px;

    border-radius: 55% 55% 0 0;

    background: rgba(121,194,151,.11);

    transform: rotate(7deg);
}

.hero-decoration-three {
    width: 230px;
    height: 230px;

    right: 40px;
    top: 70px;

    border-radius: 50%;

    background: rgba(105,190,139,.07);
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

    box-shadow: 0 4px 16px rgba(32,59,44,.035);
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
}


/* =========================================================
   EMPTY / WAITING DATA
========================================================= */

.empty-content {
    min-height: 300px;

    padding: 45px 30px;

    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    text-align: center;
}

.empty-icon {
    position: relative;

    width: 72px;
    height: 72px;

    margin-bottom: 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #EAF5EE;

    border: 1px solid #DCECE2;

    color: #3E9B68;

    font-size: 19px;
    font-weight: 800;
}

.empty-icon::after {
    content: '';

    position: absolute;

    width: 88px;
    height: 88px;

    border: 1px solid #EEF5F0;
    border-radius: 50%;
}

.empty-content h3 {
    margin: 0 0 9px;

    color: #254633;

    font-size: 17px;
    font-weight: 700;
}

.empty-description {
    max-width: 570px;

    margin: 0;

    color: #7C8981;

    font-size: 11px;
    line-height: 1.8;
}


/* =========================================================
   STATUS DATA
========================================================= */

.data-status {
    width: 100%;
    max-width: 540px;

    margin-top: 24px;
    padding: 13px 15px;

    display: flex;
    align-items: center;

    gap: 12px;

    text-align: left;

    background: #FFF9ED;

    border: 1px solid #F1E5C7;
    border-radius: 9px;
}

.status-symbol {
    width: 34px;
    height: 34px;
    min-width: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #FFF1CF;

    color: #A77A24;

    font-size: 13px;
    font-weight: 800;
}

.data-status-title {
    margin-bottom: 3px;

    color: #806226;

    font-size: 10px;
    font-weight: 700;
}

.data-status-text {
    color: #93815A;

    font-size: 10px;
    line-height: 1.5;
}


/* =========================================================
   INFORMATION ROW
========================================================= */

.info-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
}

.info-item {
    min-height: 90px;

    padding: 18px 20px;

    border-right: 1px solid #E8EDEA;
}

.info-item:last-child {
    border-right: none;
}

.info-label {
    margin-bottom: 8px;

    color: #89958E;

    font-size: 9px;
    font-weight: 700;
}

.info-value {
    color: #304D3B;

    font-size: 11px;
    font-weight: 700;
    line-height: 1.5;
}


/* =========================================================
   RESPONSIVE
========================================================= */

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

    .empty-content {
        padding: 38px 20px;
    }

    .info-row {
        grid-template-columns: 1fr;
    }

    .info-item {
        border-right: none;
        border-bottom: 1px solid #E8EDEA;
    }

    .info-item:last-child {
        border-bottom: none;
    }

}

</style>

@endsection


@section('content')


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
            Data Lingkungan Hidup Malang Selatan
        </h2>


        <p class="hero-description">

            Modul informasi lingkungan hidup sebagai bagian dari
            Sistem Informasi Ketahanan Pangan Malang Selatan.

        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                LH
            </div>


            <div>

                <div class="hero-summary-title">
                    Lingkungan Hidup
                </div>


                <div class="hero-summary-text">

                    Informasi lingkungan hidup untuk mendukung
                    pengelolaan data wilayah Malang Selatan.

                </div>

            </div>

        </div>

    </div>


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
     STATUS MODUL
========================================================= --}}

<section class="dashboard-panel">

    <div class="panel-header">

        <div class="panel-title-wrap">

            <span class="panel-mark"></span>


            <div>

                <h3 class="panel-title">
                    Data Lingkungan Hidup
                </h3>


                <div class="panel-subtitle">

                    Informasi ketersediaan data pada modul
                    Lingkungan Hidup

                </div>

            </div>

        </div>


        <div class="panel-badge">
            LINGKUNGAN HIDUP
        </div>

    </div>


    <div class="empty-content">


        <div class="empty-icon">
            LH
        </div>


        <h3>
            Data Lingkungan Hidup Belum Tersedia
        </h3>


        <p class="empty-description">

            Modul Lingkungan Hidup telah disiapkan pada sistem.
            Data akan ditampilkan setelah data Lingkungan Hidup
            resmi tersedia dan siap digunakan.

        </p>


        <div class="data-status">


            <div class="status-symbol">
                !
            </div>


            <div>

                <div class="data-status-title">
                    Status Data
                </div>


                <div class="data-status-text">

                    Belum terdapat data Lingkungan Hidup yang
                    dimasukkan ke dalam sistem.

                </div>

            </div>

        </div>

    </div>


    <div class="info-row">


        <div class="info-item">

            <div class="info-label">
                MODUL
            </div>


            <div class="info-value">
                Lingkungan Hidup
            </div>

        </div>


        <div class="info-item">

            <div class="info-label">
                WILAYAH
            </div>


            <div class="info-value">
                Malang Selatan
            </div>

        </div>


        <div class="info-item">

            <div class="info-label">
                STATUS
            </div>


            <div class="info-value">
                Menunggu Ketersediaan Data
            </div>

        </div>

    </div>

</section>

@endsection