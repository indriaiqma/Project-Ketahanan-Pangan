@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')

<x-page-header compact title="Tambah Pengguna" description="Buat akun baru untuk mengakses sistem.">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.users.index') }}">Pengguna</a>
        <i class="bi bi-chevron-right"></i>
        <span>Tambah</span>
    </x-slot:breadcrumb>
</x-page-header>

@include('admin.users._form', [
    'user' => null,
    'action' => route('admin.users.store'),
    'method' => 'POST',
])

@endsection
