@extends(auth()->user()->role === 'viewer' ? 'layouts.viewer' : 'layouts.app')

@section('title', 'Detail Kawasan Hutan')
@section('heading', 'Detail Kawasan Hutan')
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

    overflow-wrap: anywhere;
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
   DETAIL CONTAINER
========================================================= */

.detail-container {
    max-width: 1050px;
    margin: 0 auto 20px;
}


/* =========================================================
   PANEL
========================================================= */

.detail-panel {
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
   PRIMARY SUMMARY
========================================================= */

.detail-summary {
    padding: 18px 20px;

    display: grid;
    grid-template-columns: 1.5fr .8fr;

    gap: 12px;

    background: #FBFCFB;

    border-bottom: 1px solid #E8EDE9;
}

.summary-main,
.summary-luas {
    padding: 15px;

    background: #FFFFFF;

    border: 1px solid #E3EBE5;
    border-radius: 9px;
}

.summary-label {
    display: block;

    margin-bottom: 6px;

    color: #929D96;

    font-size: 9px;
    font-weight: 800;

    text-transform: uppercase;
    letter-spacing: .5px;
}

.summary-name {
    color: #294936;

    font-size: 14px;
    font-weight: 700;
    line-height: 1.5;

    overflow-wrap: anywhere;
}

.summary-location {
    margin-top: 5px;

    color: #849087;

    font-size: 9px;
    line-height: 1.5;
}

.summary-luas {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.summary-luas-value {
    color: #2F8B5A;

    font-size: 24px;
    font-weight: 750;
    line-height: 1.2;
}

.summary-luas-value span {
    margin-left: 3px;

    color: #849087;

    font-size: 10px;
    font-weight: 600;
}


/* =========================================================
   DETAIL BODY
========================================================= */

.detail-body {
    padding: 20px;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 11px;
}

.detail-item {
    min-width: 0;

    padding: 14px 15px;

    background: #F8FAF9;

    border: 1px solid #E6ECE8;
    border-radius: 8px;
}

.detail-item.full {
    grid-column: 1 / -1;
}

.detail-label {
    display: block;

    margin-bottom: 6px;

    color: #929D96;

    font-size: 9px;
    font-weight: 800;

    text-transform: uppercase;
    letter-spacing: .4px;
}

.detail-value {
    color: #405648;

    font-size: 10px;
    font-weight: 600;
    line-height: 1.6;

    overflow-wrap: anywhere;
}

.jenis-badge {
    padding: 5px 9px;

    display: inline-flex;

    background: #EAF5EE;

    border-radius: 20px;

    color: #347A55;

    font-size: 9px;
    font-weight: 700;
}

.luas-detail {
    color: #2F8B5A;

    font-size: 16px;
    font-weight: 750;
}

.luas-detail span {
    margin-left: 2px;

    color: #849087;

    font-size: 9px;
    font-weight: 600;
}

.detail-description {
    min-height: 35px;

    font-weight: 400;

    white-space: pre-line;
}


/* =========================================================
   ACTION
========================================================= */

.detail-actions {
    padding: 15px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    background: #FBFCFB;

    border-top: 1px solid #E8EDE9;
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

    .detail-summary {
        grid-template-columns: 1fr;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }

    .detail-item.full {
        grid-column: auto;
    }

    .panel-header {
        padding: 15px 18px;
    }

    .detail-body {
        padding: 18px;
    }

    .detail-actions {
        padding: 15px 18px;
    }
}


@media(max-width: 500px) {

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