@extends(auth()->user()->role === 'viewer' ? 'layouts.viewer' : 'layouts.app')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/profile/index.css')
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

            AKUN PENGGUNA

        </div>


        <h2>
            Profil Saya
        </h2>


        <p class="hero-description">
            Kelola informasi profil dan keamanan akun yang digunakan
            untuk mengakses Sistem Informasi Ketahanan Pangan Malang Selatan.
        </p>


        <div class="hero-profile">

            <div class="hero-avatar">

                {{ strtoupper(substr($user->name, 0, 1)) }}

            </div>


            <div>

                <div class="hero-profile-name">

                    {{ $user->name }}

                </div>


                <div class="hero-profile-email">

                    {{ $user->email }}

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
                Akun aktif
            </small>

        </div>

    </div>

</section>



<div class="profile-page">


    {{-- =====================================================
         ALERT
    ===================================================== --}}

    @if(session('success'))

    <div class="page-alert alert-success">

        <div class="alert-symbol">
            ✓
        </div>

        <div>
            {{ session('success') }}
        </div>

    </div>

    @endif



    @if($errors->any())

    <div class="page-alert alert-error">

        <div class="alert-symbol">
            !
        </div>


        <div>

            <strong>
                Periksa kembali data yang dimasukkan.
            </strong>


            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    </div>

    @endif



    {{-- =====================================================
         PROFILE GRID
    ===================================================== --}}

    <div class="profile-grid">


        {{-- =================================================
             INFORMASI PROFIL
        ================================================== --}}

        <section class="profile-panel">


            <div class="panel-header">

                <div class="panel-title-wrap">

                    <span class="panel-mark"></span>


                    <div>

                        <h3 class="panel-title">
                            Informasi Profil
                        </h3>

                        <div class="panel-subtitle">
                            Perbarui nama dan alamat email akun
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    PROFIL
                </div>

            </div>



            <div class="panel-body">


                <form
                    action="/profile"
                    method="POST"
                >

                    @csrf
                    @method('PUT')


                    {{-- NAMA --}}

                    <div class="form-group">

                        <label
                            for="name"
                            class="form-label"
                        >
                            Nama Pengguna
                        </label>


                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            placeholder="Masukkan nama pengguna"
                            required
                        >

                    </div>



                    {{-- EMAIL --}}

                    <div class="form-group">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email
                        </label>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Masukkan alamat email"
                            required
                        >

                    </div>



                    <button
                        type="submit"
                        class="btn-save"
                    >
                        Simpan Perubahan Profil
                    </button>


                </form>


            </div>


        </section>



        {{-- =================================================
             KEAMANAN AKUN
        ================================================== --}}

        <section class="profile-panel">


            <div class="panel-header">

                <div class="panel-title-wrap">

                    <span class="panel-mark"></span>


                    <div>

                        <h3 class="panel-title">
                            Keamanan Akun
                        </h3>

                        <div class="panel-subtitle">
                            Perbarui password akun yang digunakan
                        </div>

                    </div>

                </div>


                <div class="panel-badge">
                    KEAMANAN
                </div>

            </div>



            <div class="panel-body">


                <div class="security-note">

                    <div class="security-symbol">
                        PW
                    </div>


                    <div>

                        <strong>
                            Keamanan Password
                        </strong>

                        <p>
                            Masukkan password lama sebelum membuat
                            password baru.
                        </p>

                    </div>

                </div>



                <form
                    action="/profile/password"
                    method="POST"
                >

                    @csrf
                    @method('PUT')


                    {{-- PASSWORD LAMA --}}

                    <div class="form-group">

                        <label
                            for="password_lama"
                            class="form-label"
                        >
                            Password Lama
                        </label>


                        <input
                            type="password"
                            id="password_lama"
                            name="password_lama"
                            class="form-control"
                            placeholder="Masukkan password lama"
                            required
                        >

                    </div>



                    {{-- PASSWORD BARU --}}

                    <div class="form-group">

                        <label
                            for="password_baru"
                            class="form-label"
                        >
                            Password Baru
                        </label>


                        <input
                            type="password"
                            id="password_baru"
                            name="password_baru"
                            class="form-control"
                            placeholder="Masukkan password baru"
                            minlength="6"
                            required
                        >


                        <div class="form-note">
                            Gunakan minimal 6 karakter.
                        </div>

                    </div>



                    {{-- KONFIRMASI --}}

                    <div class="form-group">

                        <label
                            for="password_baru_confirmation"
                            class="form-label"
                        >
                            Konfirmasi Password Baru
                        </label>


                        <input
                            type="password"
                            id="password_baru_confirmation"
                            name="password_baru_confirmation"
                            class="form-control"
                            placeholder="Ulangi password baru"
                            minlength="6"
                            required
                        >

                    </div>



                    <button
                        type="submit"
                        class="btn-save"
                    >
                        Perbarui Password
                    </button>


                </form>


            </div>


        </section>


    </div>



    {{-- =====================================================
         INFORMASI AKUN
    ===================================================== --}}

    <section class="profile-panel account-panel">


        <div class="panel-header">

            <div class="panel-title-wrap">

                <span class="panel-mark"></span>


                <div>

                    <h3 class="panel-title">
                        Informasi Akun
                    </h3>

                    <div class="panel-subtitle">
                        Ringkasan akun yang sedang digunakan untuk mengakses sistem
                    </div>

                </div>

            </div>


            <div class="panel-badge">
                AKUN AKTIF
            </div>

        </div>



        <div class="account-info">


            <div class="info-item">

                <div class="info-label">
                    Nama
                </div>

                <div class="info-value">
                    {{ $user->name }}
                </div>

            </div>



            <div class="info-item">

                <div class="info-label">
                    Email
                </div>

                <div class="info-value">
                    {{ $user->email }}
                </div>

            </div>



            <div class="info-item">

                <div class="info-label">
                    Hak Akses
                </div>

                <div class="info-value">

                    <span class="info-role">

                        {{ $user->role === 'admin' ? 'Administrator' : 'Viewer' }}

                    </span>

                </div>

            </div>


        </div>


    </section>


</div>

@endsection