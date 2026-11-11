@extends('layouts.app')

@section('title', 'Kawasan Hutan')

@section('heading', 'Data Kawasan Hutan Malang Selatan')

@section('hidePageHeading', true)


@section('style')

@vite('resources/css/pages/admin/kawasan-hutan/index.css')

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

            Informasi dan pengelolaan data kawasan hutan berdasarkan
            lokasi, jenis kawasan, luas wilayah, dan data pendukung
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

                    Informasi kawasan hutan yang tersimpan
                    dan dikelola melalui sistem.

                </div>

            </div>

        </div>


    </div>


    <div class="hero-status">

        <span></span>

        <div>

            <strong>
                Mode Administrator
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
            ADMINISTRATOR
        </div>


    </div>



    <div class="summary-grid">


        {{-- TOTAL KAWASAN --}}

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



        {{-- TOTAL LUAS --}}

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



        {{-- JUMLAH KECAMATAN --}}

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



        {{-- JENIS KAWASAN --}}

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
     DATA KAWASAN HUTAN
========================================================= --}}

<section class="dashboard-panel">


    {{-- HEADER --}}

    <div class="data-header">


        <div class="data-title-wrap">

            <span class="panel-mark"></span>

            <div>

                <h3 class="data-title">
                    Data Kawasan Hutan
                </h3>

                <div class="data-subtitle">
                    Kelola data kawasan hutan Malang Selatan
                </div>

            </div>

        </div>


        <div class="data-actions">


            <a
                href="{{ route('admin.kawasan-hutan.create') }}"
                class="btn btn-primary"
            >
                + Tambah Data
            </a>


            <a
                href="{{ route('admin.kawasan-hutan.export') }}"
                class="btn btn-secondary"
            >
                Export Excel
            </a>


        </div>


    </div>



    {{-- FILTER --}}

    <div class="filter-area">


        <form
            action="{{ route('admin.kawasan-hutan.index') }}"
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
                    href="{{ route('admin.kawasan-hutan.index') }}"
                    class="btn btn-secondary"
                >
                    Reset
                </a>


            </div>


        </form>


    </div>



    {{-- IMPORT --}}

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
            action="{{ route('admin.kawasan-hutan.import') }}"
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



    {{-- TABLE INFO --}}

    <div class="table-info">


        <span>
            Daftar kawasan hutan yang tersedia
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
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>


                @forelse($kawasanHutans as $index => $kawasan)


                    <tr>


                        {{-- NO --}}

                        <td>
                            {{ $index + 1 }}
                        </td>


                        {{-- KABUPATEN --}}

                        <td>
                            {{ $kawasan->kabupaten ?? '-' }}
                        </td>


                        {{-- KECAMATAN --}}

                        <td>
                            {{ $kawasan->kecamatan ?? '-' }}
                        </td>


                        {{-- DESA --}}

                        <td>
                            {{ $kawasan->desa ?? '-' }}
                        </td>


                        {{-- NAMA KAWASAN --}}

                        <td>

                            <span class="name-value">

                                {{ $kawasan->nama_kawasan ?? '-' }}

                            </span>

                        </td>


                        {{-- JENIS KAWASAN --}}

                        <td>

                            <span class="type-badge">

                                {{ $kawasan->jenis_kawasan ?? '-' }}

                            </span>

                        </td>


                        {{-- LUAS --}}

                        <td>

                            <span class="area-value">

                                {{ number_format((float) ($kawasan->luas_ha ?? 0), 2, ',', '.') }}

                                Ha

                            </span>

                        </td>


                        {{-- KETERANGAN --}}

                        <td>

                            {{ $kawasan->keterangan ?? '-' }}

                        </td>


                        {{-- AKSI --}}

                        <td>


                            <div class="action-group">


                                {{-- EDIT --}}

                                <a
                                    href="{{ route('admin.kawasan-hutan.edit', $kawasan->id) }}"
                                    class="action-btn action-edit"
                                >
                                    Edit
                                </a>


                                {{-- HAPUS --}}

                                <form
                                    action="{{ route('admin.kawasan-hutan.destroy', $kawasan->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data kawasan hutan ini?')"
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



{{-- =========================================================
     CHART.JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {


    const canvas =
        document.getElementById('grafikKecamatan');


    if (!canvas) {

        return;

    }


    /*
     * DATA GRAFIK DARI CONTROLLER
     *
     * Controller kamu sudah menyediakan:
     *
     * $labelGrafik
     * $dataGrafik
     *
     * Jadi kita langsung menggunakan data tersebut.
     */

    const labels =
        @json($labelGrafik);


    const values =
        @json($dataGrafik);



    /*
     * Pastikan hasil JSON berupa array.
     */

    const chartLabels =
        Array.isArray(labels)
            ? labels
            : Object.values(labels);


    const chartValues =
        Array.isArray(values)
            ? values
            : Object.values(values);



    /*
     * Kalau tidak ada data.
     */

    if (
        chartLabels.length === 0 ||
        chartValues.length === 0
    ) {

        const container =
            canvas.parentElement;


        container.innerHTML = `

            <div class="chart-empty">

                Belum ada data kawasan hutan
                untuk ditampilkan.

            </div>

        `;

        return;

    }



    /*
     * Buat grafik.
     */

    new Chart(canvas, {

        type: 'bar',


        data: {

            labels: chartLabels,


            datasets: [

                {

                    label: 'Luas Kawasan (Ha)',


                    data: chartValues,


                    backgroundColor:
                        'rgba(62, 155, 104, 0.78)',


                    borderColor:
                        '#3E9B68',


                    borderWidth: 1,


                    borderRadius: 7,


                    borderSkipped: false,


                    maxBarThickness: 60

                }

            ]

        },


        options: {

            responsive: true,


            maintainAspectRatio: false,


            animation: {

                duration: 700

            },


            plugins: {

                legend: {

                    display: false

                },


                tooltip: {

                    backgroundColor:
                        '#203B2C',


                    titleColor:
                        '#FFFFFF',


                    bodyColor:
                        '#FFFFFF',


                    padding: 10,


                    displayColors: false,


                    callbacks: {

                        label: function(context) {


                            const value =
                                Number(context.raw || 0);


                            return 'Luas: ' +

                                value.toLocaleString(
                                    'id-ID',
                                    {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }
                                ) +

                                ' Ha';

                        }

                    }

                }

            },


            scales: {

                x: {

                    grid: {

                        display: false

                    },


                    border: {

                        display: false

                    },


                    ticks: {

                        color:
                            '#718078',


                        font: {

                            size: 10,

                            weight: '600'

                        },


                        maxRotation: 0,

                        minRotation: 0

                    }

                },


                y: {

                    beginAtZero: true,


                    border: {

                        display: false

                    },


                    grid: {

                        color:
                            'rgba(65, 105, 80, 0.08)'

                    },


                    ticks: {

                        color:
                            '#89958E',


                        font: {

                            size: 9

                        },


                        callback:
                            function(value) {

                                return Number(value)
                                    .toLocaleString(
                                        'id-ID'
                                    );

                            }

                    },


                    title: {

                        display: true,


                        text:
                            'Luas (Hektare)',


                        color:
                            '#718078',


                        font: {

                            size: 10,

                            weight: '600'

                        }

                    }

                }

            }

        }

    });


});

</script>


@endsection