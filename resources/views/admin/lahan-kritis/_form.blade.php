{{--
    Form lahan kritis (tambah & ubah).
    Parameter: $lahanKritis (model atau null), $action (URL), $method ('POST' / 'PUT')
--}}
@php
    $kategori = [
        'sangat_kritis'    => 'Sangat Kritis',
        'kritis'           => 'Kritis',
        'agak_kritis'      => 'Agak Kritis',
        'potensial_kritis' => 'Potensial Kritis',
        'tidak_kritis'     => 'Tidak Kritis',
    ];
    $kecamatanMalangSelatan = ['Ampelgading', 'Bantur', 'Dampit', 'Donomulyo', 'Gedangan', 'Kalipare', 'Pagak', 'Sumbermanjing Wetan', 'Tirtoyudo'];
@endphp

<form action="{{ $action }}" method="POST" class="card" data-total-form>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="card-body">
        <div class="form-section">
            <h3>Lokasi</h3>
            <p>Satu data mewakili satu kecamatan.</p>
            <div class="form-grid">
                <x-field label="Kabupaten" name="kabupaten" :value="$lahanKritis?->kabupaten ?? 'Kabupaten Malang'" required maxlength="255" />
                <x-field label="Kecamatan" name="kecamatan" :value="$lahanKritis?->kecamatan" required maxlength="255" list="kecamatan-list" placeholder="Pilih atau ketik nama kecamatan" />
            </div>
            <datalist id="kecamatan-list">
                @foreach ($kecamatanMalangSelatan as $kec)
                    <option value="{{ $kec }}">
                @endforeach
            </datalist>
        </div>

        @foreach (['dalam' => 'Dalam Kawasan Hutan', 'luar' => 'Luar Kawasan Hutan'] as $lokasi => $judul)
            <div class="form-section">
                <h3>{{ $judul }}</h3>
                <p>Luas lahan dalam hektare. Kosongkan jika tidak ada (dianggap 0).</p>
                <div class="form-grid">
                    @foreach ($kategori as $kolom => $label)
                        <x-field :label="$label" :name="$lokasi . '_' . $kolom" type="number" step="0.01" min="0" max="999999999999.99" suffix="Ha" placeholder="0,00"
                                 :value="$lahanKritis?->{$lokasi . '_' . $kolom}" data-luas />
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <div class="form-actions" style="justify-content:space-between;align-items:center">
        <div>
            <span class="muted" style="font-size:12.5px">Total luas (dihitung otomatis)</span>
            <div style="font-size:18px;font-weight:750" class="num"><span data-total>0</span> Ha</div>
        </div>
        <div style="display:flex;gap:10px">
            <a href="{{ route('admin.lahan-kritis.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn btn-primary" data-loading="Menyimpan…"><i class="bi bi-check-lg"></i> Simpan</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('[data-total-form]');
        const out = form.querySelector('[data-total]');
        const nf = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const hitung = () => {
            const total = [...form.querySelectorAll('[data-luas]')].reduce((s, i) => s + (parseFloat(i.value) || 0), 0);
            out.textContent = nf.format(total);
        };
        form.addEventListener('input', hitung);
        hitung();
    });
</script>
@endpush
