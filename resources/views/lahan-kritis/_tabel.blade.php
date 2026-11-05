{{--
    Tabel data lahan kritis + filter.
    Parameter: $admin (bool) - tampilan panel pengelola (export). Tombol tambah/ubah/import
    hanya untuk role yang boleh mengubah data, tombol hapus hanya untuk Admin.
--}}
@php
    $indexRoute = $admin ? 'admin.lahan-kritis.index' : 'lahan-kritis.index';
    $bisaUbah = $admin && auth()->user()?->canEditData();
    $difilter = request()->filled('kecamatan') || request()->filled('search');
    $kategori = ['sangat_kritis' => 'Sangat Kritis', 'kritis' => 'Kritis', 'agak_kritis' => 'Agak Kritis', 'potensial_kritis' => 'Potensial', 'tidak_kritis' => 'Tidak Kritis'];
@endphp

<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-table"></i></span>
            <div>
                <h2>Data Lahan Kritis per Kecamatan</h2>
                <p>{{ $difilter ? 'Hasil filter: ' : '' }}{{ angka($lahanKritis->count(), 0) }} data ditampilkan · luas dalam hektare</p>
            </div>
        </div>
        @if ($admin)
            <a href="{{ route('admin.lahan-kritis.export') }}" class="btn btn-outline btn-sm"><i class="bi bi-download"></i> Export Excel</a>
        @endif
    </div>

    @if ($bisaUbah)
        <form action="{{ route('admin.lahan-kritis.import') }}" method="POST" enctype="multipart/form-data" class="file-drop">
            @csrf
            <div class="meta">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <div>
                    <b>Import dari Excel</b>
                    Format .xlsx, .xls, atau .csv (maks. 2 MB). Hanya kecamatan wilayah Malang Selatan yang diimpor; data kecamatan yang sudah ada akan diperbarui.
                </div>
            </div>
            <span class="file-name" id="lk-file-name">Belum ada file dipilih</span>
            <label class="btn btn-outline btn-sm file-pick">
                <i class="bi bi-folder2-open"></i> Pilih File
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required data-file-input="#lk-file-name">
            </label>
            <button type="submit" class="btn btn-primary btn-sm" disabled data-keep-disabled data-loading="Mengimpor…"><i class="bi bi-upload"></i> Import</button>
        </form>
    @endif

    <form action="{{ route($indexRoute) }}" method="GET" class="toolbar" role="search">
        <div class="input-group grow">
            <i class="bi bi-search lead"></i>
            <input type="search" name="search" value="{{ request('search') }}" class="input" placeholder="Cari kabupaten atau kecamatan…" aria-label="Cari data">
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

    @if ($lahanKritis->isEmpty())
        <x-empty icon="exclamation-triangle" :title="$difilter ? 'Tidak ada data yang cocok' : 'Belum ada data lahan kritis'">
            @if ($difilter)
                Coba ubah kata kunci atau pilihan kecamatan.
            @elseif ($bisaUbah)
                Tambahkan data secara manual atau import dari file Excel.
            @else
                Data akan tampil setelah ditambahkan oleh admin.
            @endif
            @if ($bisaUbah && ! $difilter)
                <x-slot:action>
                    <a href="{{ route('admin.lahan-kritis.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Data</a>
                </x-slot:action>
            @endif
        </x-empty>
    @else
        <div class="table-wrap">
            <table class="table compact">
                <thead>
                    <tr>
                        <th rowspan="2" class="no">No</th>
                        <th rowspan="2">Kecamatan</th>
                        <th colspan="5" class="group">Dalam Kawasan Hutan</th>
                        <th colspan="5" class="group">Luar Kawasan Hutan</th>
                        <th rowspan="2" class="r">Total</th>
                        <th rowspan="2" class="r">Aksi</th>
                    </tr>
                    <tr>
                        @foreach (['dalam', 'luar'] as $lokasi)
                            @foreach ($kategori as $label)
                                <th @class(['r', 'sub' => $loop->first])>{{ $label }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lahanKritis as $data)
                        <tr>
                            <td class="no">{{ $loop->iteration }}</td>
                            <td class="nowrap">
                                <span class="strong">{{ $data->kecamatan }}</span>
                                <small class="muted" style="display:block;font-size:12px">{{ $data->kabupaten }}</small>
                            </td>
                            @foreach (['dalam', 'luar'] as $lokasi)
                                @foreach ($kategori as $kolom => $label)
                                    <td @class(['r', 'sub' => $loop->first])>{{ angka($data->{$lokasi . '_' . $kolom}) }}</td>
                                @endforeach
                            @endforeach
                            <td class="r strong">{{ angka($data->total_ha) }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('lahan-kritis.show', $data) }}" class="btn btn-outline btn-icon" title="Lihat detail" aria-label="Lihat detail"><i class="bi bi-eye"></i></a>
                                    @if ($bisaUbah)
                                        <a href="{{ route('admin.lahan-kritis.edit', $data) }}" class="btn btn-outline btn-icon" title="Ubah" aria-label="Ubah"><i class="bi bi-pencil"></i></a>
                                        @if (auth()->user()->isAdmin())
                                            <form action="{{ route('admin.lahan-kritis.destroy', $data) }}" method="POST"
                                                  data-confirm="Hapus data lahan kritis Kecamatan {{ $data->kecamatan }}? Tindakan ini tidak dapat dibatalkan.">
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
                        <td colspan="2">Jumlah</td>
                        @foreach (['dalam', 'luar'] as $lokasi)
                            @foreach ($kategori as $kolom => $label)
                                <td @class(['r', 'sub' => $loop->first])>{{ angka($lahanKritis->sum($lokasi . '_' . $kolom)) }}</td>
                            @endforeach
                        @endforeach
                        <td class="r">{{ angka($lahanKritis->sum('total_ha')) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</section>
