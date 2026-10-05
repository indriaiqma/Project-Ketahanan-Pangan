@extends(auth()->user()->role === 'viewer' ? 'layouts.viewer' : 'layouts.app')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')
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
   HERO PROFILE
========================================================= */

.hero-profile {
    width: fit-content;
    max-width: 650px;

    margin-top: 25px;
    padding: 11px 17px 11px 11px;

    display: flex;
    align-items: center;
    gap: 12px;

    background: rgba(234,245,238,.82);

    border: 1px solid #E0EEE5;
    border-radius: 11px;
}

.hero-avatar {
    width: 44px;
    height: 44px;
    min-width: 44px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #D9EEE1;

    color: #2F8B5A;

    font-size: 14px;
    font-weight: 800;
}

.hero-profile-name {
    margin-bottom: 3px;

    color: #254633;

    font-size: 12px;
    font-weight: 700;
}

.hero-profile-email {
    color: #77857C;

    font-size: 10px;
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
   PROFILE PAGE
========================================================= */

.profile-page {
    max-width: 1050px;
    margin: 0 auto 20px;
}


/* =========================================================
   ALERT
========================================================= */

.page-alert {
    margin-bottom: 18px;
    padding: 12px 14px;

    display: flex;
    align-items: flex-start;
    gap: 9px;

    border-radius: 9px;

    font-size: 10px;
}

.alert-success {
    background: #EFF8F2;

    border: 1px solid #D9EBDF;

    color: #347A55;
}

.alert-error {
    background: #FFF2F1;

    border: 1px solid #F0D6D3;

    color: #A94C47;
}

.alert-symbol {
    width: 25px;
    height: 25px;
    min-width: 25px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    font-size: 10px;
    font-weight: 800;
}

.alert-success .alert-symbol {
    background: #DCEFE3;
}

.alert-error .alert-symbol {
    background: #F8DEDC;
}

.alert-error strong {
    display: block;

    margin-bottom: 5px;
}

.alert-error ul {
    margin: 0;
    padding-left: 17px;

    line-height: 1.7;
}


/* =========================================================
   GRID
========================================================= */

.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;

    gap: 18px;

    align-items: start;
}


/* =========================================================
   PANEL
========================================================= */

.profile-panel {
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

    white-space: nowrap;
}

.panel-body {
    padding: 20px;
}


/* =========================================================
   FORM
========================================================= */

.form-group {
    margin-bottom: 17px;
}

.form-label {
    display: block;

    margin-bottom: 7px;

    color: #53655A;

    font-size: 10px;
    font-weight: 700;
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

    box-shadow: 0 0 0 3px rgba(105,190,139,.10);
}

.form-note {
    margin-top: 6px;

    color: #909A94;

    font-size: 9px;
    line-height: 1.5;
}


/* =========================================================
   SECURITY NOTE
========================================================= */

.security-note {
    margin-bottom: 18px;
    padding: 12px;

    display: flex;
    align-items: flex-start;
    gap: 9px;

    background: #F7FAF8;

    border: 1px solid #E2EBE5;
    border-radius: 8px;
}

.security-symbol {
    width: 30px;
    height: 30px;
    min-width: 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #E4F2E9;

    border-radius: 7px;

    color: #347A55;

    font-size: 9px;
    font-weight: 800;
}

.security-note strong {
    display: block;

    margin-bottom: 3px;

    color: #3A5846;

    font-size: 10px;
}

.security-note p {
    margin: 0;

    color: #7E8B83;

    font-size: 9px;
    line-height: 1.55;
}


/* =========================================================
   BUTTON
========================================================= */

.btn-save {
    width: 100%;
    min-height: 35px;

    border: 1px solid #3E9B68;
    border-radius: 7px;

    background: #3E9B68;

    color: #FFFFFF;

    font-family: inherit;

    font-size: 10px;
    font-weight: 700;

    cursor: pointer;

    transition: .18s;
}

.btn-save:hover {
    background: #34875B;

    border-color: #34875B;

    transform: translateY(-1px);
}


/* =========================================================
   ACCOUNT SUMMARY
========================================================= */

.account-panel {
    margin-top: 18px;
}

.account-info {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
}

.info-item {
    padding: 17px 20px;

    border-right: 1px solid #E8EDE9;
}

.info-item:last-child {
    border-right: none;
}

.info-label {
    margin-bottom: 5px;

    color: #929D96;

    font-size: 9px;
    font-weight: 800;

    text-transform: uppercase;
    letter-spacing: .4px;
}

.info-value {
    color: #405648;

    font-size: 10px;
    font-weight: 600;

    word-break: break-word;
}

.info-role {
    padding: 5px 9px;

    display: inline-flex;

    background: #EAF5EE;

    border-radius: 20px;

    color: #347A55;

    font-size: 9px;
    font-weight: 700;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 850px) {

    .profile-grid {
        grid-template-columns: 1fr;
    }

    .account-info {
        grid-template-columns: 1fr;
    }

    .info-item {
        border-right: none;
        border-bottom: 1px solid #E8EDE9;
    }

    .info-item:last-child {
        border-bottom: none;
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
}


@media(max-width: 500px) {

    .panel-header {
        padding: 15px 18px;
    }

    .panel-body {
        padding: 18px;
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