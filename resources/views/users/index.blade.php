@extends('layouts.app')

@section('title', 'Kelola Pengguna')
@section('heading', 'Kelola Pengguna')
@section('hidePageHeading', true)

@section('style')
<style>

/* =========================================================
   HERO
========================================================= */

.dashboard-hero {
    position: relative;
    min-height: 285px;
    margin-bottom: 22px;
    padding: 36px 38px;

    display: flex;
    align-items: center;

    overflow: hidden;

    background: linear-gradient(
        120deg,
        #FFFFFF 0%,
        #FBFDFC 52%,
        #EEF7F1 100%
    );

    border: 1px solid #DFE9E2;
    border-radius: 16px;

    box-shadow: 0 8px 28px rgba(37,107,74,.06);
}

.hero-content {
    position: relative;
    z-index: 3;
    width: 72%;
}

.hero-label {
    display: flex;
    align-items: center;
    gap: 10px;

    margin-bottom: 13px;

    color: #6F8176;

    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1px;
}

.hero-label-line {
    width: 31px;
    height: 4px;

    display: inline-block;

    border-radius: 10px;

    background: #3E9B68;
}

.dashboard-hero h2 {
    max-width: 820px;

    margin: 0 0 11px;

    color: #173D2A;

    font-size: 30px;
    font-weight: 750;
    line-height: 1.25;
}

.hero-description {
    max-width: 720px;

    margin: 0;

    color: #738279;

    font-size: 13px;
    line-height: 1.7;
}


/* =========================================================
   HERO SUMMARY
========================================================= */

.hero-summary {
    width: fit-content;
    max-width: 650px;

    margin-top: 25px;
    padding: 12px 17px 12px 12px;

    display: flex;
    align-items: center;
    gap: 13px;

    background: rgba(234,245,238,.82);

    border: 1px solid #E0EEE5;
    border-radius: 11px;
}

.hero-summary-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 9px;

    background: #D9EEE1;

    color: #2F8B5A;

    font-size: 10px;
    font-weight: 800;
}

.hero-summary-title {
    margin-bottom: 3px;

    color: #254633;

    font-size: 12px;
    font-weight: 700;
}

.hero-summary-text {
    color: #77857C;

    font-size: 10px;
    line-height: 1.5;
}


/* =========================================================
   HERO STATUS
========================================================= */

.hero-status {
    position: absolute;
    z-index: 4;

    top: 25px;
    right: 27px;

    display: flex;
    align-items: center;
    gap: 9px;

    padding: 10px 14px;

    background: rgba(255,255,255,.86);

    border: 1px solid #DFEAE3;
    border-radius: 30px;

    box-shadow: 0 5px 16px rgba(37,107,74,.06);
}

.hero-status > span {
    width: 8px;
    height: 8px;

    border-radius: 50%;

    background: #42A66D;
}

.hero-status strong {
    display: block;

    color: #315640;

    font-size: 10px;
}

.hero-status small {
    display: block;

    margin-top: 2px;

    color: #89958E;

    font-size: 9px;
}


/* =========================================================
   HERO DECORATION
========================================================= */

.hero-decoration {
    position: absolute;
    pointer-events: none;
}

.hero-decoration-one {
    width: 370px;
    height: 210px;

    right: -55px;
    bottom: -115px;

    border-radius: 50% 50% 0 0;

    background: rgba(92,174,126,.13);

    transform: rotate(-7deg);
}

.hero-decoration-two {
    width: 330px;
    height: 170px;

    right: 120px;
    bottom: -115px;

    border-radius: 55% 55% 0 0;

    background: rgba(121,194,151,.11);

    transform: rotate(7deg);
}

.hero-decoration-three {
    width: 230px;
    height: 230px;

    right: 40px;
    top: 70px;

    border-radius: 50%;

    background: rgba(105,190,139,.07);
}


/* =========================================================
   ALERT
========================================================= */

.page-alert {
    margin-bottom: 18px;
    padding: 11px 14px;

    display: flex;
    align-items: center;
    gap: 9px;

    border-radius: 9px;

    font-size: 10px;
    font-weight: 600;
}

.alert-success {
    background: #EFF8F2;

    border: 1px solid #D9EBDF;

    color: #347A55;
}

.alert-error {
    background: #FFF2F1;

    border: 1px solid #F0D6D3;

    color: #B54B47;
}

.alert-symbol {
    width: 23px;
    height: 23px;
    min-width: 23px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    font-size: 10px;
    font-weight: 800;
}

.alert-success .alert-symbol {
    background: #DCEFE3;
}

.alert-error .alert-symbol {
    background: #F8DEDC;
}


/* =========================================================
   PANEL
========================================================= */

.dashboard-panel {
    margin-bottom: 18px;

    overflow: hidden;

    background: #FFFFFF;

    border: 1px solid #E1E9E4;
    border-radius: 12px;

    box-shadow: 0 4px 16px rgba(32,59,44,.035);
}

.panel-header {
    min-height: 67px;

    padding: 0 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    border-bottom: 1px solid #E8EDE9;
}

.panel-title-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
}

.panel-mark {
    width: 4px;
    height: 23px;

    border-radius: 10px;

    background: #3E9B68;
}

.panel-title {
    margin: 0 0 3px;

    color: #203B2C;

    font-size: 13px;
    font-weight: 700;
}

.panel-subtitle {
    color: #89958E;

    font-size: 10px;
    line-height: 1.5;
}


/* =========================================================
   HEADER ACTION
========================================================= */

.panel-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.user-count {
    padding: 6px 10px;

    display: inline-flex;
    align-items: center;

    background: #F0F7F2;

    border-radius: 20px;

    color: #4C805F;

    font-size: 9px;
    font-weight: 800;

    white-space: nowrap;
}

.btn-add {
    min-height: 33px;

    padding: 0 12px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 7px;

    background: #3E9B68;

    color: #FFFFFF;

    text-decoration: none;

    font-size: 10px;
    font-weight: 700;

    white-space: nowrap;

    transition: .18s;
}

.btn-add:hover {
    background: #34875B;

    transform: translateY(-1px);
}


/* =========================================================
   INFORMATION BAR
========================================================= */

.table-info {
    padding: 11px 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    background: #FBFCFB;

    border-bottom: 1px solid #E8EDE9;

    color: #89958E;

    font-size: 10px;
}

.table-info strong {
    color: #52675A;
}


/* =========================================================
   TABLE
========================================================= */

.table-wrapper {
    width: 100%;

    overflow-x: auto;
}

.users-table {
    width: 100%;
    min-width: 850px;

    border-collapse: collapse;
}

.users-table th {
    padding: 10px 14px;

    background: #F2F7F3;

    border-bottom: 1px solid #DDE7E0;

    color: #53675B;

    font-size: 9px;
    font-weight: 800;

    text-align: left;

    text-transform: uppercase;

    letter-spacing: .3px;

    white-space: nowrap;
}

.users-table td {
    padding: 12px 14px;

    border-bottom: 1px solid #EDF1EE;

    color: #59675E;

    font-size: 10px;

    vertical-align: middle;
}

.users-table tbody tr:last-child td {
    border-bottom: none;
}

.users-table tbody tr:hover {
    background: #F7FAF8;
}

.col-no {
    width: 55px;

    text-align: center !important;
}

.col-action {
    width: 180px;

    text-align: center !important;
}


/* =========================================================
   USER
========================================================= */

.user-name {
    display: flex;
    align-items: center;
    gap: 10px;
}

.mini-avatar {
    width: 34px;
    height: 34px;
    min-width: 34px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #EAF5EE;

    border: 1px solid #DCECE2;

    color: #347A55;

    font-size: 11px;
    font-weight: 800;
}

.name-text {
    color: #304D3B;

    font-size: 10px;
    font-weight: 700;
}

.current-badge {
    margin-left: 5px;
    padding: 3px 7px;

    display: inline-block;

    background: #EAF5EE;

    border-radius: 10px;

    color: #347A55;

    font-size: 8px;
    font-weight: 800;

    vertical-align: middle;
}

.email-text {
    color: #66756C;
}

.date-text {
    color: #7F8C84;

    white-space: nowrap;
}


/* =========================================================
   ROLE
========================================================= */

.role-badge {
    padding: 5px 9px;

    display: inline-flex;
    align-items: center;

    border-radius: 20px;

    font-size: 9px;
    font-weight: 700;

    white-space: nowrap;
}

.role-admin {
    background: #EAF5EE;

    color: #347A55;
}

.role-viewer {
    background: #F2F4F3;

    color: #6F7C74;
}


/* =========================================================
   ACTION
========================================================= */

.action-group {
    display: flex;
    justify-content: center;
    align-items: center;

    gap: 5px;

    white-space: nowrap;
}

.action-group form {
    margin: 0;
}

.action-btn {
    height: 27px;

    padding: 0 9px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 1px solid transparent;
    border-radius: 6px;

    text-decoration: none;

    font-family: inherit;

    font-size: 9px;
    font-weight: 700;

    cursor: pointer;

    transition: .15s;
}

.action-btn:hover {
    transform: translateY(-1px);
}

.btn-edit {
    background: #FFF7E9;

    border-color: #F0DFC1;

    color: #A97121;
}

.btn-delete {
    background: #FFF2F1;

    border-color: #F0D6D3;

    color: #B54B47;
}

.self-info {
    padding: 5px 8px;

    background: #F4F6F5;

    border-radius: 6px;

    color: #8A958E;

    font-size: 9px;

    white-space: nowrap;
}


/* =========================================================
   EMPTY
========================================================= */

.empty-state {
    padding: 45px 20px !important;

    color: #929D96 !important;

    text-align: center;
}

.empty-symbol {
    width: 48px;
    height: 48px;

    margin: 0 auto 10px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #EAF5EE;

    color: #3E9B68;

    font-size: 10px;
    font-weight: 800;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width: 750px) {

    .dashboard-hero {
        min-height: auto;
        padding: 28px 23px;
    }

    .hero-content {
        width: 100%;
    }

    .dashboard-hero h2 {
        font-size: 25px;
    }

    .hero-description {
        font-size: 12px;
    }

    .hero-status {
        position: relative;

        top: auto;
        right: auto;

        width: fit-content;

        margin-top: 18px;
    }

    .panel-header {
        padding: 16px 18px;

        flex-direction: column;
        align-items: flex-start;
    }

    .panel-actions {
        width: 100%;

        justify-content: space-between;
    }

    .table-info {
        padding: 10px 18px;
    }
}

</style>
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