@extends('layouts.app')

@section('title', 'Tambah Lahan Kritis')

@section('heading', 'Tambah Data Lahan Kritis')

@section('content')

@vite('resources/css/pages/admin/lahan-kritis/create.css')

<div class="form-page">

    @if ($errors->any())
        <div class="alert-error">

            <strong>Data belum dapat disimpan.</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <div class="form-panel">

        <div class="form-header">

            <div class="form-header-title">

                <span class="form-header-mark"></span>

                <div>

                    <h2>
                        Tambah Data Lahan Kritis
                    </h2>

                    <p>
                        Masukkan data kondisi lahan kritis berdasarkan kecamatan.
                    </p>

                </div>

            </div>

        </div>


        <div class="form-body">

            <div class="info-box">
                Isi seluruh data yang diperlukan.
                Total luas lahan akan dihitung otomatis oleh sistem.
            </div>


            <form
                action="{{ route('admin.lahan-kritis.store') }}"
                method="POST"
            >

                @csrf


                {{-- DATA WILAYAH --}}

                <h3 class="section-title">
                    Data Wilayah
                </h3>


                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            Kabupaten <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="kabupaten"
                            class="form-control"
                            value="{{ old('kabupaten', 'Malang') }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Kecamatan <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="kecamatan"
                            class="form-control"
                            value="{{ old('kecamatan') }}"
                            required
                        >

                    </div>

                </div>


                {{-- DALAM KAWASAN --}}

                <div class="category-box">

                    <div class="category-title">
                        Dalam Kawasan Hutan
                    </div>


                    <div class="category-grid">

                        <div class="category-item">

                            <label>
                                Sangat Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_sangat_kritis"
                                class="form-control number"
                                value="{{ old('dalam_sangat_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_kritis"
                                class="form-control number"
                                value="{{ old('dalam_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Agak Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_agak_kritis"
                                class="form-control number"
                                value="{{ old('dalam_agak_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Potensial Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_potensial_kritis"
                                class="form-control number"
                                value="{{ old('dalam_potensial_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Tidak Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_tidak_kritis"
                                class="form-control number"
                                value="{{ old('dalam_tidak_kritis', 0) }}"
                            >

                        </div>

                    </div>

                </div>


                {{-- LUAR KAWASAN --}}

                <div class="category-box">

                    <div class="category-title">
                        Luar Kawasan Hutan
                    </div>


                    <div class="category-grid">

                        <div class="category-item">

                            <label>
                                Sangat Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_sangat_kritis"
                                class="form-control number"
                                value="{{ old('luar_sangat_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_kritis"
                                class="form-control number"
                                value="{{ old('luar_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Agak Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_agak_kritis"
                                class="form-control number"
                                value="{{ old('luar_agak_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Potensial Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_potensial_kritis"
                                class="form-control number"
                                value="{{ old('luar_potensial_kritis', 0) }}"
                            >

                        </div>


                        <div class="category-item">

                            <label>
                                Tidak Kritis (Ha)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_tidak_kritis"
                                class="form-control number"
                                value="{{ old('luar_tidak_kritis', 0) }}"
                            >

                        </div>

                    </div>

                </div>


                {{-- BUTTON --}}

                <div class="form-footer">

                    <a
                        href="{{ route('admin.lahan-kritis.index') }}"
                        class="btn btn-secondary"
                    >
                        Kembali
                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Simpan Data
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection