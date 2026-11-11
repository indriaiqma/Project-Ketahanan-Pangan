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


    @vite('resources/css/pages/auth/login.css')

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