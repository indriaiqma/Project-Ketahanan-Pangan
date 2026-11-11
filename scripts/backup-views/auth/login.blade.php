<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login - Sistem Informasi Ketahanan Pangan
    </title>


    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;

            font-family: Arial, sans-serif;

            background:
                linear-gradient(
                    120deg,
                    #F7FAF8 0%,
                    #F1F7F3 55%,
                    #EAF4ED 100%
                );

            color: #34483C;
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .login-page {
            position: relative;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 35px;

            overflow: hidden;
        }


        /* =====================================================
           BACKGROUND DECORATION
        ===================================================== */

        .background-shape {
            position: fixed;

            pointer-events: none;

            border-radius: 50%;
        }

        .shape-one {
            width: 420px;
            height: 420px;

            top: -190px;
            right: -130px;

            background: rgba(105,190,139,.10);
        }

        .shape-two {
            width: 330px;
            height: 330px;

            left: -150px;
            bottom: -150px;

            background: rgba(62,155,104,.08);
        }

        .shape-three {
            width: 170px;
            height: 170px;

            right: 12%;
            bottom: -90px;

            background: rgba(105,190,139,.07);
        }


        /* =====================================================
           LOGIN WRAPPER
        ===================================================== */

        .login-wrapper {
            position: relative;
            z-index: 2;

            width: 100%;
            max-width: 1050px;

            min-height: 590px;

            display: grid;
            grid-template-columns: 1.08fr .92fr;

            overflow: hidden;

            background: #FFFFFF;

            border: 1px solid #DEE8E1;
            border-radius: 18px;

            box-shadow:
                0 18px 55px rgba(32,59,44,.10);
        }


        /* =====================================================
           LEFT / BRAND
        ===================================================== */

        .brand-side {
            position: relative;

            padding: 48px 50px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #245F43 0%,
                    #256B4A 52%,
                    #31835A 100%
                );
        }


        /* DECORATION */

        .brand-decoration {
            position: absolute;

            pointer-events: none;

            border-radius: 50%;
        }

        .brand-decoration-one {
            width: 390px;
            height: 390px;

            right: -205px;
            bottom: -165px;

            background: rgba(255,255,255,.07);
        }

        .brand-decoration-two {
            width: 260px;
            height: 260px;

            right: -85px;
            bottom: -120px;

            border: 1px solid rgba(255,255,255,.10);
        }

        .brand-decoration-three {
            width: 160px;
            height: 160px;

            top: -75px;
            right: -45px;

            background: rgba(255,255,255,.045);
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .brand-logo {
            position: relative;
            z-index: 2;

            width: fit-content;

            padding: 11px 14px;

            background: rgba(255,255,255,.96);

            border-radius: 10px;

            box-shadow:
                0 7px 20px rgba(16,55,35,.10);
        }

        .brand-logo img {
            display: block;

            width: 190px;
            max-width: 100%;

            height: auto;
        }


        /* =====================================================
           BRAND CONTENT
        ===================================================== */

        .brand-content {
            position: relative;
            z-index: 2;

            max-width: 500px;

            margin-top: 45px;
        }

        .brand-label {
            display: flex;
            align-items: center;

            gap: 10px;

            margin-bottom: 17px;

            color: rgba(255,255,255,.72);

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1.2px;
        }

        .brand-label-line {
            width: 31px;
            height: 4px;

            border-radius: 10px;

            background: #7AC899;
        }

        .brand-content h1 {
            max-width: 490px;

            margin: 0 0 16px;

            color: #FFFFFF;

            font-size: 31px;
            font-weight: 750;

            line-height: 1.3;
        }

        .brand-content p {
            max-width: 440px;

            margin: 0;

            color: rgba(255,255,255,.72);

            font-size: 12px;
            line-height: 1.8;
        }


        /* =====================================================
           BRAND INFORMATION
        ===================================================== */

        .brand-info {
            position: relative;
            z-index: 2;

            margin-top: 35px;

            display: flex;
            align-items: center;

            gap: 12px;
        }

        .brand-info-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(255,255,255,.10);

            border: 1px solid rgba(255,255,255,.12);
            border-radius: 9px;

            color: #FFFFFF;

            font-size: 9px;
            font-weight: 800;
        }

        .brand-info strong {
            display: block;

            margin-bottom: 3px;

            color: #FFFFFF;

            font-size: 10px;
            font-weight: 700;
        }

        .brand-info span {
            display: block;

            color: rgba(255,255,255,.62);

            font-size: 9px;
            line-height: 1.5;
        }


        /* =====================================================
           BRAND FOOTER
        ===================================================== */

        .brand-footer {
            position: relative;
            z-index: 2;

            margin-top: 40px;

            color: rgba(255,255,255,.48);

            font-size: 9px;
        }


        /* =====================================================
           LOGIN SIDE
        ===================================================== */

        .form-side {
            padding: 55px 52px;

            display: flex;
            align-items: center;

            background: #FFFFFF;
        }

        .form-container {
            width: 100%;
            max-width: 355px;

            margin: 0 auto;
        }


        /* =====================================================
           FORM HEADER
        ===================================================== */

        .form-label-top {
            display: flex;
            align-items: center;

            gap: 8px;

            margin-bottom: 14px;

            color: #6E8075;

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1px;
        }

        .form-label-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #3E9B68;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h2 {
            margin: 0 0 9px;

            color: #173D2A;

            font-size: 25px;
            font-weight: 750;
        }

        .form-header p {
            margin: 0;

            color: #7C8981;

            font-size: 11px;
            line-height: 1.7;
        }


        /* =====================================================
           ERROR
        ===================================================== */

        .error-box {
            margin-bottom: 20px;
            padding: 11px 13px;

            display: flex;
            align-items: flex-start;

            gap: 9px;

            background: #FFF5F4;

            border: 1px solid #F0D7D4;
            border-left: 3px solid #D36A63;
            border-radius: 7px;

            color: #A3534D;

            font-size: 10px;
            line-height: 1.5;
        }

        .error-mark {
            width: 19px;
            height: 19px;
            min-width: 19px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #F5DFDD;

            border-radius: 50%;

            color: #B75D56;

            font-size: 9px;
            font-weight: 800;
        }


        /* =====================================================
           FORM
        ===================================================== */

        .form-group {
            margin-bottom: 17px;
        }

        .form-label {
            display: block;

            margin-bottom: 7px;

            color: #4B5F52;

            font-size: 10px;
            font-weight: 700;
        }

        .input-wrapper {
            position: relative;
        }

        .input-code {
            position: absolute;

            left: 11px;
            top: 50%;

            transform: translateY(-50%);

            width: 27px;
            height: 27px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #EDF6F0;

            border-radius: 6px;

            color: #47805C;

            font-size: 8px;
            font-weight: 800;

            pointer-events: none;
        }

        .form-control {
            width: 100%;
            height: 42px;

            padding: 0 12px 0 48px;

            background: #FFFFFF;

            border: 1px solid #DCE5DF;
            border-radius: 8px;

            color: #34483C;

            font-family: inherit;
            font-size: 10px;

            outline: none;

            transition: .18s;
        }

        .form-control::placeholder {
            color: #A1ABA5;
        }

        .form-control:focus {
            border-color: #69BE8B;

            box-shadow:
                0 0 0 3px rgba(62,155,104,.08);
        }


        /* =====================================================
           PASSWORD
        ===================================================== */

        .password-wrapper .form-control {
            padding-right: 55px;
        }

        .password-toggle {
            position: absolute;

            right: 10px;
            top: 50%;

            transform: translateY(-50%);

            padding: 5px 6px;

            background: transparent;

            border: none;

            color: #718078;

            font-family: inherit;
            font-size: 8px;
            font-weight: 700;

            cursor: pointer;
        }

        .password-toggle:hover {
            color: #3E8B5D;
        }


        /* =====================================================
           LOGIN BUTTON
        ===================================================== */

        .btn-login {
            width: 100%;
            height: 42px;

            margin-top: 7px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #3E9B68;

            border: 1px solid #3E9B68;
            border-radius: 8px;

            color: #FFFFFF;

            font-family: inherit;
            font-size: 10px;
            font-weight: 750;

            cursor: pointer;

            transition: .18s;
        }

        .btn-login:hover {
            background: #34875B;
            border-color: #34875B;

            transform: translateY(-1px);

            box-shadow:
                0 6px 15px rgba(62,155,104,.16);
        }

        .btn-login:active {
            transform: translateY(0);
        }


        /* =====================================================
           FORM INFORMATION
        ===================================================== */

        .login-info {
            margin-top: 20px;
            padding: 11px 12px;

            display: flex;
            align-items: center;

            gap: 10px;

            background: #F7FAF8;

            border: 1px solid #E6ECE8;
            border-radius: 8px;
        }

        .login-info-mark {
            width: 28px;
            height: 28px;
            min-width: 28px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #E8F4EC;

            border-radius: 6px;

            color: #43805B;

            font-size: 8px;
            font-weight: 800;
        }

        .login-info strong {
            display: block;

            margin-bottom: 2px;

            color: #506158;

            font-size: 9px;
        }

        .login-info span {
            display: block;

            color: #8A958F;

            font-size: 8px;
            line-height: 1.5;
        }


        /* =====================================================
           FORM FOOTER
        ===================================================== */

        .form-footer {
            margin-top: 28px;

            padding-top: 17px;

            border-top: 1px solid #EDF1EE;

            text-align: center;

            color: #98A29C;

            font-size: 8px;
            line-height: 1.6;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media(max-width: 850px) {

            .login-page {
                padding: 22px;
            }

            .login-wrapper {
                max-width: 520px;

                grid-template-columns: 1fr;
            }

            .brand-side {
                min-height: auto;

                padding: 32px;
            }

            .brand-content {
                margin-top: 35px;
            }

            .brand-content h1 {
                font-size: 27px;
            }

            .brand-info {
                display: none;
            }

            .brand-footer {
                margin-top: 30px;
            }

            .form-side {
                padding: 40px 32px;
            }

        }


        @media(max-width: 500px) {

            .login-page {
                align-items: flex-start;

                padding: 14px;
            }

            .login-wrapper {
                border-radius: 13px;
            }

            .brand-side {
                padding: 26px 22px;
            }

            .brand-logo img {
                width: 155px;
            }

            .brand-content {
                margin-top: 28px;
            }

            .brand-content h1 {
                font-size: 23px;
            }

            .brand-content p {
                font-size: 10px;
            }

            .brand-footer {
                margin-top: 25px;
            }

            .form-side {
                padding: 34px 22px;
            }

            .form-header h2 {
                font-size: 22px;
            }

        }

    </style>

</head>


<body>


<div class="login-page">


    {{-- BACKGROUND DECORATION --}}

    <div class="background-shape shape-one"></div>
    <div class="background-shape shape-two"></div>
    <div class="background-shape shape-three"></div>



    <main class="login-wrapper">


        {{-- =====================================================
             LEFT SIDE
        ===================================================== --}}

        <section class="brand-side">


            <div class="brand-decoration brand-decoration-one"></div>
            <div class="brand-decoration brand-decoration-two"></div>
            <div class="brand-decoration brand-decoration-three"></div>



            <div>


                {{-- LOGO --}}

                <div class="brand-logo">

                    <img
                        src="{{ asset('images/logo-bakorwil.png') }}"
                        alt="Logo Bakorwil III Malang"
                    >

                </div>



                {{-- CONTENT --}}

                <div class="brand-content">


                    <div class="brand-label">

                        <span class="brand-label-line"></span>

                        BAKORWIL III MALANG

                    </div>


                    <h1>
                        Sistem Informasi Ketahanan Pangan Malang Selatan
                    </h1>


                    <p>
                        Sistem informasi untuk mendukung pengelolaan dan
                        penyajian data ketahanan pangan wilayah Malang Selatan
                        di Bakorwil III Malang Provinsi Jawa Timur.
                    </p>


                </div>



                {{-- INFORMATION --}}

                <div class="brand-info">


                    <div class="brand-info-icon">
                        SI
                    </div>


                    <div>

                        <strong>
                            Sistem Informasi
                        </strong>

                        <span>
                            Akses sistem sesuai dengan hak akses pengguna.
                        </span>

                    </div>


                </div>


            </div>



            <div class="brand-footer">
                Bakorwil III Malang • Provinsi Jawa Timur
            </div>


        </section>



        {{-- =====================================================
             RIGHT SIDE
        ===================================================== --}}

        <section class="form-side">


            <div class="form-container">


                <div class="form-label-top">

                    <span class="form-label-dot"></span>

                    AKSES SISTEM

                </div>



                <div class="form-header">

                    <h2>
                        Selamat Datang
                    </h2>

                    <p>
                        Masukkan email dan password untuk masuk
                        ke Sistem Informasi Ketahanan Pangan.
                    </p>

                </div>



                {{-- ERROR --}}

                @if ($errors->any())

                    <div class="error-box">

                        <div class="error-mark">
                            !
                        </div>

                        <div>
                            {{ $errors->first() }}
                        </div>

                    </div>

                @endif



                {{-- LOGIN FORM --}}

                <form
                    action="/login"
                    method="POST"
                >

                    @csrf



                    {{-- EMAIL --}}

                    <div class="form-group">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email
                        </label>


                        <div class="input-wrapper">


                            <div class="input-code">
                                @
                            </div>


                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="Masukkan email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="email"
                            >


                        </div>

                    </div>



                    {{-- PASSWORD --}}

                    <div class="form-group">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password
                        </label>


                        <div class="input-wrapper password-wrapper">


                            <div class="input-code">
                                PW
                            </div>


                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                            >


                            <button
                                type="button"
                                class="password-toggle"
                                id="passwordToggle"
                                onclick="togglePassword()"
                            >
                                LIHAT
                            </button>


                        </div>

                    </div>



                    {{-- LOGIN BUTTON --}}

                    <button
                        type="submit"
                        class="btn-login"
                    >
                        Masuk ke Sistem
                    </button>


                </form>



                {{-- INFORMATION --}}

                <div class="login-info">


                    <div class="login-info-mark">
                        AK
                    </div>


                    <div>

                        <strong>
                            Akses Pengguna
                        </strong>

                        <span>
                            Gunakan akun yang telah terdaftar untuk mengakses sistem.
                        </span>

                    </div>


                </div>



                <div class="form-footer">
                    Sistem Informasi Ketahanan Pangan Malang Selatan<br>
                    Bakorwil III Malang Provinsi Jawa Timur
                </div>


            </div>


        </section>


    </main>


</div>



<script>

    function togglePassword() {

        const passwordInput =
            document.getElementById('password');

        const passwordToggle =
            document.getElementById('passwordToggle');


        if (passwordInput.type === 'password') {

            passwordInput.type = 'text';

            passwordToggle.textContent = 'SEMBUNYIKAN';

        } else {

            passwordInput.type = 'password';

            passwordToggle.textContent = 'LIHAT';

        }

    }

</script>


</body>

</html>