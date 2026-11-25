{{--
    Form tambah/ubah modul data jenis "daftar" (definisi di config/modul_data.php).
    Validasi yang sama juga dijalankan di server (App\Support\ModulData::rules).
--}}
@extends('layouts.admin')

@php
    use App\Support\ModulData;

    $baru = $baris === null;
    $parameter = ['bidang' => $bidang['slug'], 'modul' => $modul['slug']];
    $aksi = $baru
        ? route('admin.modul.store', $parameter)
        : route('admin.modul.update', $parameter + ['id' => $baris->id]);
    $kembali = route('admin.bidang.modul', $parameter);
    // "Daftar Sekolah" -> "Sekolah" agar judul form tidak janggal ("Tambah Data Sekolah")
    $namaData = preg_replace('/^Daftar /', '', $modul['nama']);
@endphp

@section('title', ($baru ? 'Tambah ' : 'Ubah ').$namaData)

@section('content')

<x-page-header compact :title="($baru ? 'Tambah Data ' : 'Ubah Data ').$namaData" description="Kolom bertanda * wajib diisi.">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.bidang.show', $bidang['slug']) }}">{{ $bidang['nama'] }}</a>
        @if (! empty($modul['induk']))
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('admin.bidang.modul', ['bidang' => $bidang['slug'], 'modul' => $modul['induk']]) }}">{{ $modul['induk_nama'] }}</a>
        @endif
        <i class="bi bi-chevron-right"></i>
        <a href="{{ $kembali }}">{{ $modul['nama'] }}</a>
        <i class="bi bi-chevron-right"></i>
        <span aria-current="page">{{ $baru ? 'Tambah' : 'Ubah' }}</span>
    </x-slot:breadcrumb>
</x-page-header>

<form action="{{ $aksi }}" method="POST" enctype="multipart/form-data" class="card">
    @csrf
    @unless ($baru) @method('PUT') @endunless

    <div class="card-body">
        @foreach (ModulData::grupField($def) as $grup => $fields)
            <div class="form-section">
                <h3>{{ $grup }}</h3>
                <p>{{ $loop->first ? 'Isi informasi utama data.' : 'Lengkapi informasi berikut.' }}</p>
                <div class="form-grid">
                    @foreach ($fields as $kunci => $f)
                        @php($tipe = $f['tipe'] ?? 'teks')
                        @php($wajib = (bool) ($f['wajib'] ?? false))
                        @php($kelas = ($f['lebar'] ?? null) === 'penuh' || $tipe === 'teks_panjang' ? 'span-2' : null)
                        @switch($tipe)
                            @case('pilihan')
                                <x-field :label="$f['label']" :name="$kunci" type="select" :required="$wajib" :hint="$f['hint'] ?? null" :class="$kelas">
                                    <option value="">Pilih…</option>
                                    @foreach ($f['opsi'] as $opsi)
                                        <option value="{{ $opsi }}" @selected(old($kunci, $baris?->{$kunci}) === $opsi)>{{ $opsi }}</option>
                                    @endforeach
                                </x-field>
                                @break
                            @case('wilayah')
                                <x-field :label="$f['label']" :name="$kunci" type="select" :required="$wajib" :hint="$f['hint'] ?? null" :class="$kelas">
                                    <option value="">Pilih kecamatan…</option>
                                    @foreach ($wilayah as $w)
                                        <option value="{{ $w->id }}" @selected((int) old($kunci, $baris?->{$kunci} ?? request('kecamatan')) === $w->id)>{{ $w->nama }}</option>
                                    @endforeach
                                </x-field>
                                @break
                            @case('teks_panjang')
                                <x-field :label="$f['label']" :name="$kunci" type="textarea" :value="$baris?->{$kunci}" :required="$wajib" maxlength="5000" :hint="$f['hint'] ?? null" class="span-2" />
                                @break
                            @case('tanggal')
                                <x-field :label="$f['label']" :name="$kunci" type="date" :value="$baris?->{$kunci}" :required="$wajib" :hint="$f['hint'] ?? null" :class="$kelas" />
                                @break
                            @case('angka')
                            @case('tahun')
                                <x-field :label="$f['label']" :name="$kunci" type="number" :value="$baris?->{$kunci}" :required="$wajib" min="0" step="1"
                                         :suffix="$f['satuan'] ?? null" :hint="$f['hint'] ?? null" :class="$kelas" />
                                @break
                            @case('desimal')
                            @case('persen')
                                <x-field :label="$f['label']" :name="$kunci" type="number" :value="$baris?->{$kunci}" :required="$wajib" min="0" step="0.01"
                                         :max="$tipe === 'persen' ? 100 : null" :suffix="$tipe === 'persen' ? '%' : ($f['satuan'] ?? null)" :hint="$f['hint'] ?? null" :class="$kelas" />
                                @break
                            @default
                                <x-field :label="$f['label']" :name="$kunci" :value="$baris?->{$kunci}" :required="$wajib" maxlength="255"
                                         :placeholder="$f['contoh'] ?? null" :hint="$f['hint'] ?? null" :class="$kelas" />
                        @endswitch
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="form-section">
            <h3>Sumber & Lampiran</h3>
            <p>Lampiran opsional: PDF, Word, atau Excel, maksimal 2 MB.</p>
            <div class="form-grid">
                <x-field label="Sumber Data" name="sumber_data" :value="$baris?->sumber_data" maxlength="255" placeholder="Instansi atau dokumen sumber" />
                <div class="field">
                    <label for="f-lampiran">Lampiran</label>
                    <input id="f-lampiran" type="file" name="lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,.csv" @class(['input', 'is-invalid' => $errors->has('lampiran')]) style="padding-top:8px">
                    @if ($errors->has('lampiran'))
                        <div class="error"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('lampiran') }}</div>
                    @elseif ($baris?->lampiran)
                        <div class="hint">
                            Saat ini: <a href="{{ route('admin.modul.lampiran', $parameter + ['lampiran' => $baris->lampiran->id]) }}">{{ $baris->lampiran->nama_file }}</a>
                            ({{ $baris->lampiran->ukuranLabel() }}). Pilih file baru untuk mengganti.
                        </div>
                        <label class="check"><input type="checkbox" name="hapus_lampiran" value="1"> Hapus lampiran ini</label>
                    @else
                        <div class="hint">Format .pdf, .doc, .docx, .xls, .xlsx, atau .csv.</div>
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
