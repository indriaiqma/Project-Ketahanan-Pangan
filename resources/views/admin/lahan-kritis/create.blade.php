@extends('layouts.admin')

@section('title', 'Tambah Lahan Kritis')

@section('content')

<x-page-header compact title="Tambah Data Lahan Kritis" description="Isi luas lahan per tingkat kekritisan. Kolom bertanda * wajib diisi.">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.lahan-kritis.index') }}">Lahan Kritis</a>
        <i class="bi bi-chevron-right"></i>
        <span>Tambah</span>
    </x-slot:breadcrumb>
</x-page-header>

@include('admin.lahan-kritis._form', [
    'lahanKritis' => null,
    'action' => route('admin.lahan-kritis.store'),
    'method' => 'POST',
])

@endsection
