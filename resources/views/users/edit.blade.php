@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('heading', 'Edit Pengguna')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/users/edit.css')
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
            Edit Pengguna
        </h2>


        <p class="hero-description">
            Perbarui informasi akun dan hak akses pengguna
            Sistem Informasi Ketahanan Pangan Malang Selatan.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                USER
            </div>


            <div>

                <div class="hero-summary-title">
                    Perbarui Data Pengguna
                </div>

                <div class="hero-summary-text">
                    Ubah identitas, hak akses, atau password akun
                    pengguna yang terdaftar pada sistem.
                </div>

            </div>

        </div>

    </div>


    <div class="hero-status">

        <span></span>


        <div>

            <strong>
                {{ $user->role === 'admin' ? 'Administrator' : 'Viewer' }}
            </strong>

            <small>
                Akun terdaftar
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
        action="/users/{{ $user->id }}"
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
                            Informasi Pengguna
                        </h3>

                        <div class="panel-subtitle">
                            Perbarui data akun pengguna
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    EDIT AKUN
                </div>

            </div>



            {{-- FORM BODY --}}

            <div class="form-body">


                {{-- AKUN YANG SEDANG DIEDIT --}}

                <div class="account-info">

                    <div class="account-avatar">

                        {{ strtoupper(substr($user->name, 0, 1)) }}

                    </div>


                    <div>

                        <div class="account-name">

                            {{ $user->name }}

                        </div>


                        <div class="account-email">

                            {{ $user->email }}

                        </div>

                    </div>

                </div>



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
                            value="{{ old('name', $user->name) }}"
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
                            value="{{ old('email', $user->email) }}"
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
                                value="admin"
                                {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                            >
                                Administrator
                            </option>


                            <option
                                value="viewer"
                                {{ old('role', $user->role) === 'viewer' ? 'selected' : '' }}
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
                            Password Baru
                        </label>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Kosongkan jika tidak ingin mengganti password"
                            minlength="6"
                        >


                        <div class="form-note">
                            Biarkan kosong jika password tidak ingin diubah.
                            Jika diganti, gunakan minimal 6 karakter.
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
                    Simpan Perubahan
                </button>


            </div>


        </section>

    </form>


</div>

@endsection