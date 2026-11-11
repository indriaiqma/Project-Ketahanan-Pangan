@extends('layouts.app')

@section('title', 'Tambah Kawasan Hutan')
@section('heading', 'Tambah Data Kawasan Hutan')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/kawasan-hutan/create.css')
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