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
                $q->where('nama_kawasan', $this->likeOperator(), "%{$search}%")
                    ->orWhere('desa', $this->likeOperator(), "%{$search}%")
                    ->orWhere('kecamatan', $this->likeOperator(), "%{$search}%")
                    ->orWhere('jenis_kawasan', $this->likeOperator(), "%{$search}%")
                    ->orWhere('kabupaten', $this->likeOperator(), "%{$search}%")
                    ->orWhere('keterangan', $this->likeOperator(), "%{$search}%");
            });
        }

        // Data tabel
        $kawasanHutans = $query
            ->latest()
            ->get();


        // ==========================================
        // REKAP PER KECAMATAN (1 query)
        // Dipakai untuk statistik, daftar kecamatan, dan grafik
        // agar tidak perlu banyak query ke database.
        // ==========================================

        $rekap = KawasanHutan::selectRaw('
                kecamatan,
                COUNT(*) as jumlah,
                COALESCE(SUM(luas_ha), 0) as total_luas
            ')
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        $perKecamatan = $rekap->whereNotNull('kecamatan')->values();

        $daftarKecamatan = $perKecamatan->pluck('kecamatan');


        // ==========================================
        // STATISTIK
        // ==========================================

        $totalKawasan = (int) $rekap->sum('jumlah');

        $totalLuas = (float) $rekap->sum('total_luas');

        $jumlahKecamatan = $perKecamatan->count();

        // Tanpa filter, tabel sudah berisi semua data: tidak perlu query lagi
        $jumlahJenisKawasan = $request->filled('kecamatan') || $request->filled('search')
            ? KawasanHutan::whereNotNull('jenis_kawasan')->distinct()->count('jenis_kawasan')
            : $kawasanHutans->pluck('jenis_kawasan')->filter()->unique()->count();


        // ==========================================
        // DATA GRAFIK
        // ==========================================

        $labelGrafik = $daftarKecamatan->values();

        $dataGrafik = $perKecamatan
            ->pluck('total_luas')
            ->map(fn ($luas) => (float) $luas)
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
        return view('admin.kawasan-hutan.create');
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
            'luas_ha'       => 'nullable|numeric|min:0|max:9999999999.99',
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
            'admin.kawasan-hutan.edit',
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
            'luas_ha'       => 'nullable|numeric|min:0|max:9999999999.99',
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

        try {
            Excel::import(
                new KawasanHutanImport(),
                $request->file('file')
            );
        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'error',
                'Import gagal. Pastikan file Excel memakai format kolom yang sesuai (kabupaten, kecamatan, desa, nama_kawasan, jenis_kawasan, luas_ha, keterangan).'
            );
        }

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