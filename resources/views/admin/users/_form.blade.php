{{--
    Form pengguna (tambah & ubah).
    Parameter: $user (model atau null), $action (URL), $method ('POST' / 'PUT')
--}}
@php($baru = $user === null)

<form action="{{ $action }}" method="POST" class="card" autocomplete="off">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="card-body">
        <div class="form-section">
            <h3>Data Akun</h3>
            <p>Nama dan email digunakan untuk identitas serta login.</p>
            <div class="form-grid">
                <x-field label="Nama Lengkap" name="name" :value="$user?->name" required maxlength="255" icon="person" />
                <x-field label="Email" name="email" type="email" :value="$user?->email" required icon="envelope" />
            </div>
        </div>

        <div class="form-section">
            <h3>Keamanan & Hak Akses</h3>
            <p>{{ $baru ? 'Tentukan password awal dan hak akses pengguna.' : 'Kosongkan password jika tidak ingin menggantinya.' }}</p>
            <div class="form-grid">
                <x-field label="Password" name="password" type="password" :required="$baru" minlength="6" icon="lock"
                         autocomplete="new-password" :hint="$baru ? 'Minimal 6 karakter.' : 'Biarkan kosong untuk mempertahankan password lama.'" />
                <x-field label="Hak Akses" name="role" type="select" required
                         hint="Viewer: hanya melihat & export. Petugas: + tambah, ubah, import. Administrator: semua akses, termasuk hapus data dan kelola pengguna.">
                    @foreach (\App\Models\User::ROLES as $nilai => $label)
                        <option value="{{ $nilai }}" @selected(old('role', $user?->role ?? 'petugas') === $nilai)>{{ $label }}</option>
                    @endforeach
                </x-field>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading="Menyimpan…"><i class="bi bi-check-lg"></i> Simpan</button>
    </div>
</form>
