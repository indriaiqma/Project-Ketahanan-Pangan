@extends('layouts.admin')

@section('title', 'Tambah Kawasan Hutan')

@section('content')

<x-page-header compact title="Tambah Kawasan Hutan" description="Isi data kawasan hutan baru. Kolom bertanda * wajib diisi.">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.kawasan-hutan.index') }}">Kawasan Hutan</a>
        <i class="bi bi-chevron-right"></i>
        <span>Tambah</span>
    </x-slot:breadcrumb>
</x-page-header>

@include('admin.kawasan-hutan._form', [
    'kawasanHutan' => null,
    'action' => route('admin.kawasan-hutan.store'),
    'method' => 'POST',
])

@endsection
