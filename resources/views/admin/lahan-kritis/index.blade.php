@extends('layouts.app')

@section('title', 'Lahan Kritis')

@section('heading', 'Data Lahan Kritis Malang Selatan')

@section('hidePageHeading', true)

@section('style')

@vite('resources/css/pages/admin/lahan-kritis/index.css')

@endsection


@section('content')

<div class="dashboard-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

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


        {{-- STATUS --}}

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


    {{-- =====================================================
         ALERT SUCCESS
    ====================================================== --}}

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


    {{-- =====================================================
         ALERT ERROR
    ====================================================== --}}

    @if(session('error'))

        <div class="page-alert page-alert-error">

            <div class="page-alert-icon page-alert-icon-error">
                !
            </div>

            <div>
                {{ session('error') }}
            </div>

        </div>

    @endif


    {{-- =====================================================
         RINGKASAN
    ====================================================== --}}

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


            {{-- TOTAL LUAS --}}

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


            {{-- SANGAT KRITIS --}}

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


            {{-- KRITIS --}}

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


    {{-- =====================================================
         GRAFIK
    ====================================================== --}}

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


    {{-- =====================================================
         DATA LAHAN KRITIS
    ====================================================== --}}

    <section class="dashboard-panel">

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


            {{-- AKSI ADMIN --}}

            @if(auth()->check() && auth()->user()->role === 'admin')

    <div class="data-actions">

        <a
            href="{{ route('admin.lahan-kritis.create') }}"
            class="btn btn-primary"
        >
            + Tambah Data
        </a>

        <a
            href="{{ route('admin.lahan-kritis.export') }}"
            class="btn btn-secondary"
        >
            Export Excel
        </a>

    </div>

@endif

        </div>


        {{-- =================================================
             FILTER
        ================================================== --}}

        <div class="filter-area">

            <form
                action="{{ route('admin.lahan-kritis.index') }}"
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
                        href="{{ route('admin.lahan-kritis.index') }}"
                        class="btn btn-secondary"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- =================================================
             IMPORT EXCEL
        ================================================== --}}

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
                    action="{{ route('admin.lahan-kritis.import') }}"
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


        {{-- =================================================
             INFO TABLE
        ================================================== --}}

        <div class="table-info">

            <span>
                Daftar data lahan kritis yang tersedia
            </span>

            <span class="data-count">
                {{ $lahanKritis->count() }} DATA
            </span>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

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
                                {{ number_format($data->dalam_sangat_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->dalam_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->dalam_agak_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->dalam_potensial_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->dalam_tidak_kritis ?? 0, 2, ',', '.') }}
                            </td>


                            {{-- LUAR KAWASAN --}}

                            <td class="angka-ha">
                                {{ number_format($data->luar_sangat_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->luar_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->luar_agak_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->luar_potensial_kritis ?? 0, 2, ',', '.') }}
                            </td>

                            <td class="angka-ha">
                                {{ number_format($data->luar_tidak_kritis ?? 0, 2, ',', '.') }}
                            </td>


                            {{-- TOTAL --}}

                            <td class="total-ha">
                                {{ number_format($data->total_ha ?? 0, 2, ',', '.') }}
                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="action-group">

                                    @if(auth()->check() && auth()->user()->role === 'admin')

                                        {{-- EDIT --}}

                                        <a
                                            href="{{ route('admin.lahan-kritis.edit', $data->id) }}"
                                            class="action-btn action-edit"
                                        >
                                            Edit
                                        </a>


                                        {{-- HAPUS --}}

                                        <form
                                            action="{{ route('admin.lahan-kritis.destroy', $data->id) }}"
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

                                    @else

                                        <span class="action-empty">
                                            -
                                        </span>

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

</div>

@endsection


@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('grafikLahanKritis');

    if (!canvas) {
        return;
    }

    const labels = @json($labelGrafik ?? []);
    const data = @json($dataGrafik ?? []);

    new Chart(canvas, {

        type: 'bar',

        data: {

            labels: labels,

            datasets: [

                {
                    label: 'Total Lahan (Ha)',

                    data: data,

                    backgroundColor: 'rgba(62, 155, 104, 0.72)',

                    borderColor: '#3E9B68',

                    borderWidth: 1,

                    borderRadius: 5,

                    maxBarThickness: 48
                }

            ]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            interaction: {

                mode: 'index',

                intersect: false

            },

            plugins: {

                legend: {

                    display: false

                },

                tooltip: {

                    displayColors: false,

                    callbacks: {

                        label: function(context) {

                            const value = Number(context.raw || 0);

                            return ' ' +
                                value.toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) +
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

                        color: '#718078',

                        font: {
                            size: 10
                        }

                    }

                },

                y: {

                    beginAtZero: true,

                    grid: {
                        color: '#EEF2EF'
                    },

                    border: {
                        display: false
                    },

                    ticks: {

                        color: '#718078',

                        font: {
                            size: 10
                        },

                        callback: function(value) {

                            return Number(value)
                                .toLocaleString('id-ID');

                        }

                    }

                }

            }

        }

    });

});

</script>

@endsection