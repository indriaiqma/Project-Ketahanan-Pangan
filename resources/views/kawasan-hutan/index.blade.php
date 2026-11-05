@extends('layouts.public')

@section('title', 'Kawasan Hutan')

@section('content')

<x-page-header
    eyebrow="Kehutanan"
    title="Kawasan Hutan Malang Selatan"
    description="Informasi kawasan hutan berdasarkan lokasi, jenis kawasan, dan luas wilayah di Malang Selatan." />

@include('kawasan-hutan._ringkasan')
@include('kawasan-hutan._tabel', ['admin' => false])

@endsection
