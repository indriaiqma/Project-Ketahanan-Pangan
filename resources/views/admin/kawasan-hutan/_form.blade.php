{{--
    Form kawasan hutan (tambah & ubah).
    Parameter: $kawasanHutan (model atau null), $action (URL), $method ('POST' / 'PUT')
--}}
<form action="{{ $action }}" method="POST" class="card">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="card-body">
        <div class="form-section">
            <h3>Lokasi</h3>
            <p>Wilayah administratif kawasan hutan.</p>
            <div class="form-grid">
                <x-field label="Kabupaten" name="kabupaten" :value="$kawasanHutan?->kabupaten ?? 'Kabupaten Malang'" required maxlength="255" />
                <x-field label="Kecamatan" name="kecamatan" :value="$kawasanHutan?->kecamatan" required maxlength="255" placeholder="Contoh: Dampit" />
                <x-field label="Desa" name="desa" :value="$kawasanHutan?->desa" maxlength="255" placeholder="Opsional" class="span-2" />
            </div>
        </div>

        <div class="form-section">
            <h3>Informasi Kawasan</h3>
            <p>Nama, jenis, dan luas kawasan hutan.</p>
            <div class="form-grid">
                <x-field label="Nama Kawasan" name="nama_kawasan" :value="$kawasanHutan?->nama_kawasan" required maxlength="255" class="span-2" />
                <x-field label="Jenis Kawasan" name="jenis_kawasan" :value="$kawasanHutan?->jenis_kawasan" required maxlength="255"
                         placeholder="Contoh: Hutan Lindung" list="jenis-kawasan" />
                <x-field label="Luas" name="luas_ha" type="number" :value="$kawasanHutan?->luas_ha" step="0.01" min="0" max="9999999999.99" suffix="Ha" placeholder="0,00" />
                <x-field label="Keterangan" name="keterangan" type="textarea" :value="$kawasanHutan?->keterangan" placeholder="Catatan tambahan (opsional)" class="span-2" />
            </div>
            <datalist id="jenis-kawasan">
                <option value="Hutan Lindung">
                <option value="Hutan Produksi">
                <option value="Hutan Produksi Terbatas">
                <option value="Hutan Konservasi">
                <option value="Cagar Alam">
                <option value="Taman Hutan Raya">
            </datalist>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('admin.kawasan-hutan.index') }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading="Menyimpan…"><i class="bi bi-check-lg"></i> Simpan</button>
    </div>
</form>
