@extends('layouts.admin')

@section('title', 'Lahan Kritis')

@section('content')

<x-page-header
    compact
    eyebrow="Data Kehutanan"
    :title="auth()->user()->canEditData() ? 'Kelola Lahan Kritis' : 'Data Lahan Kritis'"
    :description="auth()->user()->canEditData() ? 'Tambah, ubah, dan hapus data, serta import dan export data lahan kritis per kecamatan.' : 'Lihat dan export data lahan kritis per kecamatan. Akun Anda hanya dapat melihat data.'">
    @if (auth()->user()->canEditData())
        <x-slot:actions>
            <a href="{{ route('admin.lahan-kritis.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Data</a>
        </x-slot:actions>
    @endif
</x-page-header>

@include('lahan-kritis._ringkasan')
@include('lahan-kritis._tabel', ['admin' => true])

@endsection
