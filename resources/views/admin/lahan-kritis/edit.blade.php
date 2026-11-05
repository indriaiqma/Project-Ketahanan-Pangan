@extends('layouts.admin')

@section('title', 'Ubah Lahan Kritis')

@section('content')

<x-page-header compact title="Ubah Data Lahan Kritis" :description="'Kecamatan ' . $lahanKritis->kecamatan . ', ' . $lahanKritis->kabupaten">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.lahan-kritis.index') }}">Lahan Kritis</a>
        <i class="bi bi-chevron-right"></i>
        <span>Ubah</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <a href="{{ route('lahan-kritis.show', $lahanKritis) }}" class="btn btn-outline"><i class="bi bi-eye"></i> Lihat Detail</a>
    </x-slot:actions>
</x-page-header>

@include('admin.lahan-kritis._form', [
    'action' => route('admin.lahan-kritis.update', $lahanKritis),
    'method' => 'PUT',
])

@endsection
