@extends('layouts.admin')

@section('title', 'Kawasan Hutan')

@section('content')

<x-page-header
    compact
    eyebrow="Data Kehutanan"
    :title="auth()->user()->canEditData() ? 'Kelola Kawasan Hutan' : 'Data Kawasan Hutan'"
    :description="auth()->user()->canEditData() ? 'Tambah, ubah, dan hapus data, serta import dan export data kawasan hutan.' : 'Lihat dan export data kawasan hutan. Akun Anda hanya dapat melihat data.'">
    @if (auth()->user()->canEditData())
        <x-slot:actions>
            <a href="{{ route('admin.kawasan-hutan.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Data</a>
        </x-slot:actions>
    @endif
</x-page-header>

@include('kawasan-hutan._ringkasan')
@include('kawasan-hutan._tabel', ['admin' => true])

@endsection
