{{-- Pendaftaran akun Petugas; aktif setelah disetujui Administrator --}}
@extends('layouts.auth')

@section('title', 'Daftar Akun Petugas')

@section('aside')
    <h1>Daftar sebagai Petugas</h1>
    <p>Ajukan akun untuk menginput dan mengelola data sub bidang tugas Anda di Bakorwil III Malang.</p>
    <ul>
        <li><i class="bi bi-1-circle-fill"></i> <span><b>Isi data diri</b> dan pilih sub bidang yang Anda kelola</span></li>
        <li><i class="bi bi-2-circle-fill"></i> <span><b>Administrator memeriksa</b> dan menyetujui pendaftaran</span></li>
        <li><i class="bi bi-3-circle-fill"></i> <span><b>Masuk</b> dengan email dan password yang Anda buat</span></li>
    </ul>
@endsection

@section('content')
    <a href="{{ route('login') }}" class="back top"><i class="bi bi-arrow-left"></i> Kembali ke halaman masuk</a>

    <h2>Daftar Akun Petugas</h2>
    <p class="sub">Akun baru dapat digunakan setelah <b>disetujui Administrator</b>. Akun Administrator hanya dibuat oleh Administrator.</p>

    @if ($errors->any())
        <div class="alert alert-error" role="alert" style="margin-bottom:18px">
            <i class="bi bi-exclamation-octagon-fill"></i>
            <div>
                <b>Periksa kembali isian Anda:</b>
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('daftar.simpan') }}" class="form-daftar">
        @csrf
        {{-- Honeypot anti-bot: jangan diisi --}}
        <div class="hp-field" aria-hidden="true">
            <label for="situs_web">Situs web</label>
            <input id="situs_web" type="text" name="situs_web" tabindex="-1" autocomplete="off">
        </div>

        <div class="field">
            <label for="name">Nama lengkap <span class="req">*</span></label>
            <div class="input-group">
                <i class="bi bi-person lead"></i>
                <input id="name" type="text" name="name" value="{{ old('name') }}" class="input" required maxlength="255" autocomplete="name" placeholder="Sesuai identitas kepegawaian">
            </div>
        </div>

        <div class="field-2">
            <div class="field">
                <label for="email">Email <span class="req">*</span></label>
                <div class="input-group">
                    <i class="bi bi-envelope lead"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="input" required maxlength="255" autocomplete="email" placeholder="nama@instansi.go.id">
                </div>
            </div>
            <div class="field">
                <label for="no_hp">Nomor HP/WhatsApp <span class="req">*</span></label>
                <div class="input-group">
                    <i class="bi bi-phone lead"></i>
                    <input id="no_hp" type="tel" name="no_hp" value="{{ old('no_hp') }}" class="input" required inputmode="tel" autocomplete="tel" placeholder="081234567890">
                </div>
            </div>
        </div>

        <div class="field">
            <label for="jabatan">Jabatan / unit kerja <span class="req">*</span></label>
            <div class="input-group">
                <i class="bi bi-briefcase lead"></i>
                <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan') }}" class="input" required maxlength="150" placeholder="Mis. Staf Sub Bidang Kemasyarakatan I">
            </div>
        </div>

        <fieldset class="field pilih-sub">
            <legend>Sub bidang yang diajukan <span class="req">*</span></legend>
            <p class="hint">Pilih sub bidang yang datanya akan Anda kelola. Administrator dapat menyesuaikannya saat menyetujui.</p>
            @php($dipilih = collect(old('penugasan', [])))
            <div class="pilih-sub-grid">
                @foreach ($opsiPenugasan as $grup)
                    <div class="pilih-sub-grup">
                        <b><i class="bi bi-{{ $grup['icon'] }}"></i> {{ $grup['nama'] }}</b>
                        @foreach ($grup['opsi'] as $o)
                            <label class="check">
                                <input type="checkbox" name="penugasan[]" value="{{ $o['nilai'] }}" @checked($dipilih->contains($o['nilai']))>
                                {{ $o['label'] }}
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </fieldset>

        <div class="field">
            <label for="password">Password <span class="req">*</span></label>
            <div class="input-group">
                <i class="bi bi-lock lead"></i>
                <input id="password" type="password" name="password" class="input has-trail" required minlength="8" autocomplete="new-password" placeholder="Min. 8 karakter, huruf & angka">
                <button type="button" class="trail" data-toggle-password>Lihat</button>
            </div>
        </div>
        <div class="field">
            <label for="password_confirmation">Ulangi password <span class="req">*</span></label>
            <div class="input-group">
                <i class="bi bi-lock-fill lead"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" class="input" required minlength="8" autocomplete="new-password" placeholder="Ketik ulang password">
            </div>
        </div>

        <div class="field">
            <label for="catatan">Catatan untuk Administrator <span class="muted">(opsional)</span></label>
            <input id="catatan" type="text" name="catatan" value="{{ old('catatan') }}" class="input" maxlength="255" placeholder="Mis. NIP, atasan langsung, atau keterangan lain">
        </div>

        <label class="check pernyataan">
            <input type="checkbox" name="setuju" value="1" @checked(old('setuju')) required>
            Saya menyatakan data di atas benar dan akan menggunakan akun ini hanya untuk keperluan tugas di Bakorwil III Malang.
        </label>

        <button type="submit" class="btn btn-primary btn-block" data-loading="Mengirim…"><i class="bi bi-send-check"></i> Kirim Pendaftaran</button>
    </form>

    <p class="auth-alt">Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
@endsection
