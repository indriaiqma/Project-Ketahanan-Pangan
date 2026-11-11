@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('heading', 'Kelola Pengguna')
@section('hidePageHeading', true)

@section('style')
@vite('resources/css/pages/users/index.css')
@endsection


@section('content')


{{-- =========================================================
     HERO
========================================================= --}}

<section class="dashboard-hero">

    <div class="hero-decoration hero-decoration-one"></div>
    <div class="hero-decoration hero-decoration-two"></div>
    <div class="hero-decoration hero-decoration-three"></div>


    <div class="hero-content">

        <div class="hero-label">

            <span class="hero-label-line"></span>

            ADMINISTRASI SISTEM

        </div>


        <h2>
            Kelola Pengguna
        </h2>


        <p class="hero-description">
            Kelola akun dan hak akses pengguna Sistem Informasi
            Ketahanan Pangan Malang Selatan.
        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                USER
            </div>


            <div>

                <div class="hero-summary-title">
                    Manajemen Pengguna
                </div>

                <div class="hero-summary-text">
                    Administrator dapat menambahkan, memperbarui,
                    serta mengelola akun pengguna sistem.
                </div>

            </div>

        </div>

    </div>


    <div class="hero-status">

        <span></span>


        <div>

            <strong>
                {{ $users->count() }} Pengguna
            </strong>

            <small>
                Terdaftar pada sistem
            </small>

        </div>

    </div>

</section>



{{-- =========================================================
     ALERT
========================================================= --}}

@if(session('success'))

<div class="page-alert alert-success">

    <div class="alert-symbol">
        ✓
    </div>

    <div>
        {{ session('success') }}
    </div>

</div>

@endif


@if(session('error'))

<div class="page-alert alert-error">

    <div class="alert-symbol">
        !
    </div>

    <div>
        {{ session('error') }}
    </div>

</div>

@endif



{{-- =========================================================
     DATA PENGGUNA
========================================================= --}}

<section class="dashboard-panel">


    <div class="panel-header">


        <div class="panel-title-wrap">

            <span class="panel-mark"></span>


            <div>

                <h3 class="panel-title">
                    Data Akun Pengguna
                </h3>

                <div class="panel-subtitle">
                    Daftar akun dan hak akses yang terdaftar pada sistem
                </div>

            </div>

        </div>


        <div class="panel-actions">


            <div class="user-count">
                {{ $users->count() }} PENGGUNA
            </div>


            <a
                href="/users/tambah"
                class="btn-add"
            >
                + Tambah Pengguna
            </a>


        </div>

    </div>



    <div class="table-info">

        <span>
            Kelola akun Administrator dan Viewer
        </span>

        <span>
            <strong>{{ $users->count() }}</strong>
            akun tersedia
        </span>

    </div>



    <div class="table-wrapper">


        <table class="users-table">


            <thead>

                <tr>

                    <th class="col-no">
                        No
                    </th>

                    <th>
                        Nama Pengguna
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Hak Akses
                    </th>

                    <th>
                        Tanggal Dibuat
                    </th>

                    <th class="col-action">
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($users as $user)


                <tr>


                    {{-- NOMOR --}}

                    <td class="col-no">
                        {{ $loop->iteration }}
                    </td>



                    {{-- NAMA --}}

                    <td>

                        <div class="user-name">


                            <div class="mini-avatar">

                                {{ strtoupper(substr($user->name, 0, 1)) }}

                            </div>


                            <div>

                                <span class="name-text">

                                    {{ $user->name }}

                                </span>


                                @if(auth()->id() === $user->id)

                                <span class="current-badge">
                                    Anda
                                </span>

                                @endif

                            </div>

                        </div>

                    </td>



                    {{-- EMAIL --}}

                    <td>

                        <span class="email-text">

                            {{ $user->email }}

                        </span>

                    </td>



                    {{-- ROLE --}}

                    <td>


                        @if($user->role === 'admin')


                        <span class="role-badge role-admin">

                            Administrator

                        </span>


                        @else


                        <span class="role-badge role-viewer">

                            Viewer

                        </span>


                        @endif


                    </td>



                    {{-- TANGGAL --}}

                    <td>

                        <span class="date-text">

                            {{ $user->created_at->format('d-m-Y') }}

                        </span>

                    </td>



                    {{-- AKSI --}}

                    <td class="col-action">


                        <div class="action-group">


                            <a
                                href="/users/{{ $user->id }}/edit"
                                class="action-btn btn-edit"
                            >
                                Edit
                            </a>


                            @if(auth()->id() !== $user->id)


                            <form
                                action="/users/{{ $user->id }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                            >

                                @csrf
                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="action-btn btn-delete"
                                >
                                    Hapus
                                </button>

                            </form>


                            @else


                            <span class="self-info">
                                Akun aktif
                            </span>


                            @endif


                        </div>


                    </td>


                </tr>


                @empty


                <tr>

                    <td
                        colspan="6"
                        class="empty-state"
                    >

                        <div class="empty-symbol">
                            USER
                        </div>

                        Belum ada pengguna yang terdaftar.

                    </td>

                </tr>


                @endforelse


            </tbody>


        </table>


    </div>


</section>

@endsection