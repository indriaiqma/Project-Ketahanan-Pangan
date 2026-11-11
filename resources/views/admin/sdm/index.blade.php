@extends('layouts.app')

@section('title', 'SDM')
@section('heading', 'Data SDM Malang Selatan')
@section('hidePageHeading', true)

@section('style')

@vite('resources/css/pages/admin/sdm/index.css')

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