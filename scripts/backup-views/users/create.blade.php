@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('heading', 'Tambah Pengguna')
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


/* =========================================================
   HERO SUMMARY
========================================================= */

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


/* =========================================================
   HERO STATUS
========================================================= */

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


/* =========================================================
   DECORATION
========================================================= */

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
   FORM CONTAINER
========================================================= */

.user-form-container {
    max-width: 900px;
    margin: 0 auto 20px;
}


/* =========================================================
   ERROR
========================================================= */

.alert-error {
    margin-bottom: 18px;
    padding: 13px 15px;

    display: flex;
    align-items: flex-start;
    gap: 10px;

    background: #FFF2F1;

    border: 1px solid #F0D6D3;
    border-radius: 9px;

    color: #A94C47;

    font-size: 10px;
}

.alert-error-icon {
    width: 26px;
    height: 26px;
    min-width: 26px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    background: #F8DEDC;

    font-size: 11px;
    font-weight: 800;
}

.alert-error strong {
    display: block;

    margin-bottom: 5px;

    font-size: 10px;
}

.alert-error ul {
    margin: 0;
    padding-left: 17px;

    line-height: 1.7;
}


/* =========================================================
   PANEL
========================================================= */

.form-panel {
    overflow: hidden;

    background: #FFFFFF;

    border: 1px solid #E1E9E4;
    border-radius: 12px;

    box-shadow: 0 4px 16px rgba(32,59,44,.035);
}

.panel-header {
    min-height: 65px;

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
   FORM
========================================================= */

.form-body {
    padding: 23px 20px 25px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);

    gap: 19px 18px;
}

.form-group {
    min-width: 0;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: block;

    margin-bottom: 7px;

    color: #53655A;

    font-size: 10px;
    font-weight: 700;
}

.required {
    margin-left: 2px;

    color: #C85C54;
}

.form-control {
    width: 100%;
    height: 38px;

    box-sizing: border-box;

    padding: 0 11px;

    background: #FFFFFF;

    border: 1px solid #DCE5DF;
    border-radius: 7px;

    outline: none;

    color: #3F5146;

    font-family: inherit;
    font-size: 10px;

    transition: .18s;
}

.form-control::placeholder {
    color: #A2ABA5;
}

.form-control:focus {
    border-color: #69BE8B;

    box-shadow:
        0 0 0 3px rgba(105,190,139,.10);
}

.form-control.is-invalid {
    border-color: #D36A63;
}

.field-error {
    margin-top: 5px;

    color: #B54B47;

    font-size: 9px;
}

.form-note {
    margin-top: 6px;

    color: #909A94;

    font-size: 9px;
    line-height: 1.5;
}


/* =========================================================
   ROLE INFORMATION
========================================================= */

.role-info {
    margin-top: 10px;

    display: grid;
    grid-template-columns: repeat(2, 1fr);

    gap: 9px;
}

.role-item {
    padding: 12px;

    display: flex;
    align-items: flex-start;
    gap: 9px;

    background: #F7FAF8;

    border: 1px solid #E2EBE5;
    border-radius: 8px;
}

.role-icon {
    width: 29px;
    height: 29px;
    min-width: 29px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    background: #E4F2E9;

    color: #347A55;

    font-size: 10px;
    font-weight: 800;
}

.role-text strong {
    display: block;

    margin-bottom: 3px;

    color: #3A5846;

    font-size: 10px;
}

.role-text span {
    display: block;

    color: #7E8B83;

    font-size: 9px;
    line-height: 1.55;
}


/* =========================================================
   FORM ACTION
========================================================= */

.form-actions {
    padding: 15px 20px;

    display: flex;
    justify-content: flex-end;
    align-items: center;

    gap: 7px;

    background: #FBFCFB;

    border-top: 1px solid #E8EDE9;
}

.form-btn {
    min-height: 34px;

    padding: 0 13px;

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

.btn-back {
    background: #FFFFFF;

    border-color: #DCE5DF;

    color: #617067;
}

.btn-back:hover {
    background: #F5F8F6;
}

.btn-save {
    background: #3E9B68;

    border-color: #3E9B68;

    color: #FFFFFF;
}

.btn-save:hover {
    background: #34875B;
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

    .form-group.full-width {
        grid-column: auto;
    }

    .role-info {
        grid-template-columns: 1fr;
    }

    .panel-header {
        padding: 15px 18px;
    }

    .form-body {
        padding: 20px 18px;
    }

    .form-actions {
        padding: 15px 18px;
    }
}

@media(max-width: 500px) {

    .form-actions {
        flex-direction: column-reverse;
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