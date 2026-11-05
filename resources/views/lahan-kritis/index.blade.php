@extends('layouts.public')

@section('title', 'Lahan Kritis')

@section('content')

<x-page-header
    eyebrow="Kehutanan"
    title="Lahan Kritis Malang Selatan"
    description="Kondisi lahan per kecamatan berdasarkan tingkat kekritisan, di dalam maupun di luar kawasan hutan." />

@include('lahan-kritis._ringkasan')
@include('lahan-kritis._tabel', ['admin' => false])

@endsection
