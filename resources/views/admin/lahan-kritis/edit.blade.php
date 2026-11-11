@extends('layouts.app')

@section('title', 'Edit Lahan Kritis')

@section('heading', 'Edit Data Lahan Kritis')

@section('content')

@vite('resources/css/pages/admin/lahan-kritis/edit.css')

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
                    <h2>Edit Data Lahan Kritis</h2>

                    <p>
                        Perbarui data kondisi lahan kritis berdasarkan kecamatan.
                    </p>
                </div>
            </div>
        </div>

        <div class="form-body">

            <div class="info-box">
                Silakan perbarui data pada formulir di bawah.
                Total luas lahan akan dihitung otomatis oleh sistem.
            </div>

            <form
                action="{{ route('admin.lahan-kritis.update', $lahanKritis->id) }}"
                method="POST"
            >

                @csrf
                @method('PUT')

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
                            value="{{ old('kabupaten', $lahanKritis->kabupaten) }}"
                            required
                        >

                        @error('kabupaten')
                            <div class="error-text">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            Kecamatan <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            name="kecamatan"
                            class="form-control"
                            value="{{ old('kecamatan', $lahanKritis->kecamatan) }}"
                            required
                        >

                        @error('kecamatan')
                            <div class="error-text">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>


                {{-- DALAM KAWASAN --}}
                <div class="category-box">

                    <div class="category-title">
                        Dalam Kawasan Hutan
                    </div>

                    <div class="category-grid">

                        <div class="category-item">
                            <label>Sangat Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_sangat_kritis"
                                class="form-control number"
                                value="{{ old('dalam_sangat_kritis', $lahanKritis->dalam_sangat_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_kritis"
                                class="form-control number"
                                value="{{ old('dalam_kritis', $lahanKritis->dalam_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Agak Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_agak_kritis"
                                class="form-control number"
                                value="{{ old('dalam_agak_kritis', $lahanKritis->dalam_agak_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Potensial Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_potensial_kritis"
                                class="form-control number"
                                value="{{ old('dalam_potensial_kritis', $lahanKritis->dalam_potensial_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Tidak Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="dalam_tidak_kritis"
                                class="form-control number"
                                value="{{ old('dalam_tidak_kritis', $lahanKritis->dalam_tidak_kritis) }}"
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
                            <label>Sangat Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_sangat_kritis"
                                class="form-control number"
                                value="{{ old('luar_sangat_kritis', $lahanKritis->luar_sangat_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_kritis"
                                class="form-control number"
                                value="{{ old('luar_kritis', $lahanKritis->luar_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Agak Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_agak_kritis"
                                class="form-control number"
                                value="{{ old('luar_agak_kritis', $lahanKritis->luar_agak_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Potensial Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_potensial_kritis"
                                class="form-control number"
                                value="{{ old('luar_potensial_kritis', $lahanKritis->luar_potensial_kritis) }}"
                            >
                        </div>

                        <div class="category-item">
                            <label>Tidak Kritis (Ha)</label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                name="luar_tidak_kritis"
                                class="form-control number"
                                value="{{ old('luar_tidak_kritis', $lahanKritis->luar_tidak_kritis) }}"
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
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection