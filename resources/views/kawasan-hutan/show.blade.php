@extends(auth()->user()?->isStaff() ? 'layouts.admin' : 'layouts.public')

@section('title', $kawasanHutan->nama_kawasan)

@section('content')

@php($isStaff = (bool) auth()->user()?->isStaff())

<x-page-header eyebrow="Detail Kawasan Hutan" :title="$kawasanHutan->nama_kawasan"
    :description="'Kecamatan ' . $kawasanHutan->kecamatan . ', ' . $kawasanHutan->kabupaten">
    <x-slot:breadcrumb>
        @if ($isStaff)
            <a href="{{ route('admin.kawasan-hutan.index') }}">Kawasan Hutan</a>
        @else
            <a href="{{ route('dashboard') }}">Beranda</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('kawasan-hutan.index') }}">Kawasan Hutan</a>
        @endif
        <i class="bi bi-chevron-right"></i>
        <span>Detail</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <a href="{{ route($isStaff ? 'admin.kawasan-hutan.index' : 'kawasan-hutan.index') }}" class="btn btn-outline"><i class="bi bi-arrow-left"></i> Kembali</a>
        @if (auth()->user()?->canEditData())
            <a href="{{ route('admin.kawasan-hutan.edit', $kawasanHutan) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Ubah Data</a>
        @endif
    </x-slot:actions>
</x-page-header>

<section class="grid grid-3">
    <x-stat icon="map-fill" label="Luas Kawasan" :value="$kawasanHutan->luas_ha !== null ? angka($kawasanHutan->luas_ha) : '–'" unit="hektare" tone="sky" />
    <x-stat icon="tags-fill" label="Jenis Kawasan" :value="$kawasanHutan->jenis_kawasan" />
    <x-stat icon="geo-alt-fill" label="Kecamatan" :value="$kawasanHutan->kecamatan" :unit="$kawasanHutan->kabupaten" />
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-info-circle-fill"></i></span>
            <div><h2>Informasi Kawasan</h2><p>Rincian data kawasan hutan</p></div>
        </div>
    </div>
    <dl class="dl">
        <div><dt>Nama Kawasan</dt><dd>{{ $kawasanHutan->nama_kawasan }}</dd></div>
        <div><dt>Jenis Kawasan</dt><dd>{{ $kawasanHutan->jenis_kawasan }}</dd></div>
        <div><dt>Kabupaten</dt><dd>{{ $kawasanHutan->kabupaten }}</dd></div>
        <div><dt>Kecamatan</dt><dd>{{ $kawasanHutan->kecamatan }}</dd></div>
        <div><dt>Desa</dt><dd>{{ $kawasanHutan->desa ?: '–' }}</dd></div>
        <div><dt>Luas</dt><dd class="num">{{ $kawasanHutan->luas_ha !== null ? angka($kawasanHutan->luas_ha) . ' Ha' : '–' }}</dd></div>
        <div class="span-2"><dt>Keterangan</dt><dd style="font-weight:500">{{ $kawasanHutan->keterangan ?: '–' }}</dd></div>
    </dl>
    <div class="card-foot">
        <i class="bi bi-clock-history"></i>
        Terakhir diperbarui {{ $kawasanHutan->updated_at?->translatedFormat('d F Y, H:i') ?? '–' }} WIB
    </div>
</section>

@endsection
