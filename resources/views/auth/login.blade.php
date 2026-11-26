@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <h2>Masuk ke Panel Pengelola</h2>
    <p class="sub">Khusus Administrator dan Petugas Bakorwil III Malang. Untuk melihat data, kunjungi <a href="{{ route('data.index') }}">Data Bidang</a> tanpa perlu masuk.</p>

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

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <div class="input-group">
                <i class="bi bi-envelope lead"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="nama@gmail.com" required autofocus autocomplete="username">
            </div>
        </div>
        <div class="field">
            <div class="label-row">
                <label for="password">Password</label>
                <a href="{{ route('password.request') }}" class="lupa-link">Lupa password?</a>
            </div>
            <div class="input-group">
                <i class="bi bi-lock lead"></i>
                <input id="password" type="password" name="password" class="input has-trail" placeholder="Masukkan password" required autocomplete="current-password">
                <button type="button" class="trail" data-toggle-password>Lihat</button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block" data-loading="Memeriksa…"><i class="bi bi-box-arrow-in-right"></i> Masuk</button>
    </form>

    <p class="auth-alt">Belum punya akun? <a href="{{ route('daftar') }}">Daftar sebagai Petugas</a></p>

    <a href="{{ route('dashboard') }}" class="back"><i class="bi bi-arrow-left"></i> Kembali ke beranda</a>
@endsection
