@extends('layouts.auth')

@section('title', 'Buat Password Baru')

@section('aside')
    <h1>Buat password baru</h1>
    <p>Gunakan password yang kuat dan belum pernah dipakai di layanan lain.</p>
    <ul>
        <li><i class="bi bi-check2-circle"></i> <span>Minimal <b>8 karakter</b></span></li>
        <li><i class="bi bi-check2-circle"></i> <span>Mengandung <b>huruf</b> dan <b>angka</b></span></li>
        <li><i class="bi bi-shield-lock-fill"></i> <span>Tautan ini hanya bisa dipakai satu kali</span></li>
    </ul>
@endsection

@section('content')
    <h2>Buat Password Baru</h2>
    <p class="sub">Atur ulang password untuk akun <b>{{ $email }}</b>.</p>

    @if ($errors->any())
        <div class="alert alert-error" role="alert" style="margin-bottom:18px">
            <i class="bi bi-exclamation-octagon-fill"></i>
            <div>
                {{ $errors->first() }}
                @if ($errors->has('email'))
                    <a href="{{ route('password.request') }}">Minta tautan baru</a>
                @endif
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ old('email', $email) }}">
        <div class="field">
            <label for="password">Password baru</label>
            <div class="input-group">
                <i class="bi bi-lock lead"></i>
                <input id="password" type="password" name="password" class="input has-trail" required minlength="8" autofocus autocomplete="new-password" placeholder="Minimal 8 karakter, huruf dan angka">
                <button type="button" class="trail" data-toggle-password>Lihat</button>
            </div>
        </div>
        <div class="field">
            <label for="password_confirmation">Ulangi password baru</label>
            <div class="input-group">
                <i class="bi bi-lock-fill lead"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" class="input" required minlength="8" autocomplete="new-password" placeholder="Ketik ulang password baru">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block" data-loading="Menyimpan…"><i class="bi bi-check2-circle"></i> Simpan Password Baru</button>
    </form>

    <a href="{{ route('login') }}" class="back"><i class="bi bi-arrow-left"></i> Kembali ke halaman masuk</a>
@endsection
