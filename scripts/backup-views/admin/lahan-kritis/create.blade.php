@extends('layouts.app')

@section('title', 'Tambah Lahan Kritis')

@section('heading', 'Tambah Data Lahan Kritis')

@section('content')

<style>
    .form-page {
        width: 100%;
        color: #203B2C;
    }

    .form-panel {
        background: #FFFFFF;
        border: 1px solid #E1E9E4;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(32,59,44,.04);
        overflow: hidden;
    }

    .form-header {
        padding: 22px 25px;
        border-bottom: 1px solid #E8EDE9;
        background: #FBFCFB;
    }

    .form-header-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-header-mark {
        width: 4px;
        height: 28px;
        border-radius: 10px;
        background: #3E9B68;
    }

    .form-header h2 {
        margin: 0 0 4px;
        color: #203B2C;
        font-size: 18px;
        font-weight: 700;
    }

    .form-header p {
        margin: 0;
        color: #89958E;
        font-size: 11px;
    }

    .form-body {
        padding: 25px;
    }

    .section-title {
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #E8EDE9;
        color: #365541;
        font-size: 13px;
        font-weight: 800;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 25px;
    }

    .form-group {
        width: 100%;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        color: #5C6C62;
        font-size: 10px;
        font-weight: 800;
    }

    .required {
        color: #C85C54;
    }

    .form-control {
        width: 100%;
        height: 38px;
        padding: 0 11px;
        box-sizing: border-box;

        background: #FFFFFF;
        border: 1px solid #DCE5DF;
        border-radius: 7px;

        outline: none;
        color: #4D5D53;
        font-family: inherit;
        font-size: 11px;

        transition: .18s;
    }

    .form-control:focus {
        border-color: #69BE8B;
        box-shadow: 0 0 0 3px rgba(105,190,139,.10);
    }

    .form-control.number {
        text-align: right;
    }

    .category-box {
        padding: 18px;
        margin-bottom: 25px;

        background: #FAFCFB;
        border: 1px solid #E5ECE7;
        border-radius: 10px;
    }

    .category-title {
        margin-bottom: 15px;
        color: #365541;
        font-size: 12px;
        font-weight: 800;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
    }

    .category-item label {
        display: block;
        min-height: 30px;
        margin-bottom: 6px;
        color: #66736B;
        font-size: 9px;
        font-weight: 700;
        line-height: 1.4;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;

        padding-top: 20px;
        border-top: 1px solid #E8EDE9;
    }

    .btn {
        min-height: 36px;
        padding: 0 15px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid transparent;
        border-radius: 7px;

        cursor: pointer;
        text-decoration: none;

        font-family: inherit;
        font-size: 10px;
        font-weight: 700;

        transition: .18s;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-primary {
        background: #3E9B68;
        border-color: #3E9B68;
        color: #FFFFFF;
    }

    .btn-primary:hover {
        background: #34875B;
    }

    .btn-secondary {
        background: #FFFFFF;
        border-color: #DCE5DF;
        color: #5D6B62;
    }

    .btn-secondary:hover {
        background: #F5F8F6;
    }

    .alert-error {
        margin-bottom: 20px;
        padding: 12px 15px;

        background: #FFF4F2;
        border: 1px solid #F0DAD6;
        border-radius: 8px;

        color: #A74E47;
        font-size: 10px;
    }

    .alert-error ul {
        margin: 6px 0 0 18px;
        padding: 0;
    }

    .info-box {
        margin-bottom: 22px;
        padding: 12px 14px;

        background: #EFF8F2;
        border: 1px solid #D9EBDF;
        border-radius: 8px;

        color: #347A55;
        font-size: 10px;
        line-height: 1.6;
    }

    @media (max-width: 1000px) {
        .category-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 700px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-body {
            padding: 18px;
        }
    }

    @media (max-width: 480px) {
        .category-grid {
            grid-template-columns: 1fr;
        }

        .form-footer {
            flex-direction: column;
        }

        .form-footer .btn {
            width: 100%;
        }
    }
</style>

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