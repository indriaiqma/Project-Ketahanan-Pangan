{{--
    Lupa password (Admin & Petugas).
    1) Tautan reset ke email bila pengiriman email sudah dikonfigurasi ($emailSiap)
    2) Cadangan: permintaan reset ke Administrator (password sementara)
--}}
@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('aside')
    <h1>Lupa password?</h1>
    <p>Atur ulang password akun Administrator atau Petugas dengan aman, tanpa perlu membuat akun baru.</p>
    <ul>
        @if ($emailSiap)
            <li><i class="bi bi-envelope-check-fill"></i> <span><b>Lewat email</b> · tautan reset berlaku {{ config('auth.passwords.users.expire') }} menit, sekali pakai</span></li>
        @endif
        <li><i class="bi bi-person-gear"></i> <span><b>Lewat Administrator</b> · dibuatkan password sementara yang wajib diganti saat masuk</span></li>
        <li><i class="bi bi-shield-lock-fill"></i> <span><b>Aman</b> · password lama tetap berlaku sampai reset benar-benar dilakukan</span></li>
    </ul>
@endsection

@section('content')
    <a href="{{ route('login') }}" class="back top"><i class="bi bi-arrow-left"></i> Kembali ke halaman masuk</a>

    <h2>Atur Ulang Password</h2>
    <p class="sub">Masukkan email akun Anda yang terdaftar di sistem.</p>

    @if (session('status'))
        <div class="alert alert-success" role="status" style="margin-bottom:18px">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error" role="alert" style="margin-bottom:18px">
            <i class="bi bi-exclamation-octagon-fill"></i>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif

    @if ($emailSiap)
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="field">
                <label for="email">Email akun</label>
                <div class="input-group">
                    <i class="bi bi-envelope lead"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="nama@instansi.go.id" required autofocus autocomplete="username">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block" data-loading="Mengirim…"><i class="bi bi-send"></i> Kirim Tautan Reset ke Email</button>
        </form>

        <div class="atau"><span>atau</span></div>

        <details class="minta-admin">
            <summary><i class="bi bi-person-gear"></i> Tidak menerima email? Minta reset ke Administrator</summary>
            @include('auth._minta-admin')
        </details>
    @else
        <div class="alert alert-info" role="note" style="margin-bottom:18px">
            <i class="bi bi-info-circle-fill"></i>
            <div>Permintaan Anda akan diteruskan ke Administrator, yang akan membuatkan <b>password sementara</b>. Saat masuk dengan password tersebut, Anda diminta membuat password baru.</div>
        </div>
        @include('auth._minta-admin')
    @endif
@endsection
