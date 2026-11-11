@extends('layouts.viewer')

@section('title', 'Lahan Kritis')

@section('heading', 'Data Lahan Kritis Malang Selatan')

@section('hidePageHeading', true)

@section('style')

@vite('resources/css/pages/lahan-kritis/index.css')

@endsection


@section('content')

{{-- =========================================================
     SUCCESS
========================================================= --}}

@if(session('success'))

<div class="page-alert">

    <div class="page-alert-icon">
        ✓
    </div>

    <div>
        {{ session('success') }}
    </div>

</div>

@endif


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

            SISTEM INFORMASI KETAHANAN PANGAN

        </div>


        <h2>
            Data Lahan Kritis Malang Selatan
        </h2>


        <p class="hero-description">

            Informasi kondisi lahan kritis berdasarkan kecamatan
            serta kategori tingkat kekritisan lahan di dalam dan
            di luar kawasan hutan Malang Selatan.

        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                LK
            </div>

            <div>

                <div class="hero-summary-title">
                    Data Lahan Kritis
                </div>

                <div class="hero-summary-text">

                    Informasi kondisi dan tingkat kekritisan
                    lahan yang tersimpan dalam sistem.

                </div>

            </div>

        </div>

    </div>


    <div class="hero-status">

        <span></span>

        <div>

            <strong>
                Data Tersedia
            </strong>

            <small>
                {{ $jumlahKecamatan }} kecamatan
            </small>

        </div>

    </div>

</section>


{{-- =========================================================
     RINGKASAN
========================================================= --}}

<section class="dashboard-panel">

    <div class="panel-header">

        <div class="panel-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Ringkasan Lahan Kritis
                </h3>

                <div class="panel-subtitle">
                    Informasi utama kondisi lahan kritis Malang Selatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            LAHAN KRITIS
        </div>

    </div>


    <div class="summary-grid">


        <div class="summary-item">

            <div class="summary-icon">
                K
            </div>

            <div class="summary-label">
                Jumlah Kecamatan
            </div>

            <div class="summary-value">
                {{ $jumlahKecamatan }}
            </div>

            <div class="summary-unit">
                Kecamatan
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon">
                Ha
            </div>

            <div class="summary-label">
                Total Luas Lahan
            </div>

            <div class="summary-value">
                {{ number_format($totalLahan, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon critical">
                !
            </div>

            <div class="summary-label">
                Total Sangat Kritis
            </div>

            <div class="summary-value">
                {{ number_format($totalSangatKritis, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon warning">
                !
            </div>

            <div class="summary-label">
                Total Kritis
            </div>

            <div class="summary-value">
                {{ number_format($totalKritis, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     GRAFIK
========================================================= --}}

<section class="dashboard-panel">

    <div class="panel-header">

        <div class="panel-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="panel-title">
                    Total Lahan per Kecamatan
                </h3>

                <div class="panel-subtitle">
                    Perbandingan total luas lahan berdasarkan kecamatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            HEKTARE (HA)
        </div>

    </div>


    <div class="chart-container">

        <canvas id="grafikLahanKritis"></canvas>

    </div>

</section>


{{-- =========================================================
     DATA LAHAN KRITIS
========================================================= --}}

<section class="dashboard-panel">


    {{-- HEADER --}}

    <div class="data-header">

        <div class="data-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="data-title">
                    Data Lahan Kritis
                </h3>

                <div class="data-subtitle">
                    Data kondisi lahan berdasarkan kategori tingkat kekritisan
                </div>

            </div>

        </div>


        {{-- KHUSUS ADMIN --}}

        @if(auth()->check() && auth()->user()->role === 'admin')

        <div class="data-actions">

            <a
                href="/lahan-kritis/tambah"
                class="btn btn-primary"
            >
                + Tambah Data
            </a>


            <a
                href="/lahan-kritis/export"
                class="btn btn-secondary"
            >
                Export Excel
            </a>

        </div>

        @endif

    </div>


    {{-- =====================================================
         FILTER
    ===================================================== --}}

    <div class="filter-area">

        <form
            action="/lahan-kritis"
            method="GET"
            class="filter-form"
        >


            <div class="form-group">

                <label>
                    KECAMATAN
                </label>


                <select
                    name="kecamatan"
                    class="form-control"
                >

                    <option value="">
                        Semua Kecamatan
                    </option>


                    @foreach($daftarKecamatan as $kecamatan)

                    <option
                        value="{{ $kecamatan }}"
                        {{ request('kecamatan') == $kecamatan ? 'selected' : '' }}
                    >
                        {{ $kecamatan }}
                    </option>

                    @endforeach

                </select>

            </div>


            <div class="form-group">

                <label>
                    PENCARIAN DATA
                </label>


                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Cari kabupaten atau kecamatan..."
                >

            </div>


            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Cari Data
                </button>


                <a
                    href="/lahan-kritis"
                    class="btn btn-secondary"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- =====================================================
         IMPORT EXCEL - KHUSUS ADMIN
    ===================================================== --}}

    @if(auth()->check() && auth()->user()->role === 'admin')

    <div class="import-area">

        <div>

            <div class="import-title">
                Import Data Excel
            </div>

            <div class="import-description">
                Gunakan file .xlsx, .xls atau .csv
            </div>

        </div>


        <form
            action="/lahan-kritis/import"
            method="POST"
            enctype="multipart/form-data"
            class="import-form"
        >

            @csrf


            <input
                type="file"
                name="file"
                accept=".xlsx,.xls,.csv"
                required
                class="file-control"
            >


            <button
                type="submit"
                class="btn btn-primary"
            >
                Import Excel
            </button>

        </form>

    </div>

    @endif


    {{-- =====================================================
         TABLE INFO
    ===================================================== --}}

    <div class="table-info">

        <span>
            Daftar data lahan kritis yang tersedia
        </span>


        <span class="data-count">

            {{ $lahanKritis->count() }} DATA

        </span>

    </div>


    {{-- =====================================================
         TABLE
    ===================================================== --}}

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>

                    <th rowspan="2">
                        No
                    </th>

                    <th rowspan="2">
                        Kabupaten
                    </th>

                    <th rowspan="2">
                        Kecamatan
                    </th>


                    <th
                        colspan="5"
                        class="group-header"
                    >
                        Dalam Kawasan
                    </th>


                    <th
                        colspan="5"
                        class="group-header"
                    >
                        Luar Kawasan
                    </th>


                    <th rowspan="2">
                        Total (Ha)
                    </th>


                    <th rowspan="2">
                        Aksi
                    </th>

                </tr>


                <tr>

                    <th>
                        Sangat Kritis
                    </th>

                    <th>
                        Kritis
                    </th>

                    <th>
                        Agak Kritis
                    </th>

                    <th>
                        Potensial Kritis
                    </th>

                    <th>
                        Tidak Kritis
                    </th>


                    <th>
                        Sangat Kritis
                    </th>

                    <th>
                        Kritis
                    </th>

                    <th>
                        Agak Kritis
                    </th>

                    <th>
                        Potensial Kritis
                    </th>

                    <th>
                        Tidak Kritis
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($lahanKritis as $data)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td>
                        {{ $data->kabupaten }}
                    </td>


                    <td class="kecamatan">
                        {{ $data->kecamatan }}
                    </td>


                    {{-- DALAM KAWASAN --}}

                    <td class="angka-ha">
                        {{ number_format($data->dalam_sangat_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_agak_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_potensial_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->dalam_tidak_kritis, 2, ',', '.') }}
                    </td>


                    {{-- LUAR KAWASAN --}}

                    <td class="angka-ha">
                        {{ number_format($data->luar_sangat_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_agak_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_potensial_kritis, 2, ',', '.') }}
                    </td>

                    <td class="angka-ha">
                        {{ number_format($data->luar_tidak_kritis, 2, ',', '.') }}
                    </td>


                    {{-- TOTAL --}}

                    <td class="total-ha">
                        {{ number_format($data->total_ha, 2, ',', '.') }}
                    </td>


                    {{-- AKSI --}}

                    <td>

                        <div class="action-group">


                            {{-- DETAIL
                                 BISA DIAKSES PUBLIK --}}

                            <a
                                href="/lahan-kritis/{{ $data->id }}"
                                class="action-btn action-detail"
                            >
                                Detail
                            </a>


                            {{-- EDIT & HAPUS
                                 KHUSUS ADMIN --}}

                            @if(auth()->check() && auth()->user()->role === 'admin')


                            <a
                                href="/lahan-kritis/{{ $data->id }}/edit"
                                class="action-btn action-edit"
                            >
                                Edit
                            </a>


                            <form
                                action="/lahan-kritis/{{ $data->id }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                            >

                                @csrf

                                @method('DELETE')


                                <button
                                    type="submit"
                                    class="action-btn action-delete"
                                >
                                    Hapus
                                </button>

                            </form>


                            @endif

                        </div>

                    </td>

                </tr>


                @empty


                <tr>

                    <td
                        colspan="15"
                        class="empty-data"
                    >
                        Belum ada data lahan kritis.
                    </td>

                </tr>


                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
    document.getElementById('grafikLahanKritis');


if (ctx) {

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($labelGrafik),

            datasets: [{

                label: 'Total Lahan (Ha)',

                data: @json($dataGrafik),

                backgroundColor:
                    'rgba(62, 155, 104, 0.72)',

                borderColor:
                    '#3E9B68',

                borderWidth: 1,

                borderRadius: 5,

                maxBarThickness: 48

            }]

        },


        options: {

            responsive: true,

            maintainAspectRatio: false,


            plugins: {

                legend: {

                    display: false

                },

                tooltip: {

                    displayColors: false

                }

            },


            scales: {

                y: {

                    beginAtZero: true,

                    grid: {

                        color: '#EEF2EF'

                    },

                    border: {

                        display: false

                    },

                    ticks: {

                        color: '#7B877F',

                        font: {

                            size: 10

                        }

                    },

                    title: {

                        display: true,

                        text: 'Luas (Ha)',

                        color: '#7B877F'

                    }

                },


                x: {

                    grid: {

                        display: false

                    },

                    border: {

                        display: false

                    },

                    ticks: {

                        color: '#7B877F',

                        maxRotation: 35,

                        minRotation: 15,

                        font: {

                            size: 10

                        }

                    }

                }

            }

        }

    });

}

</script>

@endsection