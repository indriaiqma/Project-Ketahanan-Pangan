@extends(auth()->user()->role === 'viewer' ? 'layouts.viewer' : 'layouts.app')

@section('title', 'Detail Lahan Kritis')
@section('heading', 'Detail Lahan Kritis')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/lahan-kritis/show.css')
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
            Lahan Kritis Kecamatan {{ $lahanKritis->kecamatan }}
        </h2>


        <p class="hero-description">
            Informasi kondisi lahan berdasarkan tingkat kekritisan
            di dalam dan di luar kawasan hutan Malang Selatan.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                LK
            </div>


            <div>

                <div class="hero-summary-title">
                    Detail Lahan Kritis
                </div>

                <div class="hero-summary-text">
                    {{ $lahanKritis->kecamatan ?? '-' }},
                    {{ $lahanKritis->kabupaten ?? '-' }}
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
                Kecamatan {{ $lahanKritis->kecamatan ?? '-' }}
            </small>

        </div>

    </div>

</section>



<div class="detail-container">


    {{-- =====================================================
         RINGKASAN WILAYAH
    ===================================================== --}}

    <section class="main-summary">


        <div class="summary-item">

            <div class="summary-label">
                Kabupaten
            </div>

            <div class="summary-value">
                {{ $lahanKritis->kabupaten ?? '-' }}
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-label">
                Kecamatan
            </div>

            <div class="summary-value">
                {{ $lahanKritis->kecamatan ?? '-' }}
            </div>

        </div>


        <div class="summary-item summary-total">

            <div class="summary-label">
                Total Luas Lahan
            </div>

            <div class="summary-value">

                {{ number_format($lahanKritis->total_ha ?? 0, 2, ',', '.') }}

                <span class="summary-unit">
                    Ha
                </span>

            </div>

        </div>


    </section>



    {{-- =====================================================
         DALAM KAWASAN HUTAN
    ===================================================== --}}

    <section class="detail-panel">


        <div class="panel-header">

            <div class="panel-title-wrap">

                <span class="panel-mark"></span>


                <div>

                    <h3 class="panel-title">
                        Dalam Kawasan Hutan
                    </h3>

                    <div class="panel-subtitle">
                        Luas lahan berdasarkan tingkat kekritisan di dalam kawasan hutan
                    </div>

                </div>

            </div>


            <div class="panel-badge">
                DALAM KAWASAN
            </div>

        </div>



        <div class="category-body">


            <div class="category-grid">


                <div class="category-item sangat-kritis">

                    <div class="category-label">
                        Sangat Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->dalam_sangat_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item kritis">

                    <div class="category-label">
                        Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->dalam_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item agak-kritis">

                    <div class="category-label">
                        Agak Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->dalam_agak_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item potensial-kritis">

                    <div class="category-label">
                        Potensial Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->dalam_potensial_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item tidak-kritis">

                    <div class="category-label">
                        Tidak Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->dalam_tidak_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>


            </div>


        </div>


        <div class="panel-total">

            <div class="panel-total-label">
                Total Dalam Kawasan Hutan
            </div>


            <div class="panel-total-value">

                {{
                    number_format(
                        ($lahanKritis->dalam_sangat_kritis ?? 0) +
                        ($lahanKritis->dalam_kritis ?? 0) +
                        ($lahanKritis->dalam_agak_kritis ?? 0) +
                        ($lahanKritis->dalam_potensial_kritis ?? 0) +
                        ($lahanKritis->dalam_tidak_kritis ?? 0),
                        2,
                        ',',
                        '.'
                    )
                }}

                <span>Ha</span>

            </div>

        </div>


    </section>



    {{-- =====================================================
         LUAR KAWASAN HUTAN
    ===================================================== --}}

    <section class="detail-panel">


        <div class="panel-header">

            <div class="panel-title-wrap">

                <span class="panel-mark"></span>


                <div>

                    <h3 class="panel-title">
                        Luar Kawasan Hutan
                    </h3>

                    <div class="panel-subtitle">
                        Luas lahan berdasarkan tingkat kekritisan di luar kawasan hutan
                    </div>

                </div>

            </div>


            <div class="panel-badge">
                LUAR KAWASAN
            </div>

        </div>



        <div class="category-body">


            <div class="category-grid">


                <div class="category-item sangat-kritis">

                    <div class="category-label">
                        Sangat Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->luar_sangat_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item kritis">

                    <div class="category-label">
                        Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->luar_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item agak-kritis">

                    <div class="category-label">
                        Agak Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->luar_agak_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item potensial-kritis">

                    <div class="category-label">
                        Potensial Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->luar_potensial_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>



                <div class="category-item tidak-kritis">

                    <div class="category-label">
                        Tidak Kritis
                    </div>

                    <div class="category-value">
                        {{ number_format($lahanKritis->luar_tidak_kritis ?? 0, 2, ',', '.') }}
                    </div>

                    <div class="category-unit">
                        Ha
                    </div>

                </div>


            </div>


        </div>


        <div class="panel-total">

            <div class="panel-total-label">
                Total Luar Kawasan Hutan
            </div>


            <div class="panel-total-value">

                {{
                    number_format(
                        ($lahanKritis->luar_sangat_kritis ?? 0) +
                        ($lahanKritis->luar_kritis ?? 0) +
                        ($lahanKritis->luar_agak_kritis ?? 0) +
                        ($lahanKritis->luar_potensial_kritis ?? 0) +
                        ($lahanKritis->luar_tidak_kritis ?? 0),
                        2,
                        ',',
                        '.'
                    )
                }}

                <span>Ha</span>

            </div>

        </div>


    </section>



    {{-- =====================================================
         ACTION
    ===================================================== --}}

    <section class="action-panel">


        <div class="detail-actions">


            <a
                href="/lahan-kritis"
                class="detail-btn btn-back"
            >
                Kembali ke Daftar
            </a>


            @if(auth()->user()->role === 'admin')

                <a
                    href="/lahan-kritis/{{ $lahanKritis->id }}/edit"
                    class="detail-btn btn-edit-detail"
                >
                    Edit Data
                </a>

            @endif


        </div>


    </section>


</div>

@endsection