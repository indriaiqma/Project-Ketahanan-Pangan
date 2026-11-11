@extends('layouts.viewer')

@section('title', 'Lingkungan Hidup')

@section('heading', 'Data Lingkungan Hidup Malang Selatan')

@section('hidePageHeading', true)

@section('style')

@vite('resources/css/pages/lingkungan-hidup/index.css')

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