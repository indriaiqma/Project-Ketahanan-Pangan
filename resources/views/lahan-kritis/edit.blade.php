@extends('layouts.app')

@section('title', 'Edit Data Lahan Kritis')
@section('heading', 'Edit Data Lahan Kritis')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/lahan-kritis/edit.css')
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
            Edit Data Lahan Kritis
        </h2>


        <p class="hero-description">
            Perbarui informasi kondisi lahan kritis Kecamatan
            {{ $lahanKritis->kecamatan }} apabila terdapat perubahan,
            koreksi, atau penyesuaian data.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                LK
            </div>


            <div>

                <div class="hero-summary-title">
                    Kecamatan {{ $lahanKritis->kecamatan }}
                </div>

                <div class="hero-summary-text">
                    {{ $lahanKritis->kabupaten ?? 'Kabupaten Malang' }}
                </div>

            </div>

        </div>

    </div>


    <div class="hero-status">

        <span></span>


        <div>

            <strong>
                Mode Edit
            </strong>

            <small>
                Administrator
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
                Perubahan belum berhasil disimpan. Periksa kembali:
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

    <form
        action="/lahan-kritis/{{ $lahanKritis->id }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        <section class="form-panel">


            {{-- PANEL HEADER --}}

            <div class="panel-header">

                <div class="panel-title-wrap">

                    <span class="panel-mark"></span>


                    <div>

                        <h3 class="panel-title">
                            Form Edit Lahan Kritis
                        </h3>

                        <div class="panel-subtitle">
                            Periksa kembali data sebelum menyimpan perubahan
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    EDIT DATA
                </div>

            </div>



            {{-- CURRENT DATA --}}

            <div class="current-data">


                <div>

                    <span class="current-label">
                        Data yang sedang diedit
                    </span>

                    <div class="current-value">
                        Kecamatan {{ $lahanKritis->kecamatan }}
                    </div>

                    <div class="current-sub">
                        {{ $lahanKritis->kabupaten ?? 'Kabupaten Malang' }}
                    </div>

                </div>


                <div class="current-total">

                    <span class="current-label">
                        Total Luas
                    </span>

                    <strong>
                        {{ number_format($lahanKritis->total_ha ?? 0, 2, ',', '.') }} Ha
                    </strong>

                    <small>
                        Data saat ini
                    </small>

                </div>


                <div class="current-badge">
                    LAHAN KRITIS
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
                            Lokasi administratif data lahan kritis
                        </p>

                    </div>

                </div>



                <div class="form-grid">


                    <div class="form-group">

                        <label
                            for="kabupaten"
                            class="form-label"
                        >
                            Kabupaten
                            <span class="required">*</span>
                        </label>


                        <input
                            type="text"
                            id="kabupaten"
                            name="kabupaten"
                            class="form-input @error('kabupaten') is-invalid @enderror"
                            value="{{ old('kabupaten', $lahanKritis->kabupaten) }}"
                            required
                        >


                        @error('kabupaten')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group">

                        <label
                            for="kecamatan"
                            class="form-label"
                        >
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

                            <option
                                value="Ampelgading"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Ampelgading' ? 'selected' : '' }}
                            >
                                Ampelgading
                            </option>

                            <option
                                value="Bantur"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Bantur' ? 'selected' : '' }}
                            >
                                Bantur
                            </option>

                            <option
                                value="Dampit"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Dampit' ? 'selected' : '' }}
                            >
                                Dampit
                            </option>

                            <option
                                value="Donomulyo"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Donomulyo' ? 'selected' : '' }}
                            >
                                Donomulyo
                            </option>

                            <option
                                value="Gedangan"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Gedangan' ? 'selected' : '' }}
                            >
                                Gedangan
                            </option>

                            <option
                                value="Kalipare"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Kalipare' ? 'selected' : '' }}
                            >
                                Kalipare
                            </option>

                            <option
                                value="Pagak"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Pagak' ? 'selected' : '' }}
                            >
                                Pagak
                            </option>

                            <option
                                value="Sumbermanjing Wetan"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Sumbermanjing Wetan' ? 'selected' : '' }}
                            >
                                Sumbermanjing Wetan
                            </option>

                            <option
                                value="Tirtoyudo"
                                {{ old('kecamatan', $lahanKritis->kecamatan) == 'Tirtoyudo' ? 'selected' : '' }}
                            >
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
                 02 DALAM KAWASAN
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
                            Perbarui luas setiap kategori dalam satuan hektare
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
                                value="{{ old('dalam_sangat_kritis', $lahanKritis->dalam_sangat_kritis) }}"
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
                                value="{{ old('dalam_kritis', $lahanKritis->dalam_kritis) }}"
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
                                value="{{ old('dalam_agak_kritis', $lahanKritis->dalam_agak_kritis) }}"
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
                                value="{{ old('dalam_potensial_kritis', $lahanKritis->dalam_potensial_kritis) }}"
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
                                value="{{ old('dalam_tidak_kritis', $lahanKritis->dalam_tidak_kritis) }}"
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
                        Ubah hanya data yang perlu diperbarui.
                        Gunakan nilai <strong>0</strong> apabila kategori tidak memiliki luas lahan.
                    </div>

                </div>


            </div>



            {{-- =================================================
                 03 LUAR KAWASAN
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
                            Perbarui luas setiap kategori dalam satuan hektare
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
                                value="{{ old('luar_sangat_kritis', $lahanKritis->luar_sangat_kritis) }}"
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
                                value="{{ old('luar_kritis', $lahanKritis->luar_kritis) }}"
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
                                value="{{ old('luar_agak_kritis', $lahanKritis->luar_agak_kritis) }}"
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
                                value="{{ old('luar_potensial_kritis', $lahanKritis->luar_potensial_kritis) }}"
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
                                value="{{ old('luar_tidak_kritis', $lahanKritis->luar_tidak_kritis) }}"
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
                        Setelah perubahan disimpan, total luas akan dihitung
                        kembali oleh sistem berdasarkan seluruh kategori.
                    </div>

                </div>


            </div>



            {{-- =================================================
                 ACTION
            ================================================== --}}

            <div class="form-actions">


                <a
                    href="/lahan-kritis"
                    class="form-btn btn-back"
                >
                    Kembali
                </a>


                <div class="action-right">


                    <a
                        href="/lahan-kritis/{{ $lahanKritis->id }}"
                        class="form-btn btn-detail"
                    >
                        Lihat Detail
                    </a>


                    <button
                        type="submit"
                        class="form-btn btn-save"
                    >
                        Simpan Perubahan
                    </button>


                </div>


            </div>


        </section>


    </form>


</div>

@endsection