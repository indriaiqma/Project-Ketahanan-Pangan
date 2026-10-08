@extends('layouts.app')

@section('title', 'Tambah Data Lahan Kritis')
@section('heading', 'Tambah Data Lahan Kritis')
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
   FORM PAGE
========================================================= */

.form-page {
    max-width: 1050px;
    margin: 0 auto 20px;
}


/* =========================================================
   ERROR
========================================================= */

.form-error {
    margin-bottom: 18px;
    padding: 14px 16px;

    background: #FFF5F4;
    border: 1px solid #F0D6D3;
    border-left: 4px solid #D36A63;
    border-radius: 9px;

    color: #9D514C;
    font-size: 10px;
    line-height: 1.6;
}

.form-error strong {
    display: block;
    margin-bottom: 6px;
    font-size: 10px;
}

.form-error ul {
    margin: 0;
    padding-left: 18px;
}


/* =========================================================
   FORM PANEL
========================================================= */

.form-panel {
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
}


/* =========================================================
   FORM SECTION
========================================================= */

.form-section {
    padding: 20px;
    border-bottom: 1px solid #E8EDE9;
}

.section-heading {
    margin-bottom: 17px;

    display: flex;
    align-items: center;
    gap: 11px;
}

.section-code {
    width: 36px;
    height: 36px;
    min-width: 36px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #EAF5EE;
    border-radius: 8px;

    color: #3E8D5E;
    font-size: 9px;
    font-weight: 800;
}

.section-heading h3 {
    margin: 0 0 3px;

    color: #294936;
    font-size: 12px;
    font-weight: 700;
}

.section-heading p {
    margin: 0;

    color: #89958E;
    font-size: 9px;
    line-height: 1.5;
}


/* =========================================================
   FORM
========================================================= */

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px;
}

.form-group {
    min-width: 0;
}

.form-label {
    display: block;
    margin-bottom: 6px;

    color: #4C5F53;
    font-size: 10px;
    font-weight: 700;
}

.required {
    margin-left: 2px;
    color: #C75B55;
}

.form-input,
.form-select {
    width: 100%;
    height: 36px;
    box-sizing: border-box;

    padding: 8px 11px;

    background: #FFFFFF;
    border: 1px solid #DCE5DF;
    border-radius: 7px;

    color: #34483C;
    font-family: inherit;
    font-size: 10px;

    outline: none;
    transition: .18s;
}

.form-input:focus,
.form-select:focus {
    border-color: #69BE8B;
    box-shadow: 0 0 0 3px rgba(62,155,104,.08);
}

.form-input.is-invalid,
.form-select.is-invalid {
    border-color: #D36A63;
}

.field-error {
    margin-top: 5px;
    color: #BE5953;
    font-size: 9px;
}

.form-hint {
    margin-top: 5px;
    color: #929D96;
    font-size: 9px;
}


/* =========================================================
   INPUT UNIT
========================================================= */

.input-unit {
    position: relative;
}

.input-unit .form-input {
    padding-right: 39px;
}

.input-unit span {
    position: absolute;
    top: 50%;
    right: 10px;

    transform: translateY(-50%);

    color: #8A978F;
    font-size: 9px;
    font-weight: 700;

    pointer-events: none;
}


/* =========================================================
   CATEGORY GRID
========================================================= */

.category-grid {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 10px;
}

.category-field {
    position: relative;
    overflow: hidden;

    min-width: 0;
    padding: 14px 12px;

    background: #F8FAF9;
    border: 1px solid #E5ECE7;
    border-radius: 8px;
}

.category-field::before {
    content: '';

    position: absolute;
    top: 0;
    left: 0;
    right: 0;

    height: 3px;
}

.category-field.sangat-kritis::before {
    background: #D36A63;
}

.category-field.kritis::before {
    background: #D99A45;
}

.category-field.agak-kritis::before {
    background: #D7BA5B;
}

.category-field.potensial-kritis::before {
    background: #69A77E;
}

.category-field.tidak-kritis::before {
    background: #6AAE8A;
}

.category-field label {
    min-height: 27px;
    margin-bottom: 8px;

    display: flex;
    align-items: center;

    color: #617067;
    font-size: 9px;
    font-weight: 700;
    line-height: 1.4;
}

.category-field .form-input {
    background: #FFFFFF;
}


/* =========================================================
   CATEGORY INFORMATION
========================================================= */

.category-info {
    margin-top: 15px;
    padding: 11px 13px;

    display: flex;
    align-items: center;
    gap: 10px;

    background: #F6F9F7;
    border: 1px solid #E5ECE7;
    border-radius: 8px;

    color: #7D8A82;
    font-size: 9px;
    line-height: 1.5;
}

.category-info-code {
    min-width: 27px;
    height: 27px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #E6F2EA;
    border-radius: 6px;

    color: #43805B;
    font-size: 8px;
    font-weight: 800;
}


/* =========================================================
   ACTION
========================================================= */

.form-actions {
    padding: 15px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;

    background: #FBFCFB;
}

.form-btn {
    min-height: 34px;
    padding: 0 14px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 1px solid transparent;
    border-radius: 7px;

    font-family: inherit;
    font-size: 10px;
    font-weight: 700;

    text-decoration: none;
    cursor: pointer;

    transition: .18s;
}

.form-btn:hover {
    transform: translateY(-1px);
}

.btn-cancel {
    background: #FFFFFF;
    border-color: #DCE5DF;
    color: #617067;
}

.btn-cancel:hover {
    background: #F5F8F6;
}

.btn-save {
    background: #3E9B68;
    border-color: #3E9B68;
    color: #FFFFFF;
}

.btn-save:hover {
    background: #34875B;
    border-color: #34875B;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 950px) {

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

    .form-grid {
        grid-template-columns: 1fr;
    }

    .category-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .panel-header {
        padding: 15px 18px;
    }

    .form-section {
        padding: 18px;
    }

    .form-actions {
        padding: 15px 18px;
    }

}

@media(max-width: 500px) {

    .category-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .form-btn {
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
            Tambah Data Lahan Kritis
        </h2>


        <p class="hero-description">
            Tambahkan informasi luas lahan berdasarkan tingkat
            kekritisan di dalam dan di luar kawasan hutan
            pada wilayah Malang Selatan.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                LK
            </div>


            <div>

                <div class="hero-summary-title">
                    Data Lahan Kritis Baru
                </div>

                <div class="hero-summary-text">
                    Isi data wilayah dan luas setiap kategori dalam satuan hektare.
                </div>

            </div>

        </div>

    </div>


    <div class="hero-status">

        <span></span>


        <div>

            <strong>
                Administrator
            </strong>

            <small>
                Penambahan data
            </small>

        </div>

    </div>

</section>



<div class="form-page">


    {{-- =====================================================
         ERROR
    ===================================================== --}}

    @if ($errors->any())

        <div class="form-error">

            <strong>
                Data belum berhasil disimpan. Periksa kembali isian berikut:
            </strong>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- =====================================================
         FORM
    ===================================================== --}}

    <form action="/lahan-kritis" method="POST">

        @csrf


        <section class="form-panel">


            {{-- PANEL HEADER --}}

            <div class="panel-header">

                <div class="panel-title-wrap">

                    <span class="panel-mark"></span>


                    <div>

                        <h3 class="panel-title">
                            Form Lahan Kritis
                        </h3>

                        <div class="panel-subtitle">
                            Isi data luas lahan sesuai kategori kekritisan
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    DATA BARU
                </div>

            </div>



            {{-- =================================================
                 01 INFORMASI WILAYAH
            ================================================== --}}

            <div class="form-section">


                <div class="section-heading">

                    <div class="section-code">
                        01
                    </div>


                    <div>

                        <h3>
                            Informasi Wilayah
                        </h3>

                        <p>
                            Pilih wilayah administratif data lahan kritis
                        </p>

                    </div>

                </div>



                <div class="form-grid">


                    <div class="form-group">

                        <label for="kabupaten" class="form-label">

                            Kabupaten
                            <span class="required">*</span>

                        </label>


                        <input
                            type="text"
                            id="kabupaten"
                            name="kabupaten"
                            class="form-input @error('kabupaten') is-invalid @enderror"
                            value="{{ old('kabupaten', 'Kabupaten Malang') }}"
                            required
                        >


                        @error('kabupaten')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group">

                        <label for="kecamatan" class="form-label">

                            Kecamatan
                            <span class="required">*</span>

                        </label>


                        <select
                            id="kecamatan"
                            name="kecamatan"
                            class="form-select @error('kecamatan') is-invalid @enderror"
                            required
                        >

                            <option value="">
                                -- Pilih Kecamatan --
                            </option>

                            <option value="Ampelgading"
                                {{ old('kecamatan') == 'Ampelgading' ? 'selected' : '' }}>
                                Ampelgading
                            </option>

                            <option value="Bantur"
                                {{ old('kecamatan') == 'Bantur' ? 'selected' : '' }}>
                                Bantur
                            </option>

                            <option value="Dampit"
                                {{ old('kecamatan') == 'Dampit' ? 'selected' : '' }}>
                                Dampit
                            </option>

                            <option value="Donomulyo"
                                {{ old('kecamatan') == 'Donomulyo' ? 'selected' : '' }}>
                                Donomulyo
                            </option>

                            <option value="Gedangan"
                                {{ old('kecamatan') == 'Gedangan' ? 'selected' : '' }}>
                                Gedangan
                            </option>

                            <option value="Kalipare"
                                {{ old('kecamatan') == 'Kalipare' ? 'selected' : '' }}>
                                Kalipare
                            </option>

                            <option value="Pagak"
                                {{ old('kecamatan') == 'Pagak' ? 'selected' : '' }}>
                                Pagak
                            </option>

                            <option value="Sumbermanjing Wetan"
                                {{ old('kecamatan') == 'Sumbermanjing Wetan' ? 'selected' : '' }}>
                                Sumbermanjing Wetan
                            </option>

                            <option value="Tirtoyudo"
                                {{ old('kecamatan') == 'Tirtoyudo' ? 'selected' : '' }}>
                                Tirtoyudo
                            </option>

                        </select>


                        @error('kecamatan')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                </div>

            </div>



            {{-- =================================================
                 02 DALAM KAWASAN HUTAN
            ================================================== --}}

            <div class="form-section">


                <div class="section-heading">

                    <div class="section-code">
                        02
                    </div>


                    <div>

                        <h3>
                            Dalam Kawasan Hutan
                        </h3>

                        <p>
                            Masukkan luas setiap kategori dalam satuan hektare
                        </p>

                    </div>

                </div>



                <div class="category-grid">


                    <div class="category-field sangat-kritis">

                        <label for="dalam_sangat_kritis">
                            Sangat Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="dalam_sangat_kritis"
                                name="dalam_sangat_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('dalam_sangat_kritis') is-invalid @enderror"
                                value="{{ old('dalam_sangat_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('dalam_sangat_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field kritis">

                        <label for="dalam_kritis">
                            Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="dalam_kritis"
                                name="dalam_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('dalam_kritis') is-invalid @enderror"
                                value="{{ old('dalam_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('dalam_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field agak-kritis">

                        <label for="dalam_agak_kritis">
                            Agak Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="dalam_agak_kritis"
                                name="dalam_agak_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('dalam_agak_kritis') is-invalid @enderror"
                                value="{{ old('dalam_agak_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('dalam_agak_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field potensial-kritis">

                        <label for="dalam_potensial_kritis">
                            Potensial Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="dalam_potensial_kritis"
                                name="dalam_potensial_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('dalam_potensial_kritis') is-invalid @enderror"
                                value="{{ old('dalam_potensial_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('dalam_potensial_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field tidak-kritis">

                        <label for="dalam_tidak_kritis">
                            Tidak Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="dalam_tidak_kritis"
                                name="dalam_tidak_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('dalam_tidak_kritis') is-invalid @enderror"
                                value="{{ old('dalam_tidak_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('dalam_tidak_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>


                </div>


                <div class="category-info">

                    <div class="category-info-code">
                        Ha
                    </div>

                    <div>
                        Isi angka <strong>0</strong> apabila tidak terdapat
                        luas lahan pada kategori tersebut.
                    </div>

                </div>


            </div>



            {{-- =================================================
                 03 LUAR KAWASAN HUTAN
            ================================================== --}}

            <div class="form-section">


                <div class="section-heading">

                    <div class="section-code">
                        03
                    </div>


                    <div>

                        <h3>
                            Luar Kawasan Hutan
                        </h3>

                        <p>
                            Masukkan luas setiap kategori dalam satuan hektare
                        </p>

                    </div>

                </div>



                <div class="category-grid">


                    <div class="category-field sangat-kritis">

                        <label for="luar_sangat_kritis">
                            Sangat Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="luar_sangat_kritis"
                                name="luar_sangat_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('luar_sangat_kritis') is-invalid @enderror"
                                value="{{ old('luar_sangat_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('luar_sangat_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field kritis">

                        <label for="luar_kritis">
                            Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="luar_kritis"
                                name="luar_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('luar_kritis') is-invalid @enderror"
                                value="{{ old('luar_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('luar_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field agak-kritis">

                        <label for="luar_agak_kritis">
                            Agak Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="luar_agak_kritis"
                                name="luar_agak_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('luar_agak_kritis') is-invalid @enderror"
                                value="{{ old('luar_agak_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('luar_agak_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field potensial-kritis">

                        <label for="luar_potensial_kritis">
                            Potensial Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="luar_potensial_kritis"
                                name="luar_potensial_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('luar_potensial_kritis') is-invalid @enderror"
                                value="{{ old('luar_potensial_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('luar_potensial_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>



                    <div class="category-field tidak-kritis">

                        <label for="luar_tidak_kritis">
                            Tidak Kritis
                        </label>

                        <div class="input-unit">

                            <input
                                type="number"
                                id="luar_tidak_kritis"
                                name="luar_tidak_kritis"
                                step="0.01"
                                min="0"
                                class="form-input @error('luar_tidak_kritis') is-invalid @enderror"
                                value="{{ old('luar_tidak_kritis', 0) }}"
                            >

                            <span>Ha</span>

                        </div>

                        @error('luar_tidak_kritis')
                            <div class="field-error">{{ $message }}</div>
                        @enderror

                    </div>


                </div>


                <div class="category-info">

                    <div class="category-info-code">
                        Ha
                    </div>

                    <div>
                        Total luas lahan akan dihitung otomatis oleh sistem
                        dari seluruh kategori yang dimasukkan.
                    </div>

                </div>


            </div>



            {{-- =================================================
                 ACTION
            ================================================== --}}

            <div class="form-actions">


                <a
                    href="/lahan-kritis"
                    class="form-btn btn-cancel"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="form-btn btn-save"
                >
                    Simpan Data
                </button>


            </div>


        </section>

    </form>


</div>

@endsection