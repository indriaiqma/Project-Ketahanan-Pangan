@extends('layouts.admin')

@section('title', 'Ubah Pengguna')

@section('content')

<x-page-header compact title="Ubah Pengguna" :description="$user->name . ' · ' . $user->email">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.users.index') }}">Pengguna</a>
        <i class="bi bi-chevron-right"></i>
        <span>Ubah</span>
    </x-slot:breadcrumb>
</x-page-header>

@include('admin.users._form', [
    'action' => route('admin.users.update', $user),
    'method' => 'PUT',
])

@endsection
