<?php

namespace App\Http\Controllers;

use App\Exports\ModulDataExport;
use App\Models\Lampiran;
use App\Models\Wilayah;
use App\Support\Bidang;
use App\Support\ModulData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Controller generik untuk semua modul data (config/modul_data.php).
 *   - jenis "rekap"  : 1 baris = 1 wilayah x 1 periode
 *   - jenis "daftar" : 1 baris = 1 entri bebas
 *
 * Akses sudah diperiksa di route:
 *   - lihat & export  : bidang:lihat
 *   - tambah & ubah   : role:admin,petugas + bidang:ubah (penugasan sub bidang)
 *   - hapus           : role:admin
 */
class ModulDataController extends Controller
{
    /**
     * Halaman list modul.
     * URL: /admin/bidang/{bidang}/{modul}  (dipanggil dari BidangController)
     */
    public function index(Request $request, string $bidang, string $modul)
    {
        [$b, $m, $def] = $this->resolve($bidang, $modul);
        $bisaUbah = Bidang::bolehUbah($request->user(), $b['slug'], $m['sub']);

        return ModulData::isDaftar($def)
            ? $this->indexDaftar($request, $b, $m, $def, $bisaUbah)
            : $this->indexRekap($request, $b, $m, $def, $bisaUbah);
    }

    /** Rekap: filter periode, kartu metrik, grafik per wilayah, tabel status. */
    private function indexRekap(Request $request, array $b, array $m, array $def, bool $bisaUbah)
    {
        $kolom = ModulData::kolomPeriode($def);

        // Periode bawaan: periode terakhir yang sudah ada datanya, atau periode berjalan
        [$tahunIni, $periodeIni] = ModulData::periodeSekarang($def);
        $terakhir = ModulData::query($def)->orderByDesc('tahun')->orderByDesc($kolom)->first(['tahun', $kolom]);
        $tahun = (int) $request->input('tahun', $terakhir->tahun ?? $tahunIni);
        $periode = (int) $request->input('periode', $terakhir ? $terakhir->{$kolom} : $periodeIni);
        abort_unless(array_key_exists($periode, ModulData::opsiPeriode($def)) && $tahun >= 2000 && $tahun <= $tahunIni + 1, 404);

        $wilayah = Wilayah::urut()->get();
        $data = ModulData::query($def)
            ->with(['lampiran:id,nama_file,ukuran', 'pembuat:id,name'])
            ->where('tahun', $tahun)->where($kolom, $periode)
            ->get()->keyBy('wilayah_id');

        $semuaBaris = $wilayah->map(fn ($w) => [
            'wilayah' => $w,
            'data' => $data->get($w->id),
            'status' => ModulData::status($def, $data->get($w->id)),
        ]);
        $hitungStatus = $semuaBaris->countBy('status');
        $baris = $request->filled('status')
            ? $semuaBaris->where('status', $request->input('status'))->values()
            : $semuaBaris;

        // Jumlah seluruh wilayah pada periode ini -> kartu metrik
        $jumlah = [];
        foreach (array_merge(array_keys($def['fields']), array_keys($def['total'])) as $k) {
            $jumlah[$k] = $data->sum(fn ($r) => (float) $r->{$k});
        }
        $metrik = collect($def['metrik'])->map(fn ($k) => [
            'kunci' => $k,
            'info' => ModulData::info($def, $k),
            'nilai' => $data->isEmpty() ? null : ModulData::nilai($def, $jumlah, $k),
        ])->all();

        $daftarTahun = ModulData::query($def)->distinct()->pluck('tahun')
            ->push($tahunIni, $tahun)->map(fn ($t) => (int) $t)->unique()->sortDesc()->values();

        return view('admin.modul.index', [
            'bidang' => $b,
            'modul' => $m,
            'def' => $def,
            'kolom' => $kolom,
            'tahun' => $tahun,
            'periode' => $periode,
            'labelPeriode' => ModulData::labelPeriode($def, $tahun, $periode),
            'daftarTahun' => $daftarTahun,
            'baris' => $baris,
            'hitungStatus' => $hitungStatus,
            'jumlahWilayah' => $wilayah->count(),
            'metrik' => $metrik,
            'grafik' => [
                'labels' => $wilayah->pluck('nama')->all(),
                'datasets' => collect($def['grafik'])->map(fn ($f) => [
                    'label' => ModulData::info($def, $f)['label'],
                    'data' => $wilayah->map(fn ($w) => (float) ($data->get($w->id)?->{$f} ?? 0))->all(),
                ])->all(),
                'ada' => $data->isNotEmpty() && ! empty($def['grafik']),
            ],
            'bisaUbah' => $bisaUbah,
        ]);
    }

    /** Daftar: pencarian, filter pilihan, kartu metrik, grafik per kategori, tabel entri. */
    private function indexDaftar(Request $request, array $b, array $m, array $def, bool $bisaUbah)
    {
        $semua = ModulData::query($def)->with(['lampiran:id,nama_file,ukuran', 'pembuat:id,name'])->latest()->get();
        $wilayah = Wilayah::urut()->get()->keyBy('id');

        $entri = $semua;
        if ($q = mb_strtolower(trim((string) $request->input('cari')))) {
            $entri = $entri->filter(fn ($e) => collect($def['cari'])->contains(fn ($f) => str_contains(mb_strtolower((string) $e->{$f}), $q)));
        }
        if ($def['filter'] && $request->filled('filter')) {
            $entri = $entri->where($def['filter'], $request->input('filter'));
        }
        $entri = $entri->values();

        // Grafik: jumlah entri per kategori (field pilihan) atau per kecamatan (field wilayah)
        $grafik = ['ada' => false];
        if ($fg = $def['grafik'][0] ?? null) {
            $f = $def['fields'][$fg];
            $label = ($f['tipe'] ?? null) === 'wilayah' ? $wilayah->pluck('nama', 'id')->all() : array_combine($f['opsi'], $f['opsi']);
            $grafik = [
                'judul' => 'Jumlah per '.mb_strtolower($f['label']),
                'labels' => array_values($label),
                'datasets' => [['label' => 'Jumlah', 'data' => array_map(fn ($k) => $semua->filter(fn ($e) => (string) $e->{$fg} === (string) $k)->count(), array_keys($label))]],
                'ada' => $semua->isNotEmpty(),
            ];
        }

        return view('admin.modul.daftar', [
            'bidang' => $b,
            'modul' => $m,
            'def' => $def,
            'entri' => $entri,
            'jumlahSemua' => $semua->count(),
            'wilayah' => $wilayah,
            'metrik' => collect($def['metrik'])->map(fn ($mt) => $mt + ['hasil' => ModulData::metrikDaftar($mt, $semua)])->all(),
            'grafik' => $grafik,
            'bisaUbah' => $bisaUbah,
        ]);
    }

    /** Form tambah. URL: /admin/bidang/{bidang}/{modul}/tambah */
    public function create(Request $request, string $bidang, string $modul)
    {
        [$b, $m, $def] = $this->resolve($bidang, $modul);
        [$tahunIni, $periodeIni] = ModulData::periodeSekarang($def);

        return $this->form($b, $m, $def, null, [
            'wilayah_id' => $request->integer('wilayah_id') ?: null,
            'tahun' => $request->integer('tahun') ?: $tahunIni,
            'periode' => $request->integer('periode') ?: $periodeIni,
        ]);
    }

    public function store(Request $request, string $bidang, string $modul)
    {
        [$b, $m, $def] = $this->resolve($bidang, $modul);

        if ($duplikat = $this->cariDuplikat($request, $def)) {
            return $this->tolakDuplikat($b, $m, $def, $duplikat);
        }

        $valid = $request->validate(ModulData::rules($def), [], ModulData::atribut($def));

        DB::transaction(function () use ($request, $def, $valid) {
            $data = $this->dataDariInput($def, $valid);
            $data['created_by'] = $request->user()->id;
            $data['lampiran_id'] = $this->simpanLampiran($request)?->id;
            $def['model']::create($data);
        });

        return $this->keDaftar($b, $m, $def, $valid, 'Data berhasil ditambahkan.');
    }

    /** Form ubah. URL: /admin/bidang/{bidang}/{modul}/{id}/edit */
    public function edit(string $bidang, string $modul, int $id)
    {
        [$b, $m, $def] = $this->resolve($bidang, $modul);
        $baris = ModulData::query($def)->with('lampiran:id,nama_file,ukuran')->findOrFail($id);

        return $this->form($b, $m, $def, $baris, [
            'wilayah_id' => $baris->wilayah_id,
            'tahun' => $baris->tahun,
            'periode' => $baris->{ModulData::kolomPeriode($def)},
        ]);
    }

    public function update(Request $request, string $bidang, string $modul, int $id)
    {
        [$b, $m, $def] = $this->resolve($bidang, $modul);
        $baris = ModulData::query($def)->findOrFail($id);

        if ($duplikat = $this->cariDuplikat($request, $def, $baris->id)) {
            return $this->tolakDuplikat($b, $m, $def, $duplikat);
        }

        $valid = $request->validate(ModulData::rules($def, $baris->id), [], ModulData::atribut($def));

        DB::transaction(function () use ($request, $def, $valid, $baris) {
            $data = $this->dataDariInput($def, $valid);
            $lampiranLama = $baris->lampiran_id;

            if ($baru = $this->simpanLampiran($request)) {
                $data['lampiran_id'] = $baru->id;
            } elseif ($request->boolean('hapus_lampiran')) {
                $data['lampiran_id'] = null;
            }

            $baris->update($data);

            // Hapus lampiran lama yang sudah diganti / dihapus
            if ($lampiranLama && array_key_exists('lampiran_id', $data) && $data['lampiran_id'] !== $lampiranLama) {
                Lampiran::whereKey($lampiranLama)->delete();
            }
        });

        return $this->keDaftar($b, $m, $def, $valid, 'Data berhasil diperbarui.');
    }

    /** Hapus data (khusus admin). */
    public function destroy(string $bidang, string $modul, int $id)
    {
        [$b, $m, $def] = $this->resolve($bidang, $modul);
        $baris = ModulData::query($def)->findOrFail($id);

        DB::transaction(function () use ($baris) {
            $lampiran = $baris->lampiran_id;
            $baris->delete();
            if ($lampiran) {
                Lampiran::whereKey($lampiran)->delete();
            }
        });

        $kembali = ['bidang' => $b['slug'], 'modul' => $m['slug']];
        if (! ModulData::isDaftar($def)) {
            $kembali += ['tahun' => $baris->tahun, 'periode' => $baris->{ModulData::kolomPeriode($def)}];
        }

        return redirect()->route('admin.bidang.modul', $kembali)->with('success', 'Data berhasil dihapus.');
    }

    /** Export Excel. Rekap: periode terpilih (atau semua dengan ?periode=semua). Daftar: semua entri. */
    public function export(Request $request, string $bidang, string $modul)
    {
        [, $m, $def] = $this->resolve($bidang, $modul);

        $semua = ModulData::isDaftar($def) || $request->input('periode') === 'semua';
        $tahun = $semua ? null : ($request->integer('tahun') ?: null);
        $periode = $semua ? null : ($request->integer('periode') ?: null);

        $nama = $m['slug'].($tahun && $periode ? "-$tahun-$periode" : '-semua').'.xlsx';

        return Excel::download(new ModulDataExport($def, $tahun, $periode), $nama);
    }

    /** Unduh lampiran milik salah satu baris modul ini. */
    public function lampiran(string $bidang, string $modul, int $lampiran)
    {
        [, , $def] = $this->resolve($bidang, $modul);
        abort_unless(ModulData::query($def)->where('lampiran_id', $lampiran)->exists(), 404);

        $file = Lampiran::findOrFail($lampiran);
        $isi = base64_decode($file->isi);

        return response($isi, 200, [
            'Content-Type' => $file->mime,
            'Content-Length' => strlen($isi),
            'Content-Disposition' => 'attachment; filename="'.str_replace('"', '', $file->nama_file).'"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /* ------------------------------------------------------------------ */

    /** @return array{0: array, 1: array, 2: array} [bidang, modul, definisi] */
    private function resolve(string $bidang, string $modul): array
    {
        $b = Bidang::cari($bidang);
        $m = Bidang::cariModul($bidang, $modul);
        abort_unless($b && $m && $m['aktif'] && ! empty($m['data']), 404);

        return [$b, $m, ModulData::def($m['data'])];
    }

    private function form(array $b, array $m, array $def, ?Model $baris, array $awal)
    {
        if (ModulData::isDaftar($def)) {
            return view('admin.modul.daftar-form', [
                'bidang' => $b,
                'modul' => $m,
                'def' => $def,
                'baris' => $baris,
                'wilayah' => Wilayah::urut()->get(['id', 'nama']),
            ]);
        }

        $kolom = ModulData::kolomPeriode($def);

        // Kombinasi wilayah+periode yang sudah ada -> peringatan duplikat di browser
        $sudahAda = ModulData::query($def)->get(['id', 'wilayah_id', 'tahun', $kolom])
            ->reject(fn ($r) => $baris && $r->id === $baris->id)
            ->mapWithKeys(fn ($r) => [
                "{$r->wilayah_id}-{$r->tahun}-{$r->{$kolom}}" => route('admin.modul.edit', ['bidang' => $b['slug'], 'modul' => $m['slug'], 'id' => $r->id]),
            ]);

        return view('admin.modul.form', [
            'bidang' => $b,
            'modul' => $m,
            'def' => $def,
            'kolom' => $kolom,
            'baris' => $baris,
            'awal' => $awal,
            'wilayah' => Wilayah::urut()->get(['id', 'nama']),
            'sudahAda' => $sudahAda,
            'tahunIni' => ModulData::periodeSekarang($def)[0],
        ]);
    }

    /**
     * Ambil hanya field yang didefinisikan (rekap: + hitung total otomatis),
     * lalu sesuaikan bentuknya dengan cara penyimpanan modul.
     */
    private function dataDariInput(array $def, array $valid): array
    {
        $nilai = [];
        foreach ($def['fields'] as $f => $info) {
            $v = $valid[$f] ?? null;
            $nilai[$f] = match ($info['tipe'] ?? (ModulData::isDaftar($def) ? 'teks' : 'bulat')) {
                'bulat', 'angka', 'tahun', 'wilayah' => $v === null ? null : (int) $v,
                'desimal', 'persen' => $v === null ? null : round((float) $v, 2),
                default => $v,
            };
        }

        $umum = [
            'sumber_data' => $valid['sumber_data'] ?? null,
            'keterangan' => $valid['keterangan'] ?? null,
        ];

        if (ModulData::isDaftar($def)) {
            return $umum + ['modul' => $def['kunci'], 'nilai' => $nilai];
        }

        $kolom = ModulData::kolomPeriode($def);
        $periode = [
            'wilayah_id' => (int) $valid['wilayah_id'],
            'tahun' => (int) $valid['tahun'],
            $kolom => (int) $valid[$kolom],
        ];
        $nilai = ModulData::hitungTotal($def, $nilai);

        return $def['penyimpanan'] === 'json'
            ? $umum + $periode + ['modul' => $def['kunci'], 'nilai' => $nilai]
            : $umum + $periode + $nilai;
    }

    private function simpanLampiran(Request $request): ?Lampiran
    {
        if (! $request->hasFile('lampiran')) {
            return null;
        }

        $file = $request->file('lampiran');

        return Lampiran::create([
            'nama_file' => mb_substr($file->getClientOriginalName(), 0, 255),
            'mime' => $file->getMimeType() ?: 'application/octet-stream',
            'ukuran' => $file->getSize(),
            'isi' => base64_encode(file_get_contents($file->getRealPath())),
            'uploaded_by' => $request->user()->id,
        ]);
    }

    private function cariDuplikat(Request $request, array $def, ?int $abaikanId = null): ?Model
    {
        if (ModulData::isDaftar($def)) {
            return null;
        }

        $kolom = ModulData::kolomPeriode($def);
        if (! $request->filled(['wilayah_id', 'tahun', $kolom])) {
            return null;
        }

        return ModulData::query($def)
            ->where('wilayah_id', $request->integer('wilayah_id'))
            ->where('tahun', $request->integer('tahun'))
            ->where($kolom, $request->integer($kolom))
            ->when($abaikanId, fn ($q) => $q->whereKeyNot($abaikanId))
            ->first();
    }

    /** Data wilayah+periode sudah ada: tolak dan tawarkan untuk mengedit data lama. */
    private function tolakDuplikat(array $b, array $m, array $def, Model $duplikat)
    {
        $kolom = ModulData::kolomPeriode($def);

        return back()->withInput()
            ->withErrors([$kolom => 'Data untuk wilayah dan periode ini sudah ada.'])
            ->with('duplikat', route('admin.modul.edit', ['bidang' => $b['slug'], 'modul' => $m['slug'], 'id' => $duplikat->id]));
    }

    private function keDaftar(array $b, array $m, array $def, array $valid, string $pesan)
    {
        $tujuan = ['bidang' => $b['slug'], 'modul' => $m['slug']];
        if (! ModulData::isDaftar($def)) {
            $tujuan += ['tahun' => $valid['tahun'], 'periode' => $valid[ModulData::kolomPeriode($def)]];
        }

        return redirect()->route('admin.bidang.modul', $tujuan)->with('success', $pesan);
    }
}
