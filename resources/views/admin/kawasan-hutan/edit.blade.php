@extends('layouts.admin')

@section('title', 'Ubah Kawasan Hutan')

@section('content')

<x-page-header compact title="Ubah Kawasan Hutan" :description="$kawasanHutan->nama_kawasan">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.kawasan-hutan.index') }}">Kawasan Hutan</a>
        <i class="bi bi-chevron-right"></i>
        <span>Ubah</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <a href="{{ route('kawasan-hutan.show', $kawasanHutan) }}" class="btn btn-outline"><i class="bi bi-eye"></i> Lihat Detail</a>
    </x-slot:actions>
</x-page-header>

@include('admin.kawasan-hutan._form', [
    'action' => route('admin.kawasan-hutan.update', $kawasanHutan),
    'method' => 'PUT',
])

@endsection
