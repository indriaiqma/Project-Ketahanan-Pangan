{{--
    Form input/ubah modul data generik (definisi di config/modul_data.php).
    Satu baris data = 1 wilayah x 1 periode. Validasi yang sama juga
    dijalankan di server (App\Support\ModulData::rules).
--}}
@extends('layouts.admin')

@php
    use App\Support\ModulData;

    $baru = $baris === null;
    $parameter = ['bidang' => $bidang['slug'], 'modul' => $modul['slug']];
    $aksi = $baru
        ? route('admin.modul.store', $parameter)
        : route('admin.modul.update', $parameter + ['id' => $baris->id]);
    $kembali = route('admin.bidang.modul', $parameter + ['tahun' => $awal['tahun'], 'periode' => $awal['periode']]);
@endphp

@section('title', ($baru ? 'Input ' : 'Ubah ').$modul['nama'])

@section('content')

<x-page-header compact :title="($baru ? 'Input Data ' : 'Ubah Data ').$modul['nama']"
    description="Satu data mewakili satu wilayah pada satu periode. Kolom bertanda * wajib diisi; angka yang belum tersedia boleh dikosongkan. Persentase dihitung otomatis.">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.bidang.show', $bidang['slug']) }}">{{ $bidang['nama'] }}</a>
        <i class="bi bi-chevron-right"></i>
        <a href="{{ $kembali }}">{{ $modul['nama'] }}</a>
        <i class="bi bi-chevron-right"></i>
        <span aria-current="page">{{ $baru ? 'Input' : 'Ubah' }}</span>
    </x-slot:breadcrumb>
</x-page-header>

@if (session('duplikat'))
    <div class="alert alert-info" role="alert">
        <i class="bi bi-info-circle-fill"></i>
        <div>Data wilayah ini untuk periode tersebut sudah pernah diinput. <a href="{{ session('duplikat') }}">Ubah data yang sudah ada</a> atau pilih wilayah/periode lain.</div>
    </div>
@endif

<form action="{{ $aksi }}" method="POST" enctype="multipart/form-data" class="card" data-modul-form novalidate>
    @csrf
    @unless ($baru) @method('PUT') @endunless

    <div class="card-body">
        <div class="form-section">
            <h3>Wilayah & Periode</h3>
            <p>Pilih kecamatan dan periode laporan.</p>
            <div class="form-grid">
                <x-field label="Wilayah (Kecamatan)" name="wilayah_id" type="select" required data-kunci-duplikat>
                    <option value="">Pilih kecamatan…</option>
                    @foreach ($wilayah as $w)
                        <option value="{{ $w->id }}" @selected((int) old('wilayah_id', $awal['wilayah_id']) === $w->id)>{{ $w->nama }}</option>
                    @endforeach
                </x-field>
                <x-field label="Tahun" name="tahun" type="number" :value="$awal['tahun']" required min="2000" :max="$tahunIni + 1" step="1" data-kunci-duplikat />
                <x-field label="Periode" :name="$kolom" type="select" required data-kunci-duplikat>
                    @foreach (ModulData::opsiPeriode($def) as $nilai => $label)
                        <option value="{{ $nilai }}" @selected((int) old($kolom, $awal['periode']) === $nilai)>{{ $label }}</option>
                    @endforeach
                </x-field>
            </div>
            <div class="alert alert-info" role="status" data-peringatan-duplikat hidden style="margin-top:14px">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>Data untuk wilayah dan periode ini sudah ada. <a href="#" data-link-duplikat>Ubah data yang sudah ada</a> agar tidak tercatat dua kali.</div>
            </div>
        </div>

        @foreach (ModulData::grupField($def) as $grup => $fields)
            <div class="form-section">
                <h3>{{ $grup }}</h3>
                <p>Isi dengan angka (0 jika memang tidak ada). Kosongkan bila datanya belum tersedia. Gunakan titik untuk desimal, mis. 12.5</p>
                <div class="form-grid">
                    @foreach ($fields as $kunci => $f)
                        @php($desimal = ($f['tipe'] ?? 'bulat') === 'desimal')
                        <x-field :label="$f['label']" :name="$kunci" type="number" min="0" :step="$desimal ? '0.01' : '1'" :data-desimal="$desimal ? '1' : null"
                                 :value="$baris?->{$kunci}" :suffix="$f['satuan'] ?? null" placeholder="–"
                                 :hint="isset($f['maks']) ? ($f['hint'] ?? 'Tidak boleh melebihi '.mb_strtolower(ModulData::info($def, $f['maks'])['label']).'.') : ($f['hint'] ?? null)"
                                 data-angka :data-maks="$f['maks'] ?? null"
                                 :data-maks-dari="isset($f['maks'], $def['total'][$f['maks']]) ? implode(',', $def['total'][$f['maks']]['dari']) : null"
                                 :data-maks-label="isset($f['maks']) ? ModulData::info($def, $f['maks'])['label'] : null" />
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="form-section">
            <h3>Hasil Perhitungan Otomatis</h3>
            <p>Diperbarui langsung saat angka diisi.</p>
            <div class="computed">
                @foreach ($def['total'] as $kunci => $t)
                    <span class="chip">{{ $t['label'] }}: <b data-total="{{ $kunci }}" data-dari="{{ implode(',', $t['dari']) }}">0</b> {{ $t['satuan'] ?? '' }}</span>
                @endforeach
                @foreach ($def['persentase'] as $kunci => $p)
                    <span class="chip">{{ $p['label'] }}: <b data-persen data-pembilang="{{ $p['pembilang'] }}" data-penyebut="{{ $p['penyebut'] }}">–</b>
                        @isset($p['target'])<small class="muted">(target {{ $p['target'] }}%)</small>@endisset
                    </span>
                @endforeach
            </div>
        </div>

        <div class="form-section">
            <h3>Sumber & Lampiran</h3>
            <p>Lampiran opsional: PDF atau Excel, maksimal 2 MB.</p>
            <div class="form-grid">
                <x-field label="Sumber Data" name="sumber_data" :value="$baris?->sumber_data" maxlength="255" placeholder="Contoh: Dispendukcapil Kab. Malang" />
                <div class="field">
                    <label for="f-lampiran">Lampiran</label>
                    <input id="f-lampiran" type="file" name="lampiran" accept=".pdf,.xls,.xlsx,.csv" @class(['input', 'is-invalid' => $errors->has('lampiran')]) style="padding-top:8px">
                    @if ($errors->has('lampiran'))
                        <div class="error"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('lampiran') }}</div>
                    @elseif ($baris?->lampiran)
                        <div class="hint">
                            Saat ini: <a href="{{ route('admin.modul.lampiran', $parameter + ['lampiran' => $baris->lampiran->id]) }}">{{ $baris->lampiran->nama_file }}</a>
                            ({{ $baris->lampiran->ukuranLabel() }}). Pilih file baru untuk mengganti.
                        </div>
                        <label class="check"><input type="checkbox" name="hapus_lampiran" value="1"> Hapus lampiran ini</label>
                    @else
                        <div class="hint">Format .pdf, .xls, .xlsx, atau .csv.</div>
                    @endif
                </div>
                <x-field label="Keterangan" name="keterangan" type="textarea" :value="$baris?->keterangan" maxlength="2000" placeholder="Catatan tambahan (opsional)" class="span-2" />
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ $kembali }}" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary" data-loading="Menyimpan…"><i class="bi bi-check-lg"></i> Simpan</button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('[data-modul-form]');
        const sudahAda = @json($sudahAda);
        const kolomPeriode = @json($kolom);
        const nf = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 1 });
        const nilai = (nama) => parseFloat(form.elements[nama]?.value) || 0;

        // Total & persentase otomatis
        const hitung = () => {
            form.querySelectorAll('[data-total]').forEach((el) => {
                el.textContent = nf.format(el.dataset.dari.split(',').reduce((s, f) => s + nilai(f), 0));
            });
            form.querySelectorAll('[data-persen]').forEach((el) => {
                const penyebut = nilai(el.dataset.penyebut);
                el.textContent = penyebut > 0 ? nf.format(nilai(el.dataset.pembilang) / penyebut * 100) + '%' : '–';
            });
        };

        // Validasi di browser: angka >= 0 dan nilai bagian tidak melebihi totalnya
        const cekBatas = () => {
            form.querySelectorAll('[data-angka]').forEach((input) => {
                let pesan = '';
                const desimal = input.dataset.desimal === '1';
                if (input.value !== '' && (Number(input.value) < 0 || (!desimal && !Number.isInteger(Number(input.value))))) {
                    pesan = desimal ? 'Isi dengan angka 0 atau lebih.' : 'Isi dengan angka bulat 0 atau lebih.';
                } else if (input.dataset.maks && input.value !== '') {
                    // Batas atas: field lain, atau total otomatis dari beberapa field
                    const batas = input.dataset.maksDari
                        ? input.dataset.maksDari.split(',').reduce((s, f) => s + nilai(f), 0)
                        : nilai(input.dataset.maks);
                    if (nilai(input.name) > batas) {
                        pesan = `Tidak boleh melebihi ${(input.dataset.maksLabel || 'nilai totalnya').toLowerCase()}.`;
                    }
                }
                input.setCustomValidity(pesan);
                input.classList.toggle('is-invalid', !!pesan);
            });
        };

        // Peringatan bila wilayah + periode sudah pernah diinput
        const cekDuplikat = () => {
            const kunci = `${form.elements.wilayah_id.value}-${form.elements.tahun.value}-${form.elements[kolomPeriode].value}`;
            const box = form.querySelector('[data-peringatan-duplikat]');
            const url = sudahAda[kunci];
            box.hidden = !url;
            if (url) form.querySelector('[data-link-duplikat]').href = url;
        };

        form.addEventListener('input', () => { hitung(); cekBatas(); });
        form.addEventListener('change', cekDuplikat);
        form.addEventListener('submit', (e) => {
            cekBatas();
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopImmediatePropagation();
                form.reportValidity();
            }
        }, true);

        hitung();
        cekDuplikat();
    });
</script>
@endpush
