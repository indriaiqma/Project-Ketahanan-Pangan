@extends(auth()->user()->role === 'viewer' ? 'layouts.viewer' : 'layouts.app')

@section('title', 'Detail Kawasan Hutan')
@section('heading', 'Detail Kawasan Hutan')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/kawasan-hutan/show.css')
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

            DATA KEHUTANAN

        </div>


        <h2>
            {{ $kawasanHutan->nama_kawasan ?? 'Detail Kawasan Hutan' }}
        </h2>


        <p class="hero-description">
            Informasi lengkap kawasan hutan berdasarkan lokasi,
            jenis kawasan, luas wilayah, dan keterangan data kehutanan.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                KH
            </div>


            <div>

                <div class="hero-summary-title">
                    Detail Kawasan Hutan
                </div>

                <div class="hero-summary-text">
                    {{ $kawasanHutan->kecamatan ?? '-' }},
                    {{ $kawasanHutan->kabupaten ?? '-' }}
                </div>

            </div>

        </div>

    </div>


    <div class="hero-status">

        <span></span>


        <div>

            <strong>
                {{ $kawasanHutan->jenis_kawasan ?? 'Kawasan Hutan' }}
            </strong>

            <small>
                Data tersedia
            </small>

        </div>

    </div>

</section>



{{-- =========================================================
     DETAIL
========================================================= --}}

<div class="detail-container">


    <section class="detail-panel">


        {{-- PANEL HEADER --}}

        <div class="panel-header">

            <div class="panel-title-wrap">

                <span class="panel-mark"></span>


                <div>

                    <h3 class="panel-title">
                        Informasi Kawasan Hutan
                    </h3>

                    <div class="panel-subtitle">
                        Rincian data kawasan yang tersimpan dalam sistem
                    </div>

                </div>

            </div>


            <div class="panel-badge">
                KEHUTANAN
            </div>

        </div>



        {{-- =================================================
             RINGKASAN
        ================================================== --}}

        <div class="detail-summary">


            <div class="summary-main">

                <span class="summary-label">
                    Nama Kawasan
                </span>


                <div class="summary-name">
                    {{ $kawasanHutan->nama_kawasan ?? '-' }}
                </div>


                <div class="summary-location">

                    {{ $kawasanHutan->desa ?? '-' }}

                    &nbsp;•&nbsp;

                    {{ $kawasanHutan->kecamatan ?? '-' }}

                    &nbsp;•&nbsp;

                    {{ $kawasanHutan->kabupaten ?? '-' }}

                </div>

            </div>



            <div class="summary-luas">

                <span class="summary-label">
                    Luas Kawasan
                </span>


                <div class="summary-luas-value">

                    {{ number_format($kawasanHutan->luas_ha ?? 0, 2, ',', '.') }}

                    <span>
                        Ha
                    </span>

                </div>

            </div>


        </div>



        {{-- =================================================
             DETAIL DATA
        ================================================== --}}

        <div class="detail-body">


            <div class="detail-grid">


                {{-- KABUPATEN --}}

                <div class="detail-item">

                    <span class="detail-label">
                        Kabupaten
                    </span>


                    <div class="detail-value">
                        {{ $kawasanHutan->kabupaten ?? '-' }}
                    </div>

                </div>



                {{-- KECAMATAN --}}

                <div class="detail-item">

                    <span class="detail-label">
                        Kecamatan
                    </span>


                    <div class="detail-value">
                        {{ $kawasanHutan->kecamatan ?? '-' }}
                    </div>

                </div>



                {{-- DESA --}}

                <div class="detail-item">

                    <span class="detail-label">
                        Desa
                    </span>


                    <div class="detail-value">
                        {{ $kawasanHutan->desa ?? '-' }}
                    </div>

                </div>



                {{-- JENIS KAWASAN --}}

                <div class="detail-item">

                    <span class="detail-label">
                        Jenis Kawasan
                    </span>


                    <div class="detail-value">

                        <span class="jenis-badge">

                            {{ $kawasanHutan->jenis_kawasan ?? '-' }}

                        </span>

                    </div>

                </div>



                {{-- NAMA KAWASAN --}}

                <div class="detail-item">

                    <span class="detail-label">
                        Nama Kawasan
                    </span>


                    <div class="detail-value">
                        {{ $kawasanHutan->nama_kawasan ?? '-' }}
                    </div>

                </div>



                {{-- LUAS --}}

                <div class="detail-item">

                    <span class="detail-label">
                        Luas Kawasan
                    </span>


                    <div class="luas-detail">

                        {{ number_format($kawasanHutan->luas_ha ?? 0, 2, ',', '.') }}

                        <span>
                            Ha
                        </span>

                    </div>

                </div>



                {{-- KETERANGAN --}}

                <div class="detail-item full">

                    <span class="detail-label">
                        Keterangan
                    </span>


                    <div class="detail-value detail-description">{{ $kawasanHutan->keterangan ?: '-' }}</div>

                </div>


            </div>


        </div>



        {{-- =================================================
             ACTION
        ================================================== --}}

        <div class="detail-actions">


            <a
                href="/kawasan-hutan"
                class="detail-btn btn-back"
            >
                Kembali ke Daftar
            </a>



            @if(auth()->user()->role === 'admin')

                <a
                    href="/kawasan-hutan/{{ $kawasanHutan->id }}/edit"
                    class="detail-btn btn-edit-detail"
                >
                    Edit Data
                </a>

            @endif


        </div>


    </section>


</div>

@endsection