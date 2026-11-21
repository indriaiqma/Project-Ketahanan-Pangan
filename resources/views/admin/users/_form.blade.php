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
                <x-field label="Hak Akses" name="role" type="select" required data-pilih-role
                         hint="Petugas: hanya melihat dan mengelola (tambah, ubah, import) sub bidang yang ditugaskan. Administrator: semua akses, termasuk hapus data dan kelola pengguna. Masyarakat melihat data di situs publik tanpa akun.">
                    @foreach (\App\Models\User::ROLES as $nilai => $label)
                        <option value="{{ $nilai }}" @selected(old('role', $user?->role ?? 'petugas') === $nilai)>{{ $label }}</option>
                    @endforeach
                </x-field>
            </div>
        </div>

        {{-- Penugasan bidang: hanya untuk Petugas (pilihan dibaca dari config/bidang.php) --}}
        @php($terpilih = collect(old('penugasan', $user?->aksesBidang->map(fn ($a) => $a->bidang.'|'.$a->sub_bidang)->all() ?? [])))
        <div class="form-section" data-bagian-penugasan>
            <h3>Penugasan Bidang</h3>
            <p>Petugas <b>hanya dapat melihat dan mengelola</b> sub bidang yang dicentang. Menu, halaman bidang, dan dashboard petugas hanya menampilkan sub bidang tersebut; sub bidang lain disembunyikan.</p>
            @error('penugasan')
                <div class="alert alert-error" role="alert" style="margin-bottom:12px"><i class="bi bi-exclamation-triangle-fill"></i><div>{{ $message }}</div></div>
            @enderror
            <div class="akses-grid">
                @foreach (\App\Support\Bidang::opsiPenugasan() as $grup)
                    <fieldset class="akses-bidang">
                        <legend class="sr-only">{{ $grup['nama'] }}</legend>
                        <h4 aria-hidden="true"><i class="bi bi-{{ $grup['icon'] }}"></i> {{ $grup['nama'] }}</h4>
                        @foreach ($grup['opsi'] as $opsi)
                            <label class="check">
                                <input type="checkbox" name="penugasan[]" value="{{ $opsi['nilai'] }}" @checked($terpilih->contains($opsi['nilai']))>
                                {{ $opsi['label'] }}
                            </label>
                        @endforeach
                    </fieldset>
                @endforeach
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading="Menyimpan…"><i class="bi bi-check-lg"></i> Simpan</button>
    </div>
</form>

@push('scripts')
<script>
    // Bagian penugasan hanya relevan untuk role Petugas
    document.addEventListener('DOMContentLoaded', () => {
        const role = document.querySelector('[data-pilih-role]');
        const bagian = document.querySelector('[data-bagian-penugasan]');
        const atur = () => { bagian.hidden = role.value !== 'petugas'; };
        role.addEventListener('change', atur);
        atur();
    });
</script>
@endpush
