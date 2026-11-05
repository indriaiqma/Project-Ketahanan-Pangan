{{--
    Tabel data kawasan hutan + filter.
    Parameter: $admin (bool) - tampilan panel pengelola (export). Tombol tambah/ubah/import
    hanya untuk role yang boleh mengubah data, tombol hapus hanya untuk Admin.
--}}
@php
    $indexRoute = $admin ? 'admin.kawasan-hutan.index' : 'kawasan-hutan.index';
    $bisaUbah = $admin && auth()->user()?->canEditData();
    $difilter = request()->filled('kecamatan') || request()->filled('search');
@endphp

<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-table"></i></span>
            <div>
                <h2>Data Kawasan Hutan</h2>
                <p>{{ $difilter ? 'Hasil filter: ' : '' }}{{ angka($kawasanHutans->count(), 0) }} data ditampilkan</p>
            </div>
        </div>
        @if ($admin)
            <a href="{{ route('admin.kawasan-hutan.export') }}" class="btn btn-outline btn-sm"><i class="bi bi-download"></i> Export Excel</a>
        @endif
    </div>

    @if ($bisaUbah)
        <form action="{{ route('admin.kawasan-hutan.import') }}" method="POST" enctype="multipart/form-data" class="file-drop">
            @csrf
            <div class="meta">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <div>
                    <b>Import dari Excel</b>
                    Format .xlsx, .xls, atau .csv (maks. 2 MB) dengan kolom: kabupaten, kecamatan, desa, nama_kawasan, jenis_kawasan, luas_ha, keterangan.
                </div>
            </div>
            <span class="file-name" id="kh-file-name">Belum ada file dipilih</span>
            <label class="btn btn-outline btn-sm file-pick">
                <i class="bi bi-folder2-open"></i> Pilih File
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required data-file-input="#kh-file-name">
            </label>
            <button type="submit" class="btn btn-primary btn-sm" disabled data-keep-disabled data-loading="Mengimpor…"><i class="bi bi-upload"></i> Import</button>
        </form>
    @endif

    <form action="{{ route($indexRoute) }}" method="GET" class="toolbar" role="search">
        <div class="input-group grow">
            <i class="bi bi-search lead"></i>
            <input type="search" name="search" value="{{ request('search') }}" class="input" placeholder="Cari nama kawasan, desa, kecamatan, jenis…" aria-label="Cari data">
        </div>
        <select name="kecamatan" class="select" aria-label="Filter kecamatan">
            <option value="">Semua kecamatan</option>
            @foreach ($daftarKecamatan as $kecamatan)
                <option value="{{ $kecamatan }}" @selected(request('kecamatan') == $kecamatan)>{{ $kecamatan }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Terapkan</button>
        @if ($difilter)
            <a href="{{ route($indexRoute) }}" class="btn btn-ghost"><i class="bi bi-x-lg"></i> Reset</a>
        @endif
    </form>

    @if ($kawasanHutans->isEmpty())
        <x-empty icon="tree" :title="$difilter ? 'Tidak ada data yang cocok' : 'Belum ada data kawasan hutan'">
            @if ($difilter)
                Coba ubah kata kunci atau pilihan kecamatan.
            @elseif ($bisaUbah)
                Tambahkan data secara manual atau import dari file Excel.
            @else
                Data akan tampil setelah ditambahkan oleh admin.
            @endif
            @if ($bisaUbah && ! $difilter)
                <x-slot:action>
                    <a href="{{ route('admin.kawasan-hutan.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Data</a>
                </x-slot:action>
            @endif
        </x-empty>
    @else
        <div class="table-wrap">
            <table class="table compact">
                <thead>
                    <tr>
                        <th class="no">No</th>
                        <th>Nama Kawasan</th>
                        <th>Jenis</th>
                        <th>Lokasi</th>
                        <th class="r">Luas (Ha)</th>
                        <th>Keterangan</th>
                        <th class="r">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kawasanHutans as $kawasan)
                        <tr>
                            <td class="no">{{ $loop->iteration }}</td>
                            <td class="strong">{{ $kawasan->nama_kawasan }}</td>
                            <td class="nowrap"><span class="badge green">{{ $kawasan->jenis_kawasan }}</span></td>
                            <td class="nowrap">
                                {{ $kawasan->kecamatan }}{{ $kawasan->desa ? ', ' . $kawasan->desa : '' }}
                                <small class="muted" style="display:block;font-size:12px">{{ $kawasan->kabupaten }}</small>
                            </td>
                            <td class="r nowrap">{{ $kawasan->luas_ha !== null ? angka($kawasan->luas_ha) : '–' }}</td>
                            <td class="clip" title="{{ $kawasan->keterangan }}">{{ $kawasan->keterangan ?: '–' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('kawasan-hutan.show', $kawasan) }}" class="btn btn-outline btn-icon" title="Lihat detail" aria-label="Lihat detail"><i class="bi bi-eye"></i></a>
                                    @if ($bisaUbah)
                                        <a href="{{ route('admin.kawasan-hutan.edit', $kawasan) }}" class="btn btn-outline btn-icon" title="Ubah" aria-label="Ubah"><i class="bi bi-pencil"></i></a>
                                        @if (auth()->user()->isAdmin())
                                            <form action="{{ route('admin.kawasan-hutan.destroy', $kawasan) }}" method="POST"
                                                  data-confirm="Hapus data kawasan &quot;{{ $kawasan->nama_kawasan }}&quot;? Tindakan ini tidak dapat dibatalkan.">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline btn-icon danger" title="Hapus" aria-label="Hapus"><i class="bi bi-trash"></i></button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total luas</td>
                        <td class="r">{{ angka($kawasanHutans->sum('luas_ha')) }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</section>
