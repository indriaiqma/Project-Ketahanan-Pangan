@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('heading', 'Dashboard Administrator')

@section('hidePageHeading', true)

@section('style')
<style>
    .admin-dashboard {
        width: 100%;
    }

    /* HERO */
    .admin-hero {
        position: relative;
        min-height: 250px;
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

    .admin-hero-content {
        position: relative;
        z-index: 2;
        max-width: 720px;
    }

    .admin-hero-label {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 13px;

        color: #6F8176;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .admin-hero-label-line {
        width: 31px;
        height: 4px;

        display: inline-block;

        border-radius: 10px;
        background: #3E9B68;
    }

    .admin-hero h2 {
        margin: 0 0 11px;

        color: #173D2A;
        font-size: 30px;
        font-weight: 750;
        line-height: 1.25;
    }

    .admin-hero-description {
        max-width: 680px;
        margin: 0;

        color: #738279;
        font-size: 13px;
        line-height: 1.7;
    }

    /* STATUS */
    .admin-status {
        position: absolute;
        z-index: 3;

        top: 25px;
        right: 27px;

        display: flex;
        align-items: center;
        gap: 9px;

        padding: 10px 14px;

        background: rgba(255, 255, 255, 0.9);

        border: 1px solid #DFEAE3;
        border-radius: 30px;

        box-shadow:
            0 5px 16px rgba(37, 107, 74, 0.06);
    }

    .admin-status-dot {
        width: 8px;
        height: 8px;

        border-radius: 50%;
        background: #42A66D;
    }

    .admin-status strong {
        display: block;

        color: #315640;
        font-size: 10px;
    }

    .admin-status small {
        display: block;

        margin-top: 2px;

        color: #89958E;
        font-size: 9px;
    }

    /* DECORATION */
    .admin-decoration {
        position: absolute;
        pointer-events: none;
    }

    .admin-decoration-one {
        width: 370px;
        height: 210px;

        right: -55px;
        bottom: -115px;

        border-radius: 50% 50% 0 0;

        background: rgba(92, 174, 126, 0.13);

        transform: rotate(-7deg);
    }

    .admin-decoration-two {
        width: 330px;
        height: 170px;

        right: 120px;
        bottom: -115px;

        border-radius: 55% 55% 0 0;

        background: rgba(121, 194, 151, 0.11);

        transform: rotate(7deg);
    }

    .admin-decoration-three {
        width: 230px;
        height: 230px;

        right: 40px;
        top: 70px;

        border-radius: 50%;

        background: rgba(105, 190, 139, 0.07);
    }

    /* PANEL */
    .admin-panel {
        margin-bottom: 18px;

        background: #FFFFFF;

        border: 1px solid #E1E9E4;
        border-radius: 12px;

        overflow: hidden;

        box-shadow:
            0 4px 16px rgba(32, 59, 44, 0.035);
    }

    .admin-panel-header {
        min-height: 60px;

        padding: 0 20px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        border-bottom: 1px solid #E8EDE9;
    }

    .admin-panel-title-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-panel-mark {
        width: 4px;
        height: 23px;

        background: #3E9B68;

        border-radius: 10px;
    }

    .admin-panel-title {
        margin: 0 0 3px;

        color: #203B2C;

        font-size: 13px;
        font-weight: 700;
    }

    .admin-panel-subtitle {
        color: #89958E;

        font-size: 10px;
        line-height: 1.5;
    }

    .admin-panel-badge {
        padding: 6px 10px;

        background: #F0F7F2;

        border-radius: 20px;

        color: #4C805F;

        font-size: 9px;
        font-weight: 800;
        letter-spacing: .4px;
    }

    /* SUMMARY */
    .admin-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .summary-item {
        position: relative;

        min-height: 120px;

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

        width: 36px;
        height: 36px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #EAF5EE;

        border-radius: 9px;

        color: #3E9B68;

        font-size: 9px;
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

    /* MODULE */
    .module-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .module-card {
        display: block;

        padding: 22px;

        border-right: 1px solid #E8EDEA;
        border-bottom: 1px solid #E8EDEA;

        text-decoration: none;

        transition: .18s ease;
    }

    .module-card:nth-child(2n) {
        border-right: none;
    }

    .module-card:nth-child(3),
    .module-card:nth-child(4) {
        border-bottom: none;
    }

    .module-card:hover {
        background: #F7FBF8;
        transform: translateY(-1px);
    }

    .module-icon {
        width: 42px;
        height: 42px;

        margin-bottom: 13px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #EAF5EE;

        border-radius: 10px;

        color: #3E9B68;

        font-size: 10px;
        font-weight: 800;
    }

    .module-title {
        margin-bottom: 5px;

        color: #294637;

        font-size: 13px;
        font-weight: 700;
    }

    .module-description {
        color: #89958E;

        font-size: 10px;
        line-height: 1.6;
    }

    .module-status {
        display: inline-block;

        margin-top: 11px;

        padding: 5px 9px;

        background: #EEF7F1;

        border-radius: 20px;

        color: #43805C;

        font-size: 8px;
        font-weight: 800;
    }

    /* INFO */
    .admin-info {
        padding: 20px;

        color: #738279;

        font-size: 11px;

        line-height: 1.7;
    }

    /* RESPONSIVE */
    @media(max-width: 1000px) {

        .admin-summary {
            grid-template-columns: repeat(2, 1fr);
        }

        .summary-item:nth-child(2) {
            border-right: none;
        }

        .summary-item:nth-child(1),
        .summary-item:nth-child(2) {
            border-bottom: 1px solid #E8EDEA;
        }

    }

    @media(max-width: 750px) {

        .admin-hero {
            min-height: auto;
            padding: 28px 23px;
        }

        .admin-hero h2 {
            font-size: 25px;
        }

        .admin-status {
            position: relative;

            top: auto;
            right: auto;

            width: fit-content;

            margin-top: 18px;
        }

        .admin-summary {
            grid-template-columns: 1fr;
        }

        .summary-item {
            border-right: none;
            border-bottom: 1px solid #E8EDEA;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .module-grid {
            grid-template-columns: 1fr;
        }

        .module-card,
        .module-card:nth-child(2n) {
            border-right: none;
        }

        .module-card:nth-child(3) {
            border-bottom: 1px solid #E8EDEA;
        }

        .module-card:last-child {
            border-bottom: none;
        }
    }
</style>
@endsection


@section('content')

<div class="admin-dashboard">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="admin-hero">

        <div class="admin-decoration admin-decoration-one"></div>
        <div class="admin-decoration admin-decoration-two"></div>
        <div class="admin-decoration admin-decoration-three"></div>

        <div class="admin-hero-content">

            <div class="admin-hero-label">

                <span class="admin-hero-label-line"></span>

                SISTEM INFORMASI KETAHANAN PANGAN

            </div>

            <h2>
                Dashboard Administrator
            </h2>

            <p class="admin-hero-description">

                Pusat pengelolaan dan pemantauan data
                Ketahanan Pangan Malang Selatan.
                Gunakan menu pada sidebar untuk mengelola
                setiap modul data.

            </p>

        </div>


        <div class="admin-status">

            <span class="admin-status-dot"></span>

            <div>

                <strong>
                    Mode Administrator
                </strong>

                <small>
                    Sistem aktif
                </small>

            </div>

        </div>

    </section>


    {{-- =====================================================
         RINGKASAN
    ====================================================== --}}

    <section class="admin-panel">

        <div class="admin-panel-header">

            <div class="admin-panel-title-wrap">

                <span class="admin-panel-mark"></span>

                <div>

                    <h3 class="admin-panel-title">
                        Ringkasan Data
                    </h3>

                    <div class="admin-panel-subtitle">
                        Informasi utama data yang tersedia
                    </div>

                </div>

            </div>


            <div class="admin-panel-badge">
                ADMINISTRATOR
            </div>

        </div>


        <div class="admin-summary">


            {{-- KAWASAN HUTAN --}}

            <div class="summary-item">

                <div class="summary-icon">
                    KH
                </div>

                <div class="summary-label">
                    Total Kawasan Hutan
                </div>

                <div class="summary-value">
                    {{ $totalKawasan ?? 0 }}
                </div>

                <div class="summary-unit">
                    Data kawasan
                </div>

            </div>


            {{-- LUAS KAWASAN --}}

            <div class="summary-item">

                <div class="summary-icon">
                    Ha
                </div>

                <div class="summary-label">
                    Luas Kawasan Hutan
                </div>

                <div class="summary-value">
                    {{ number_format($totalLuasKawasan ?? 0, 2, ',', '.') }}
                </div>

                <div class="summary-unit">
                    Hektare
                </div>

            </div>


            {{-- LAHAN KRITIS --}}

            <div class="summary-item">

                <div class="summary-icon">
                    LK
                </div>

                <div class="summary-label">
                    Total Lahan Kritis
                </div>

                <div class="summary-value">
                    {{ number_format($totalLahanKritis ?? 0, 2, ',', '.') }}
                </div>

                <div class="summary-unit">
                    Hektare
                </div>

            </div>


            {{-- KECAMATAN --}}

            <div class="summary-item">

                <div class="summary-icon">
                    K
                </div>

                <div class="summary-label">
                    Kecamatan Kawasan Hutan
                </div>

                <div class="summary-value">
                    {{ $jumlahKecamatanKawasan ?? 0 }}
                </div>

                <div class="summary-unit">
                    Kecamatan
                </div>

            </div>


        </div>

    </section>


    {{-- =====================================================
         MODUL
    ====================================================== --}}

    <section class="admin-panel">

        <div class="admin-panel-header">

            <div class="admin-panel-title-wrap">

                <span class="admin-panel-mark"></span>

                <div>

                    <h3 class="admin-panel-title">
                        Modul Data
                    </h3>

                    <div class="admin-panel-subtitle">
                        Pilih modul yang ingin dikelola
                    </div>

                </div>

            </div>


            <div class="admin-panel-badge">
                KELOLA DATA
            </div>

        </div>


        <div class="module-grid">


            {{-- KAWASAN HUTAN --}}

            <a
                href="{{ route('admin.kawasan-hutan.index') }}"
                class="module-card"
            >

                <div class="module-icon">
                    KH
                </div>

                <div class="module-title">
                    Kawasan Hutan
                </div>

                <div class="module-description">
                    Kelola data kawasan hutan,
                    luas wilayah, jenis kawasan,
                    kecamatan, desa, dan keterangan.
                </div>

                <span class="module-status">
                    DATA TERSEDIA
                </span>

            </a>


            {{-- LAHAN KRITIS --}}

            <a
                href="{{ route('admin.lahan-kritis.index') }}"
                class="module-card"
            >

                <div class="module-icon">
                    LK
                </div>

                <div class="module-title">
                    Lahan Kritis
                </div>

                <div class="module-description">
                    Kelola data lahan kritis berdasarkan
                    kecamatan dan kategori kekritisan lahan.
                </div>

                <span class="module-status">
                    DATA TERSEDIA
                </span>

            </a>


            {{-- LINGKUNGAN HIDUP --}}

            <a
                href="{{ route('admin.lingkungan-hidup.index') }}"
                class="module-card"
            >

                <div class="module-icon">
                    LH
                </div>

                <div class="module-title">
                    Lingkungan Hidup
                </div>

                <div class="module-description">
                    Modul pengelolaan data lingkungan hidup
                    Malang Selatan.
                </div>

                <span class="module-status">
                    MENUNGGU DATA
                </span>

            </a>


            {{-- SDM --}}

            <a
                href="{{ route('admin.sdm.index') }}"
                class="module-card"
            >

                <div class="module-icon">
                    SDM
                </div>

                <div class="module-title">
                    Sumber Daya Manusia
                </div>

                <div class="module-description">
                    Modul pengelolaan data sumber daya manusia
                    Malang Selatan.
                </div>

                <span class="module-status">
                    MENUNGGU DATA
                </span>

            </a>


        </div>

    </section>


    {{-- =====================================================
         INFORMASI
    ====================================================== --}}

    <section class="admin-panel">

        <div class="admin-panel-header">

            <div class="admin-panel-title-wrap">

                <span class="admin-panel-mark"></span>

                <div>

                    <h3 class="admin-panel-title">
                        Informasi Administrator
                    </h3>

                    <div class="admin-panel-subtitle">
                        Status sistem
                    </div>

                </div>

            </div>

        </div>


        <div class="admin-info">

            Dashboard ini merupakan halaman khusus administrator.
            Seluruh pengelolaan data dilakukan melalui menu
            administrator pada sidebar.

        </div>

    </section>

</div>

@endsection