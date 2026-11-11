@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('heading', 'Tambah Pengguna')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/users/create.css')
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

            ADMINISTRASI SISTEM

        </div>


        <h2>
            Tambah Pengguna
        </h2>


        <p class="hero-description">
            Tambahkan akun baru dan tentukan hak akses pengguna
            Sistem Informasi Ketahanan Pangan Malang Selatan.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                USER
            </div>


            <div>

                <div class="hero-summary-title">
                    Pengguna Baru
                </div>

                <div class="hero-summary-text">
                    Lengkapi identitas pengguna, tentukan hak akses,
                    dan buat password untuk akun baru.
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
                Manajemen pengguna
            </small>

        </div>

    </div>

</section>



{{-- =========================================================
     FORM
========================================================= --}}

<div class="user-form-container">


    {{-- ERROR VALIDASI --}}

    @if ($errors->any())

    <div class="alert-error">

        <div class="alert-error-icon">
            !
        </div>


        <div>

            <strong>
                Data belum berhasil disimpan. Periksa kembali:
            </strong>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    </div>

    @endif



    <form
        action="/users"
        method="POST"
    >

        @csrf


        <section class="form-panel">


            {{-- HEADER --}}

            <div class="panel-header">

                <div class="panel-title-wrap">

                    <span class="panel-mark"></span>


                    <div>

                        <h3 class="panel-title">
                            Informasi Pengguna
                        </h3>

                        <div class="panel-subtitle">
                            Lengkapi data akun pengguna baru
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    AKUN BARU
                </div>

            </div>



            {{-- FORM BODY --}}

            <div class="form-body">


                <div class="form-grid">


                    {{-- NAMA --}}

                    <div class="form-group">

                        <label
                            for="name"
                            class="form-label"
                        >
                            Nama Pengguna
                            <span class="required">*</span>
                        </label>


                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama pengguna"
                            required
                        >


                        @error('name')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>



                    {{-- EMAIL --}}

                    <div class="form-group">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email
                            <span class="required">*</span>
                        </label>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="contoh@bakorwil.local"
                            required
                        >


                        @error('email')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>



                    {{-- HAK AKSES --}}

                    <div class="form-group full-width">

                        <label
                            for="role"
                            class="form-label"
                        >
                            Hak Akses
                            <span class="required">*</span>
                        </label>


                        <select
                            id="role"
                            name="role"
                            class="form-control @error('role') is-invalid @enderror"
                            required
                        >

                            <option
                                value=""
                                disabled
                                {{ old('role') ? '' : 'selected' }}
                            >
                                -- Pilih Hak Akses --
                            </option>


                            <option
                                value="admin"
                                {{ old('role') == 'admin' ? 'selected' : '' }}
                            >
                                Administrator
                            </option>


                            <option
                                value="viewer"
                                {{ old('role') == 'viewer' ? 'selected' : '' }}
                            >
                                Viewer
                            </option>

                        </select>


                        @error('role')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                        @enderror



                        <div class="role-info">


                            <div class="role-item">

                                <div class="role-icon">
                                    A
                                </div>


                                <div class="role-text">

                                    <strong>
                                        Administrator
                                    </strong>

                                    <span>
                                        Dapat menambah, mengubah, menghapus,
                                        import/export data, dan mengelola pengguna.
                                    </span>

                                </div>

                            </div>



                            <div class="role-item">

                                <div class="role-icon">
                                    V
                                </div>


                                <div class="role-text">

                                    <strong>
                                        Viewer
                                    </strong>

                                    <span>
                                        Dapat melihat dashboard, data, grafik,
                                        detail, pencarian, dan filter tanpa
                                        mengubah data.
                                    </span>

                                </div>

                            </div>


                        </div>

                    </div>



                    {{-- PASSWORD --}}

                    <div class="form-group full-width">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password
                            <span class="required">*</span>
                        </label>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            minlength="6"
                            required
                        >


                        <div class="form-note">
                            Gunakan password minimal 6 karakter.
                        </div>


                        @error('password')

                        <div class="field-error">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                </div>

            </div>



            {{-- =====================================================
                 ACTION
            ===================================================== --}}

            <div class="form-actions">


                <a
                    href="/users"
                    class="form-btn btn-back"
                >
                    Kembali
                </a>


                <button
                    type="submit"
                    class="form-btn btn-save"
                >
                    Simpan Pengguna
                </button>


            </div>


        </section>

    </form>


</div>

@endsection