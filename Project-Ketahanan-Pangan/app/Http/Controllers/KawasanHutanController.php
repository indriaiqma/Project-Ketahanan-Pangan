<?php

namespace App\Http\Controllers;

use App\Models\KawasanHutan;
use App\Imports\KawasanHutanImport;
use App\Exports\KawasanHutanExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KawasanHutanController extends Controller
{
    // ==========================================
    // HALAMAN VIEWER / PUBLIK
    // ==========================================
    public function index(Request $request)
    {
        $data = $this->getData($request);

        return view('kawasan-hutan.index', $data);
    }


    // ==========================================
    // HALAMAN ADMIN
    // ==========================================
    public function adminIndex(Request $request)
    {
        $data = $this->getData($request);

        return view('admin.kawasan-hutan.index', $data);
    }


    // ==========================================
    // MENGAMBIL DATA KAWASAN HUTAN
    // ==========================================
    private function getData(Request $request)
    {
        $query = KawasanHutan::query();

        // Filter berdasarkan kecamatan
        if ($request->filled('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        // Pencarian data
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_kawasan', 'like', "%{$search}%")
                    ->orWhere('desa', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('jenis_kawasan', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        // Data tabel
        $kawasanHutans = $query
            ->latest()
            ->get();


        // ==========================================
        // DAFTAR KECAMATAN
        // ==========================================

        $daftarKecamatan = KawasanHutan::select('kecamatan')
            ->whereNotNull('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');


        // ==========================================
        // STATISTIK
        // ==========================================

        $totalKawasan = KawasanHutan::count();

        $totalLuas = KawasanHutan::sum('luas_ha');

        $jumlahKecamatan = KawasanHutan::whereNotNull('kecamatan')
            ->distinct()
            ->count('kecamatan');

        $jumlahJenisKawasan = KawasanHutan::whereNotNull('jenis_kawasan')
            ->distinct()
            ->count('jenis_kawasan');


        // ==========================================
        // DATA GRAFIK
        // ==========================================

        $grafikKecamatan = KawasanHutan::selectRaw(
            'kecamatan, SUM(luas_ha) as total_luas'
        )
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $labelGrafik = $grafikKecamatan
            ->pluck('kecamatan')
            ->values();

        $dataGrafik = $grafikKecamatan
            ->pluck('total_luas')
            ->map(function ($luas) {
                return (float) $luas;
            })
            ->values();


        return compact(
            'kawasanHutans',
            'daftarKecamatan',
            'totalKawasan',
            'totalLuas',
            'jumlahKecamatan',
            'jumlahJenisKawasan',
            'labelGrafik',
            'dataGrafik'
        );
    }


    // ==========================================
    // DETAIL DATA VIEWER
    // ==========================================
    public function show(KawasanHutan $kawasanHutan)
    {
        return view(
            'kawasan-hutan.show',
            compact('kawasanHutan')
        );
    }


    // ==========================================
    // FORM TAMBAH DATA ADMIN
    // ==========================================
    public function create()
    {
        return view('kawasan-hutan.create');
    }


    // ==========================================
    // MENYIMPAN DATA BARU
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'kabupaten'     => 'required|string|max:255',
            'kecamatan'     => 'required|string|max:255',
            'desa'          => 'nullable|string|max:255',
            'nama_kawasan'  => 'required|string|max:255',
            'jenis_kawasan' => 'required|string|max:255',
            'luas_ha'       => 'nullable|numeric',
            'keterangan'    => 'nullable|string',
        ]);

        KawasanHutan::create([
            'kabupaten'     => $request->kabupaten,
            'kecamatan'     => $request->kecamatan,
            'desa'          => $request->desa,
            'nama_kawasan'  => $request->nama_kawasan,
            'jenis_kawasan' => $request->jenis_kawasan,
            'luas_ha'       => $request->luas_ha,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect('/admin/kawasan-hutan')
            ->with(
                'success',
                'Data kehutanan berhasil ditambahkan.'
            );
    }


    // ==========================================
    // FORM EDIT
    // ==========================================
    public function edit(KawasanHutan $kawasanHutan)
    {
        return view(
            'kawasan-hutan.edit',
            compact('kawasanHutan')
        );
    }


    // ==========================================
    // UPDATE DATA
    // ==========================================
    public function update(
        Request $request,
        KawasanHutan $kawasanHutan
    ) {
        $request->validate([
            'kabupaten'     => 'required|string|max:255',
            'kecamatan'     => 'required|string|max:255',
            'desa'          => 'nullable|string|max:255',
            'nama_kawasan'  => 'required|string|max:255',
            'jenis_kawasan' => 'required|string|max:255',
            'luas_ha'       => 'nullable|numeric',
            'keterangan'    => 'nullable|string',
        ]);

        $kawasanHutan->update([
            'kabupaten'     => $request->kabupaten,
            'kecamatan'     => $request->kecamatan,
            'desa'          => $request->desa,
            'nama_kawasan'  => $request->nama_kawasan,
            'jenis_kawasan' => $request->jenis_kawasan,
            'luas_ha'       => $request->luas_ha,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect('/admin/kawasan-hutan')
            ->with(
                'success',
                'Data kehutanan berhasil diperbarui.'
            );
    }


    // ==========================================
    // IMPORT EXCEL
    // ==========================================
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(
            new KawasanHutanImport(),
            $request->file('file')
        );

        return redirect('/admin/kawasan-hutan')
            ->with(
                'success',
                'Data kehutanan berhasil diimport dari Excel.'
            );
    }


    // ==========================================
    // EXPORT EXCEL
    // ==========================================
    public function export()
    {
        return Excel::download(
            new KawasanHutanExport(),
            'data-kawasan-hutan.xlsx'
        );
    }


    // ==========================================
    // HAPUS DATA
    // ==========================================
    public function destroy(KawasanHutan $kawasanHutan)
    {
        $kawasanHutan->delete();

        return redirect('/admin/kawasan-hutan')
            ->with(
                'success',
                'Data kehutanan berhasil dihapus.'
            );
    }
}