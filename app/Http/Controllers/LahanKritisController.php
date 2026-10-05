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
        $query = LahanKritis::query();

        // Filter kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Pencarian kabupaten / kecamatan
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('kabupaten', 'like', '%' . $search . '%')
                    ->orWhere('kecamatan', 'like', '%' . $search . '%');
            });
        }

        // Data tabel
        $lahanKritis = $query
            ->orderBy('kecamatan')
            ->get();

        // Daftar kecamatan
        $daftarKecamatan = LahanKritis::select('kecamatan')
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');

        // Statistik
        $jumlahKecamatan = LahanKritis::whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->distinct()
            ->count('kecamatan');

        $totalLahan = LahanKritis::sum('total_ha');

        $totalSangatKritis =
            LahanKritis::sum('dalam_sangat_kritis') +
            LahanKritis::sum('luar_sangat_kritis');

        $totalKritis =
            LahanKritis::sum('dalam_kritis') +
            LahanKritis::sum('luar_kritis');

        // Data grafik
        $grafikKecamatan = LahanKritis::selectRaw(
            'kecamatan, SUM(total_ha) as total_luas'
        )
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $labelGrafik = $grafikKecamatan
            ->pluck('kecamatan')
            ->values();

        $dataGrafik = $grafikKecamatan
            ->pluck('total_luas')
            ->map(function ($nilai) {
                return (float) $nilai;
            })
            ->values();

        return view('lahan-kritis.index', compact(
            'lahanKritis',
            'daftarKecamatan',
            'jumlahKecamatan',
            'totalLahan',
            'totalSangatKritis',
            'totalKritis',
            'labelGrafik',
            'dataGrafik'
        ));
    }


    /**
     * =========================================================
     * ADMIN - MENAMPILKAN DATA LAHAN KRITIS
     * URL: /admin/lahan-kritis
     * =========================================================
     */
    public function adminIndex(Request $request)
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
                $q->where('kabupaten', 'like', '%' . $search . '%')
                    ->orWhere('kecamatan', 'like', '%' . $search . '%');
            });
        }

        // Data tabel
        $lahanKritis = $query
            ->orderBy('kecamatan')
            ->get();

        // Daftar kecamatan
        $daftarKecamatan = LahanKritis::select('kecamatan')
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');

        // Statistik
        $jumlahKecamatan = LahanKritis::whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->distinct()
            ->count('kecamatan');

        $totalLahan = LahanKritis::sum('total_ha');

        $totalSangatKritis =
            LahanKritis::sum('dalam_sangat_kritis') +
            LahanKritis::sum('luar_sangat_kritis');

        $totalKritis =
            LahanKritis::sum('dalam_kritis') +
            LahanKritis::sum('luar_kritis');

        // Data grafik
        $grafikKecamatan = LahanKritis::selectRaw(
            'kecamatan, SUM(total_ha) as total_luas'
        )
            ->whereNotNull('kecamatan')
            ->where('kecamatan', '!=', '')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $labelGrafik = $grafikKecamatan
            ->pluck('kecamatan')
            ->values();

        $dataGrafik = $grafikKecamatan
            ->pluck('total_luas')
            ->map(function ($nilai) {
                return (float) $nilai;
            })
            ->values();

        return view('admin.lahan-kritis.index', compact(
            'lahanKritis',
            'daftarKecamatan',
            'jumlahKecamatan',
            'totalLahan',
            'totalSangatKritis',
            'totalKritis',
            'labelGrafik',
            'dataGrafik'
        ));
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

            'dalam_sangat_kritis' => 'nullable|numeric',
            'dalam_kritis' => 'nullable|numeric',
            'dalam_agak_kritis' => 'nullable|numeric',
            'dalam_potensial_kritis' => 'nullable|numeric',
            'dalam_tidak_kritis' => 'nullable|numeric',

            'luar_sangat_kritis' => 'nullable|numeric',
            'luar_kritis' => 'nullable|numeric',
            'luar_agak_kritis' => 'nullable|numeric',
            'luar_potensial_kritis' => 'nullable|numeric',
            'luar_tidak_kritis' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'kabupaten',
            'kecamatan',

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
        ]);

        // Nilai kosong menjadi 0
        foreach ($data as $key => $value) {
            if ($key !== 'kabupaten' && $key !== 'kecamatan') {
                $data[$key] = $value ?? 0;
            }
        }

        // Hitung total luas
        $data['total_ha'] =
            $data['dalam_sangat_kritis'] +
            $data['dalam_kritis'] +
            $data['dalam_agak_kritis'] +
            $data['dalam_potensial_kritis'] +
            $data['dalam_tidak_kritis'] +
            $data['luar_sangat_kritis'] +
            $data['luar_kritis'] +
            $data['luar_agak_kritis'] +
            $data['luar_potensial_kritis'] +
            $data['luar_tidak_kritis'];

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

            'dalam_sangat_kritis' => 'nullable|numeric',
            'dalam_kritis' => 'nullable|numeric',
            'dalam_agak_kritis' => 'nullable|numeric',
            'dalam_potensial_kritis' => 'nullable|numeric',
            'dalam_tidak_kritis' => 'nullable|numeric',

            'luar_sangat_kritis' => 'nullable|numeric',
            'luar_kritis' => 'nullable|numeric',
            'luar_agak_kritis' => 'nullable|numeric',
            'luar_potensial_kritis' => 'nullable|numeric',
            'luar_tidak_kritis' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'kabupaten',
            'kecamatan',

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
        ]);

        // Nilai kosong menjadi 0
        foreach ($data as $key => $value) {
            if ($key !== 'kabupaten' && $key !== 'kecamatan') {
                $data[$key] = $value ?? 0;
            }
        }

        // Hitung ulang total luas
        $data['total_ha'] =
            $data['dalam_sangat_kritis'] +
            $data['dalam_kritis'] +
            $data['dalam_agak_kritis'] +
            $data['dalam_potensial_kritis'] +
            $data['dalam_tidak_kritis'] +
            $data['luar_sangat_kritis'] +
            $data['luar_kritis'] +
            $data['luar_agak_kritis'] +
            $data['luar_potensial_kritis'] +
            $data['luar_tidak_kritis'];

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

        Excel::import(
            new LahanKritisImport(),
            $request->file('file')
        );

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
}