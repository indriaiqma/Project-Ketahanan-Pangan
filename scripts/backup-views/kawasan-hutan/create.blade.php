@extends('layouts.app')

@section('title', 'Tambah Kawasan Hutan')
@section('heading', 'Tambah Data Kawasan Hutan')
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
    max-width: 1000px;
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
   GRID
========================================================= */

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px;
}

.form-group {
    min-width: 0;
}

.form-group.full {
    grid-column: 1 / -1;
}


/* =========================================================
   INPUT
========================================================= */

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
.form-textarea {
    width: 100%;
    box-sizing: border-box;

    padding: 9px 11px;

    background: #FFFFFF;
    border: 1px solid #DCE5DF;
    border-radius: 7px;

    color: #34483C;
    font-family: inherit;
    font-size: 10px;

    outline: none;
    transition: .18s;
}

.form-input {
    height: 36px;
}

.form-input:focus,
.form-textarea:focus {
    border-color: #69BE8B;
    box-shadow: 0 0 0 3px rgba(62,155,104,.08);
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: #A3ADA6;
}

.form-textarea {
    min-height: 95px;
    resize: vertical;
    line-height: 1.6;
}

.form-hint {
    margin-top: 5px;

    color: #929D96;
    font-size: 9px;
    line-height: 1.5;
}

.field-error {
    margin-top: 5px;

    color: #BE5953;
    font-size: 9px;
}

.form-input.is-invalid,
.form-textarea.is-invalid {
    border-color: #D36A63;
}


/* =========================================================
   UNIT
========================================================= */

.input-unit {
    position: relative;
}

.input-unit .form-input {
    padding-right: 43px;
}

.input-unit span {
    position: absolute;
    right: 11px;
    top: 50%;

    transform: translateY(-50%);

    color: #7C8A81;
    font-size: 9px;
    font-weight: 700;

    pointer-events: none;
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

    .form-group.full {
        grid-column: auto;
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
            Tambah Data Kawasan Hutan
        </h2>


        <p class="hero-description">
            Tambahkan informasi kawasan hutan berdasarkan lokasi,
            identitas kawasan, jenis kawasan, luas wilayah, dan
            keterangan pendukung.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                KH
            </div>


            <div>

                <div class="hero-summary-title">
                    Data Kawasan Baru
                </div>

                <div class="hero-summary-text">
                    Lengkapi formulir sebelum menyimpan data ke dalam sistem.
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
         VALIDATION ERROR
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

    <form action="/kawasan-hutan" method="POST">

        @csrf


        <section class="form-panel">


            {{-- PANEL HEADER --}}

            <div class="panel-header">

                <div class="panel-title-wrap">

                    <span class="panel-mark"></span>


                    <div>

                        <h3 class="panel-title">
                            Form Kawasan Hutan
                        </h3>

                        <div class="panel-subtitle">
                            Isi informasi kawasan hutan dengan data yang sesuai
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    DATA BARU
                </div>

            </div>



            {{-- =================================================
                 INFORMASI WILAYAH
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
                            Lokasi administratif kawasan hutan
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


                        <input
                            type="text"
                            id="kecamatan"
                            name="kecamatan"
                            class="form-input @error('kecamatan') is-invalid @enderror"
                            value="{{ old('kecamatan') }}"
                            placeholder="Contoh: Sumbermanjing Wetan"
                            required
                        >


                        @error('kecamatan')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group full">

                        <label for="desa" class="form-label">
                            Desa
                        </label>


                        <input
                            type="text"
                            id="desa"
                            name="desa"
                            class="form-input @error('desa') is-invalid @enderror"
                            value="{{ old('desa') }}"
                            placeholder="Contoh: Tambakrejo"
                        >


                        @error('desa')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                </div>

            </div>



            {{-- =================================================
                 INFORMASI KAWASAN
            ================================================== --}}

            <div class="form-section">


                <div class="section-heading">

                    <div class="section-code">
                        02
                    </div>


                    <div>

                        <h3>
                            Informasi Kawasan
                        </h3>

                        <p>
                            Identitas, jenis, dan luas kawasan hutan
                        </p>

                    </div>

                </div>



                <div class="form-grid">


                    <div class="form-group">

                        <label for="nama_kawasan" class="form-label">

                            Nama Kawasan
                            <span class="required">*</span>

                        </label>


                        <input
                            type="text"
                            id="nama_kawasan"
                            name="nama_kawasan"
                            class="form-input @error('nama_kawasan') is-invalid @enderror"
                            value="{{ old('nama_kawasan') }}"
                            placeholder="Contoh: CA Pulau Sempu"
                            required
                        >


                        @error('nama_kawasan')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group">

                        <label for="jenis_kawasan" class="form-label">

                            Jenis Kawasan
                            <span class="required">*</span>

                        </label>


                        <input
                            type="text"
                            id="jenis_kawasan"
                            name="jenis_kawasan"
                            class="form-input @error('jenis_kawasan') is-invalid @enderror"
                            value="{{ old('jenis_kawasan') }}"
                            placeholder="Contoh: Cagar Alam"
                            required
                        >


                        @error('jenis_kawasan')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group full">

                        <label for="luas_ha" class="form-label">
                            Luas Kawasan
                        </label>


                        <div class="input-unit">

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                id="luas_ha"
                                name="luas_ha"
                                class="form-input @error('luas_ha') is-invalid @enderror"
                                value="{{ old('luas_ha') }}"
                                placeholder="Contoh: 877"
                            >

                            <span>
                                Ha
                            </span>

                        </div>


                        <div class="form-hint">
                            Masukkan luas kawasan dalam satuan hektare.
                        </div>


                        @error('luas_ha')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                </div>

            </div>



            {{-- =================================================
                 KETERANGAN
            ================================================== --}}

            <div class="form-section">


                <div class="section-heading">

                    <div class="section-code">
                        03
                    </div>


                    <div>

                        <h3>
                            Keterangan Tambahan
                        </h3>

                        <p>
                            Informasi pendukung atau catatan mengenai kawasan
                        </p>

                    </div>

                </div>



                <div class="form-group">

                    <label for="keterangan" class="form-label">
                        Keterangan
                    </label>


                    <textarea
                        id="keterangan"
                        name="keterangan"
                        class="form-textarea @error('keterangan') is-invalid @enderror"
                        placeholder="Tuliskan keterangan tambahan apabila diperlukan..."
                    >{{ old('keterangan') }}</textarea>


                    @error('keterangan')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


            </div>



            {{-- =================================================
                 ACTION
            ================================================== --}}

            <div class="form-actions">


                <a
                    href="/kawasan-hutan"
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