@extends('layouts.app')

@section('title', 'Edit Kawasan Hutan')
@section('heading', 'Edit Data Kawasan Hutan')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/kawasan-hutan/edit.css')
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
            Edit Data Kawasan Hutan
        </h2>


        <p class="hero-description">
            Perbarui informasi kawasan hutan apabila terdapat perubahan,
            koreksi, atau penyesuaian data yang tersimpan dalam sistem.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                KH
            </div>


            <div>

                <div class="hero-summary-title">
                    {{ $kawasanHutan->nama_kawasan ?? 'Kawasan Hutan' }}
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
                Perubahan belum berhasil disimpan. Periksa kembali isian berikut:
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
        action="/kawasan-hutan/{{ $kawasanHutan->id }}"
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
                            Form Edit Kawasan Hutan
                        </h3>

                        <div class="panel-subtitle">
                            Periksa kembali informasi sebelum menyimpan perubahan
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    EDIT DATA
                </div>

            </div>



            {{-- =================================================
                 CURRENT DATA
            ================================================== --}}

            <div class="current-data">


                <div class="current-data-left">

                    <span class="current-label">
                        Data yang sedang diedit
                    </span>


                    <div class="current-name">
                        {{ $kawasanHutan->nama_kawasan ?? '-' }}
                    </div>


                    <div class="current-location">

                        {{ $kawasanHutan->desa ?? '-' }}

                        &nbsp;•&nbsp;

                        {{ $kawasanHutan->kecamatan ?? '-' }}

                    </div>

                </div>


                <div class="current-type">
                    {{ $kawasanHutan->jenis_kawasan ?? 'Kawasan Hutan' }}
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
                            value="{{ old('kabupaten', $kawasanHutan->kabupaten) }}"
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


                        <input
                            type="text"
                            id="kecamatan"
                            name="kecamatan"
                            class="form-input @error('kecamatan') is-invalid @enderror"
                            value="{{ old('kecamatan', $kawasanHutan->kecamatan) }}"
                            required
                        >


                        @error('kecamatan')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group full">

                        <label
                            for="desa"
                            class="form-label"
                        >
                            Desa
                        </label>


                        <input
                            type="text"
                            id="desa"
                            name="desa"
                            class="form-input @error('desa') is-invalid @enderror"
                            value="{{ old('desa', $kawasanHutan->desa) }}"
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

                        <label
                            for="nama_kawasan"
                            class="form-label"
                        >
                            Nama Kawasan
                            <span class="required">*</span>
                        </label>


                        <input
                            type="text"
                            id="nama_kawasan"
                            name="nama_kawasan"
                            class="form-input @error('nama_kawasan') is-invalid @enderror"
                            value="{{ old('nama_kawasan', $kawasanHutan->nama_kawasan) }}"
                            required
                        >


                        @error('nama_kawasan')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group">

                        <label
                            for="jenis_kawasan"
                            class="form-label"
                        >
                            Jenis Kawasan
                            <span class="required">*</span>
                        </label>


                        <input
                            type="text"
                            id="jenis_kawasan"
                            name="jenis_kawasan"
                            class="form-input @error('jenis_kawasan') is-invalid @enderror"
                            value="{{ old('jenis_kawasan', $kawasanHutan->jenis_kawasan) }}"
                            required
                        >


                        @error('jenis_kawasan')

                            <div class="field-error">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>



                    <div class="form-group full">

                        <label
                            for="luas_ha"
                            class="form-label"
                        >
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
                                value="{{ old('luas_ha', $kawasanHutan->luas_ha) }}"
                            >


                            <span>
                                Ha
                            </span>

                        </div>


                        <div class="form-hint">
                            Luas kawasan dalam satuan hektare.
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
                            Catatan atau informasi pendukung mengenai kawasan
                        </p>

                    </div>

                </div>



                <div class="form-group">

                    <label
                        for="keterangan"
                        class="form-label"
                    >
                        Keterangan
                    </label>


                    <textarea
                        id="keterangan"
                        name="keterangan"
                        class="form-textarea @error('keterangan') is-invalid @enderror"
                        placeholder="Tuliskan keterangan tambahan apabila diperlukan..."
                    >{{ old('keterangan', $kawasanHutan->keterangan) }}</textarea>


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
                    class="form-btn btn-back"
                >
                    Kembali
                </a>



                <div class="action-right">


                    <a
                        href="/kawasan-hutan/{{ $kawasanHutan->id }}"
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