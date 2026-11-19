@extends('layouts.admin')

@section('title', $modul['nama'])

@section('content')

<x-page-header compact :title="$modul['nama']" :description="$modul['sub_nama'] ?? $bidang['nama']">
    <x-slot:breadcrumb>
        <a href="{{ route('admin.bidang.show', $bidang['slug']) }}">{{ $bidang['nama'] }}</a>
        @if ($modul['sub_nama'])
            <i class="bi bi-chevron-right"></i>
            <span>{{ $modul['sub_nama'] }}</span>
        @endif
        <i class="bi bi-chevron-right"></i>
        <span aria-current="page">{{ $modul['nama'] }}</span>
    </x-slot:breadcrumb>
    <x-slot:actions>
        <span class="badge amber"><span class="dot"></span>Segera</span>
    </x-slot:actions>
</x-page-header>

<section class="card">
    <x-empty :icon="$modul['icon'] ?? 'hourglass-split'" :title="'Modul '.$modul['nama'].' sedang disiapkan'">
        Halaman data untuk modul ini akan tersedia setelah format datanya ditetapkan. Sementara itu, Anda dapat melihat modul lain di bidang yang sama.
        <x-slot:action>
            <a href="{{ route('admin.bidang.show', $bidang['slug']) }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali ke {{ $bidang['nama'] }}</a>
        </x-slot:action>
    </x-empty>
</section>

@endsection
