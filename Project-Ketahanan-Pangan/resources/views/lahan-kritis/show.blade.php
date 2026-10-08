@extends(auth()->user()->role === 'viewer' ? 'layouts.viewer' : 'layouts.app')

@section('title', 'Detail Lahan Kritis')
@section('heading', 'Detail Lahan Kritis')
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

    font-size: 10px;
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
   HERO STATUS
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
   DECORATION
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
   DETAIL PAGE
========================================================= */

.detail-container {
    max-width: 1100px;
    margin: 0 auto 20px;
}


/* =========================================================
   MAIN SUMMARY
========================================================= */

.main-summary {
    margin-bottom: 18px;

    display: grid;
    grid-template-columns: 1fr 1fr 1.2fr;

    background: #FFFFFF;

    border: 1px solid #E1E9E4;
    border-radius: 12px;

    overflow: hidden;

    box-shadow: 0 4px 16px rgba(32,59,44,.035);
}

.summary-item {
    min-height: 82px;

    padding: 17px 20px;

    display: flex;
    flex-direction: column;
    justify-content: center;

    border-right: 1px solid #E8EDE9;
}

.summary-item:last-child {
    border-right: none;
}

.summary-label {
    margin-bottom: 6px;

    color: #929D96;

    font-size: 9px;
    font-weight: 800;

    text-transform: uppercase;
    letter-spacing: .5px;
}

.summary-value {
    color: #405648;

    font-size: 12px;
    font-weight: 700;
}

.summary-total {
    background: #F3F9F5;
}

.summary-total .summary-value {
    color: #2F8B5A;

    font-size: 22px;
    font-weight: 750;
}

.summary-unit {
    margin-left: 3px;

    color: #849087;

    font-size: 9px;
    font-weight: 600;
}


/* =========================================================
   PANEL
========================================================= */

.detail-panel {
    margin-bottom: 18px;

    overflow: hidden;

    background: #FFFFFF;

    border: 1px solid #E1E9E4;
    border-radius: 12px;

    box-shadow: 0 4px 16px rgba(32,59,44,.035);
}

.panel-header {
    min-height: 67px;

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
   CATEGORY
========================================================= */

.category-body {
    padding: 20px;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));

    gap: 10px;
}

.category-item {
    position: relative;

    min-width: 0;
    min-height: 90px;

    padding: 15px 12px;

    display: flex;
    flex-direction: column;
    justify-content: center;

    background: #F8FAF9;

    border: 1px solid #E5ECE7;
    border-radius: 8px;

    text-align: center;

    overflow: hidden;
}

.category-item::before {
    content: '';

    position: absolute;

    top: 0;
    left: 0;
    right: 0;

    height: 3px;
}

.category-item.sangat-kritis::before {
    background: #D36A63;
}

.category-item.kritis::before {
    background: #D99A45;
}

.category-item.agak-kritis::before {
    background: #D7BA5B;
}

.category-item.potensial-kritis::before {
    background: #69A77E;
}

.category-item.tidak-kritis::before {
    background: #6AAE8A;
}

.category-label {
    min-height: 28px;

    margin-bottom: 8px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #77857C;

    font-size: 9px;
    font-weight: 700;
    line-height: 1.4;
}

.category-value {
    color: #405648;

    font-size: 15px;
    font-weight: 750;

    overflow-wrap: anywhere;
}

.category-unit {
    margin-top: 4px;

    color: #929D96;

    font-size: 9px;
}


/* =========================================================
   CRITICAL SEMANTIC COLORS
========================================================= */

.sangat-kritis .category-value {
    color: #B65B55;
}

.kritis .category-value {
    color: #B77A2B;
}

.agak-kritis .category-value {
    color: #A48A35;
}


/* =========================================================
   PANEL TOTAL
========================================================= */

.panel-total {
    padding: 12px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    background: #FBFCFB;

    border-top: 1px solid #E8EDE9;
}

.panel-total-label {
    color: #77857C;

    font-size: 9px;
    font-weight: 700;
}

.panel-total-value {
    color: #2F8B5A;

    font-size: 13px;
    font-weight: 750;
}

.panel-total-value span {
    margin-left: 2px;

    color: #849087;

    font-size: 9px;
    font-weight: 600;
}


/* =========================================================
   ACTION PANEL
========================================================= */

.action-panel {
    overflow: hidden;

    background: #FFFFFF;

    border: 1px solid #E1E9E4;
    border-radius: 12px;

    box-shadow: 0 4px 16px rgba(32,59,44,.035);
}

.detail-actions {
    padding: 15px 20px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 10px;

    background: #FBFCFB;
}

.detail-btn {
    min-height: 34px;

    padding: 0 13px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 1px solid transparent;
    border-radius: 7px;

    font-size: 10px;
    font-weight: 700;

    text-decoration: none;

    transition: .18s;
}

.detail-btn:hover {
    transform: translateY(-1px);
}

.btn-back {
    background: #FFFFFF;

    border-color: #DCE5DF;

    color: #617067;
}

.btn-back:hover {
    background: #F5F8F6;
}

.btn-edit-detail {
    background: #FFF7E9;

    border-color: #F0DFC1;

    color: #A97121;
}

.btn-edit-detail:hover {
    background: #FFF2D9;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 900px) {

    .category-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
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

    .main-summary {
        grid-template-columns: 1fr;
    }

    .summary-item {
        border-right: none;
        border-bottom: 1px solid #E8EDE9;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .category-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .panel-header {
        padding: 15px 18px;
    }

    .category-body {
        padding: 18px;
    }

}


@media(max-width: 500px) {

    .category-grid {
        grid-template-columns: 1fr;
    }

    .category-item {
        min-height: auto;
    }

    .category-label {
        min-height: auto;
    }

    .detail-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .detail-btn {
        width: 100%;
        box-sizing: border-box;
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