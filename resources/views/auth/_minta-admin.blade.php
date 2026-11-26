{{-- Form permintaan reset password ke Administrator --}}
<form method="POST" action="{{ route('password.admin') }}" class="form-minta-admin">
    @csrf
    <div class="field">
        <label for="email-admin">Email akun</label>
        <div class="input-group">
            <i class="bi bi-envelope lead"></i>
            <input id="email-admin" type="email" name="email" value="{{ old('email') }}" class="input" placeholder="nama@gmail.com" required autocomplete="username">
        </div>
    </div>
    <div class="field">
        <label for="catatan">Catatan untuk Administrator <span class="muted">(opsional)</span></label>
        <input id="catatan" type="text" name="catatan" value="{{ old('catatan') }}" class="input" maxlength="255" placeholder="Mis. nama, bidang, atau nomor yang bisa dihubungi">
    </div>
    <button type="submit" class="btn btn-outline btn-block" data-loading="Mengirim…"><i class="bi bi-person-gear"></i> Kirim Permintaan ke Administrator</button>
</form>
