<?php

namespace App\Http\Controllers;

use App\Models\LahanKritis;
use App\Imports\LahanKritisImport;
use App\Exports\LahanKritisExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LahanKritisController extends Controller
{
    /**
     * =========================================================
     * VIEWER - MENAMPILKAN DATA LAHAN KRITIS
     * URL: /lahan-kritis
     * =========================================================
     */
    public function index(Request $request)
    {
        return view('lahan-kritis.index', $this->getData($request));
    }


    /**
     * =========================================================
     * ADMIN - MENAMPILKAN DATA LAHAN KRITIS
     * URL: /admin/lahan-kritis
     * =========================================================
     */
    public function adminIndex(Request $request)
    {
        return view('admin.lahan-kritis.index', $this->getData($request));
    }


    /**
     * =========================================================
     * DATA UNTUK HALAMAN VIEWER & ADMIN
     * =========================================================
     */
    private function getData(Request $request): array
    {
        $query = LahanKritis::query();

        // Filter kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Pencarian kabupaten / kecamatan
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kabupaten', $this->likeOperator(), '%' . $search . '%')
                    ->orWhere('kecamatan', $this->likeOperator(), '%' . $search . '%');
            });
        }

        // Data tabel
        $lahanKritis = $query
            ->orderBy('kecamatan')
            ->get();

        // Rekap per kecamatan (1 query) untuk statistik, daftar kecamatan,
        // dan grafik, agar tidak perlu banyak query ke database.
        $rekap = LahanKritis::selectRaw('
                kecamatan,
                COALESCE(SUM(dalam_sangat_kritis + luar_sangat_kritis), 0) as sangat_kritis,
                COALESCE(SUM(dalam_kritis + luar_kritis), 0) as kritis,
                COALESCE(SUM(dalam_agak_kritis + luar_agak_kritis), 0) as agak_kritis,
                COALESCE(SUM(total_ha), 0) as total_ha
            ')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $grafikKecamatan = $rekap->filter(fn ($r) => filled($r->kecamatan))->values();

        // Daftar kecamatan
        $daftarKecamatan = $grafikKecamatan->pluck('kecamatan');

        // Statistik
        $jumlahKecamatan = $grafikKecamatan->count();

        $totalLahan = (float) $rekap->sum('total_ha');

        $totalSangatKritis = (float) $rekap->sum('sangat_kritis');

        $totalKritis = (float) $rekap->sum('kritis');

        $labelGrafik = $grafikKecamatan->pluck('kecamatan')->values();

        $dataGrafik = [
            'sangat_kritis' => $grafikKecamatan->pluck('sangat_kritis')->map(fn ($v) => (float) $v)->values(),
            'kritis'        => $grafikKecamatan->pluck('kritis')->map(fn ($v) => (float) $v)->values(),
            'agak_kritis'   => $grafikKecamatan->pluck('agak_kritis')->map(fn ($v) => (float) $v)->values(),
        ];

        return compact(
            'lahanKritis',
            'daftarKecamatan',
            'jumlahKecamatan',
            'totalLahan',
            'totalSangatKritis',
            'totalKritis',
            'labelGrafik',
            'dataGrafik'
        );
    }

    /**
     * =========================================================
     * FORM TAMBAH ADMIN
     * URL: /admin/lahan-kritis/tambah
     * =========================================================
     */
    public function create()
    {
        return view('admin.lahan-kritis.create');
    }


    /**
     * =========================================================
     * DETAIL VIEWER
     * =========================================================
     */
    public function show(LahanKritis $lahanKriti)
    {
        return view('lahan-kritis.show', [
            'lahanKritis' => $lahanKriti
        ]);
    }


    /**
     * =========================================================
     * SIMPAN DATA BARU
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',

            'dalam_sangat_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_agak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_potensial_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_tidak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',

            'luar_sangat_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_agak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_potensial_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_tidak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
        ]);

        $data = $this->prepareData($request);

        LahanKritis::create($data);

        return redirect()
            ->route('admin.lahan-kritis.index')
            ->with(
                'success',
                'Data lahan kritis berhasil ditambahkan.'
            );
    }


    /**
     * =========================================================
     * FORM EDIT ADMIN
     * URL: /admin/lahan-kritis/{id}/edit
     * =========================================================
     */
    public function edit(LahanKritis $lahanKriti)
    {
        return view('admin.lahan-kritis.edit', [
            'lahanKritis' => $lahanKriti
        ]);
    }


    /**
     * =========================================================
     * UPDATE DATA
     * =========================================================
     */
    public function update(
        Request $request,
        LahanKritis $lahanKriti
    ) {
        $request->validate([
            'kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',

            'dalam_sangat_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_agak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_potensial_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'dalam_tidak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',

            'luar_sangat_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_agak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_potensial_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
            'luar_tidak_kritis' => 'nullable|numeric|min:0|max:999999999999.99',
        ]);

        $data = $this->prepareData($request);

        $lahanKriti->update($data);

        return redirect()
            ->route('admin.lahan-kritis.index')
            ->with(
                'success',
                'Data lahan kritis berhasil diperbarui.'
            );
    }


    /**
     * =========================================================
     * IMPORT EXCEL
     * =========================================================
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(
                new LahanKritisImport(),
                $request->file('file')
            );
        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'error',
                'Import gagal. Pastikan file Excel memakai format kolom yang sesuai (kabupaten, kecamatan, dalam_sangat_kritis, dst).'
            );
        }

        return redirect()
            ->route('admin.lahan-kritis.index')
            ->with(
                'success',
                'Data lahan kritis berhasil diimport dari Excel.'
            );
    }


    /**
     * =========================================================
     * EXPORT EXCEL
     * =========================================================
     */
    public function export()
    {
        return Excel::download(
            new LahanKritisExport(),
            'data-lahan-kritis.xlsx'
        );
    }


    /**
     * =========================================================
     * HAPUS DATA
     * =========================================================
     */
    public function destroy(LahanKritis $lahanKriti)
    {
        $lahanKriti->delete();

        return redirect()
            ->route('admin.lahan-kritis.index')
            ->with(
                'success',
                'Data lahan kritis berhasil dihapus.'
            );
    }


    /**
     * =========================================================
     * SIAPKAN DATA DARI REQUEST
     * Nilai kosong / tidak dikirim menjadi 0, lalu hitung total luas.
     * =========================================================
     */
    private function prepareData(Request $request): array
    {
        $kolomLuas = [
            'dalam_sangat_kritis',
            'dalam_kritis',
            'dalam_agak_kritis',
            'dalam_potensial_kritis',
            'dalam_tidak_kritis',

            'luar_sangat_kritis',
            'luar_kritis',
            'luar_agak_kritis',
            'luar_potensial_kritis',
            'luar_tidak_kritis',
        ];

        $data = $request->only(['kabupaten', 'kecamatan']);

        foreach ($kolomLuas as $kolom) {
            $data[$kolom] = (float) ($request->input($kolom) ?? 0);
        }

        // Hitung total luas
        $data['total_ha'] = array_sum(array_intersect_key($data, array_flip($kolomLuas)));

        return $data;
    }
}