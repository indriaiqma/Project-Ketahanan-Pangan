@extends('layouts.viewer')

@section('title', 'Kawasan Hutan')

@section('heading', 'Data Kawasan Hutan Malang Selatan')

@section('hidePageHeading', true)

@section('style')

@vite('resources/css/pages/kawasan-hutan/index.css')

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
            Data Kawasan Hutan Malang Selatan
        </h2>


        <p class="hero-description">

            Informasi kawasan hutan berdasarkan lokasi,
            jenis kawasan, luas wilayah, dan data pendukung
            kehutanan di Malang Selatan.

        </p>


        <div class="hero-summary">

            <div class="hero-summary-icon">
                KH
            </div>

            <div>

                <div class="hero-summary-title">
                    Data Kawasan Hutan
                </div>

                <div class="hero-summary-text">

                    Informasi kawasan hutan yang tersedia
                    dalam sistem informasi Malang Selatan.

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
                {{ $totalKawasan }} data kawasan
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
                    Ringkasan Kawasan Hutan
                </h3>

                <div class="panel-subtitle">
                    Informasi utama data kehutanan Malang Selatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            INFORMASI PUBLIK
        </div>

    </div>


    <div class="summary-grid">


        <div class="summary-item">

            <div class="summary-icon">
                KH
            </div>

            <div class="summary-label">
                Total Kawasan
            </div>

            <div class="summary-value">
                {{ $totalKawasan }}
            </div>

            <div class="summary-unit">
                Data kawasan
            </div>

        </div>


        <div class="summary-item">

            <div class="summary-icon">
                Ha
            </div>

            <div class="summary-label">
                Total Luas
            </div>

            <div class="summary-value">
                {{ number_format($totalLuas, 2, ',', '.') }}
            </div>

            <div class="summary-unit">
                Hektare
            </div>

        </div>


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
                JK
            </div>

            <div class="summary-label">
                Jenis Kawasan
            </div>

            <div class="summary-value">
                {{ $jumlahJenisKawasan }}
            </div>

            <div class="summary-unit">
                Jenis kawasan
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
                    Luas Kawasan per Kecamatan
                </h3>

                <div class="panel-subtitle">
                    Perbandingan luas kawasan hutan berdasarkan kecamatan
                </div>

            </div>

        </div>


        <div class="panel-badge">
            HEKTARE (HA)
        </div>

    </div>


    <div class="chart-container">

        <canvas id="grafikKecamatan"></canvas>

    </div>

</section>


{{-- =========================================================
     DATA PUBLIK
========================================================= --}}

<section class="dashboard-panel">


    {{-- DATA HEADER --}}

    <div class="data-header">

        <div class="data-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="data-title">
                    Data Kawasan Hutan
                </h3>

                <div class="data-subtitle">
                    Daftar kawasan hutan Malang Selatan
                </div>

            </div>

        </div>


        <div class="data-count">
            {{ $kawasanHutans->count() }} DATA
        </div>

    </div>


    {{-- FILTER --}}

    <div class="filter-area">

        <form
            action="{{ route('kawasan-hutan.index') }}"
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
                    placeholder="Cari nama kawasan, desa atau kecamatan..."
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
                    href="{{ route('kawasan-hutan.index') }}"
                    class="btn btn-secondary"
                >
                    Reset
                </a>

            </div>


        </form>

    </div>


    {{-- TABLE INFO --}}

    <div class="table-info">

        <span>
            Daftar kawasan hutan yang tersedia untuk publik
        </span>


        <span class="data-count">
            {{ $kawasanHutans->count() }} DATA
        </span>

    </div>


    {{-- TABLE --}}

    <div class="table-wrapper">

        <table class="data-table">

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Kabupaten
                    </th>

                    <th>
                        Kecamatan
                    </th>

                    <th>
                        Desa
                    </th>

                    <th>
                        Nama Kawasan
                    </th>

                    <th>
                        Jenis Kawasan
                    </th>

                    <th>
                        Luas
                    </th>

                    <th>
                        Keterangan
                    </th>

                    <th>
                        Detail
                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($kawasanHutans as $data)

                    <tr>


                        <td>
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            {{ $data->kabupaten }}
                        </td>


                        <td>
                            {{ $data->kecamatan }}
                        </td>


                        <td>
                            {{ $data->desa ?? '-' }}
                        </td>


                        <td>

                            <span class="name-value">
                                {{ $data->nama_kawasan }}
                            </span>

                        </td>


                        <td>

                            <span class="type-badge">
                                {{ $data->jenis_kawasan }}
                            </span>

                        </td>


                        <td>

                            <span class="area-value">

                                {{ number_format($data->luas_ha, 2, ',', '.') }}

                                Ha

                            </span>

                        </td>


                        <td>
                            {{ $data->keterangan ?? '-' }}
                        </td>


                        <td>

                            <div class="action-group">

                                <a
                                    href="{{ route('kawasan-hutan.show', $data->id) }}"
                                    class="action-detail"
                                >
                                    Detail
                                </a>

                            </div>

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="empty-data"
                        >

                            Belum ada data kawasan hutan.

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
    document.getElementById('grafikKecamatan');


if (ctx) {

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($labelGrafik),

            datasets: [{

                label: 'Luas Kawasan (Ha)',

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