@extends('layouts.app')

@section('title', 'Tambah Data Lahan Kritis')
@section('heading', 'Tambah Data Lahan Kritis')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/lahan-kritis/create.css')
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