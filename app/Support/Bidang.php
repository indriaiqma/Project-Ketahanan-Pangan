<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

/**
 * Akses terpusat ke struktur Bidang -> Sub Bidang -> Modul (config/bidang.php).
 *
 * Setiap modul yang dikembalikan sudah dilengkapi:
 *   bidang, bidang_nama, sub, sub_nama, href, aktif (bool)
 *   rincian : modul daftar rincian (mis. Daftar Sekolah untuk Pendidikan) atau null.
 *             Modul rincian punya 'induk' = slug modul rekapnya dan tidak tampil
 *             sebagai menu sendiri, melainkan sebagai tab di halaman modul induknya.
 *
 * Bidang dengan 'khusus' => true tampil sebagai menu tersendiri di luar daftar bidang.
 */
class Bidang
{
    private static ?Collection $cache = null;

    /** Peta kunci data modul induk => kunci data modul rincian (dari 'induk' di config/modul_data.php). */
    private static ?array $petaRincian = null;

    /** Semua bidang, sudah dinormalisasi. */
    public static function semua(): Collection
    {
        return self::$cache ??= collect(config('bidang.bidang', []))->map(function (array $b) {
            $b['sub_bidang'] = collect($b['sub_bidang'] ?? [])->map(function (array $s) use ($b) {
                $s['modul'] = collect($s['modul'] ?? [])->map(fn ($m) => self::lengkapiModul($m, $b, $s))->all();

                return $s;
            })->all();

            // Bidang tanpa sub bidang punya modul langsung
            $b['modul'] = collect($b['modul'] ?? [])->map(fn ($m) => self::lengkapiModul($m, $b, null))->all();

            return $b;
        });
    }

    /** Untuk pengujian / setelah config diubah saat runtime. */
    public static function reset(): void
    {
        self::$cache = null;
        self::$petaRincian = null;
    }

    /** Bidang biasa (tanpa menu khusus). */
    public static function reguler(?Collection $daftar = null): Collection
    {
        return ($daftar ?? self::semua())->reject(fn ($b) => ! empty($b['khusus']))->values();
    }

    /** Menu khusus di luar struktur bidang (mis. Pertanian & Peternakan). */
    public static function khusus(?Collection $daftar = null): Collection
    {
        return ($daftar ?? self::semua())->filter(fn ($b) => ! empty($b['khusus']))->values();
    }

    public static function cari(string $slug): ?array
    {
        return self::semua()->firstWhere('slug', $slug);
    }

    /**
     * Kelompok modul dalam satu bidang: [['sub' => array|null, 'modul' => [...]], ...]
     * Bidang tanpa sub bidang menghasilkan satu kelompok dengan sub = null.
     */
    public static function kelompok(array $bidang): array
    {
        $kelompok = collect($bidang['sub_bidang'])->map(fn ($s) => ['sub' => $s, 'modul' => $s['modul']])->all();

        if (! empty($bidang['modul'])) {
            $kelompok[] = ['sub' => null, 'modul' => $bidang['modul']];
        }

        return $kelompok;
    }

    /** Semua modul dalam satu bidang (datar). */
    public static function modulBidang(array $bidang): Collection
    {
        return collect(self::kelompok($bidang))->flatMap(fn ($k) => $k['modul']);
    }

    /** Semua modul di seluruh bidang (datar), termasuk modul rincian. */
    public static function semuaModul(): Collection
    {
        return self::semua()->flatMap(fn ($b) => self::modulBidang($b))
            ->flatMap(fn ($m) => array_filter([$m, $m['rincian'] ?? null]))
            ->values();
    }

    /** Modul (atau modul rincian) dalam satu bidang. */
    public static function cariModul(string $bidang, string $modul): ?array
    {
        $b = self::cari($bidang);
        if (! $b) {
            return null;
        }

        foreach (self::modulBidang($b) as $m) {
            if ($m['slug'] === $modul) {
                return $m;
            }
            if (($m['rincian']['slug'] ?? null) === $modul) {
                return $m['rincian'];
            }
        }

        return null;
    }

    /** Cari modul berdasarkan kunci definisi data generiknya. */
    public static function cariModulData(string $kunci): ?array
    {
        return self::semuaModul()->first(fn ($m) => ($m['data'] ?? null) === $kunci);
    }

    /**
     * Bidang & modul yang sedang dibuka, berdasarkan route saat ini.
     * Mengembalikan ['bidang' => slug|null, 'modul' => slug|null].
     */
    public static function posisiSaatIni(): array
    {
        $route = Route::current();
        if (! $route) {
            return ['bidang' => null, 'modul' => null];
        }

        // Modul lama yang memakai route sendiri (Kawasan Hutan, Lahan Kritis)
        foreach (self::semuaModul() as $m) {
            if (! empty($m['pola']) && request()->routeIs($m['pola'])) {
                return ['bidang' => $m['bidang'], 'modul' => $m['slug']];
            }
        }

        $bidang = $route->parameter('bidang');
        $bidang = is_string($bidang) && self::cari($bidang) ? $bidang : null;
        $modul = $route->parameter('modul');
        $modul = is_string($modul) ? $modul : null;

        // Halaman rincian menyorot modul induknya di menu
        if ($bidang && $modul && ($m = self::cariModul($bidang, $modul)) && ! empty($m['induk'])) {
            $modul = $m['induk'];
        }

        return ['bidang' => $bidang, 'modul' => $modul];
    }

    /**
     * Bidang yang boleh tampil untuk pengguna, SUDAH disaring sampai tingkat sub bidang.
     * Dengan opsi 'hidden', petugas hanya mendapat bidang & sub bidang yang ditugaskan;
     * sub bidang lain (beserta modulnya) dibuang dari struktur.
     */
    public static function untuk(?User $user): Collection
    {
        return self::semua()->map(fn ($b) => self::saring($user, $b))->filter()->values();
    }

    /** Satu bidang yang sudah disaring untuk pengguna; null bila tidak boleh dilihat. */
    public static function cariUntuk(?User $user, string $slug): ?array
    {
        return self::untuk($user)->firstWhere('slug', $slug);
    }

    /** Semua modul (datar) yang boleh dilihat pengguna. */
    public static function modulUntuk(?User $user): Collection
    {
        return self::untuk($user)->flatMap(fn ($b) => self::modulBidang($b))->values();
    }

    /** Apakah penugasan petugas membatasi apa yang terlihat (opsi 'hidden'). */
    public static function dibatasi(?User $user): bool
    {
        return $user !== null && $user->isPetugas() && config('bidang.akses_luar_penugasan') === 'hidden';
    }

    public static function bolehLihat(?User $user, string $bidang): bool
    {
        if (! $user) {
            return false;
        }

        if (! self::dibatasi($user)) {
            return true;
        }

        return $user->aksesBidang->contains('bidang', $bidang);
    }

    /**
     * Boleh melihat sub bidang tertentu? (sub = null: modul langsung di bawah bidang)
     * Petugas yang dibatasi hanya melihat sub bidang yang ditugaskan, atau seluruh
     * bidang bila ditugaskan per bidang.
     */
    public static function bolehLihatSub(?User $user, string $bidang, ?string $sub): bool
    {
        if (! $user) {
            return false;
        }

        return ! self::dibatasi($user) || $user->canEditModul($bidang, $sub);
    }

    private static function saring(?User $user, array $b): ?array
    {
        if (! self::bolehLihat($user, $b['slug'])) {
            return null;
        }

        $b['sub_bidang'] = array_values(array_filter($b['sub_bidang'], fn ($s) => self::bolehLihatSub($user, $b['slug'], $s['slug'])));
        $b['modul'] = self::bolehLihatSub($user, $b['slug'], null) ? $b['modul'] : [];

        return empty($b['sub_bidang']) && empty($b['modul']) ? null : $b;
    }

    public static function bolehUbah(?User $user, string $bidang, ?string $sub = null): bool
    {
        return $user?->canEditModul($bidang, $sub) ?? false;
    }

    /**
     * Pilihan penugasan untuk form pengguna:
     * [['bidang' => ..., 'nama' => ..., 'opsi' => [['nilai' => 'bidang|sub', 'label' => ...], ...]], ...]
     * Bidang tanpa sub bidang ditugaskan sebagai satu kesatuan (nilai 'bidang|').
     */
    public static function opsiPenugasan(): array
    {
        return self::semua()->map(fn ($b) => [
            'bidang' => $b['slug'],
            'nama' => $b['nama'],
            'icon' => $b['icon'],
            'opsi' => empty($b['sub_bidang'])
                ? [['nilai' => $b['slug'].'|', 'label' => 'Seluruh '.$b['nama']]]
                : collect($b['sub_bidang'])->map(fn ($s) => ['nilai' => $b['slug'].'|'.$s['slug'], 'label' => $s['nama']])->all(),
        ])->all();
    }

    /** Label singkat penugasan, mis. "Sub Bidang Sarpras II". */
    public static function labelPenugasan(string $bidang, ?string $sub): string
    {
        $b = self::cari($bidang);
        if (! $b) {
            return $bidang;
        }
        if (! $sub) {
            return $b['nama'];
        }

        return collect($b['sub_bidang'])->firstWhere('slug', $sub)['nama'] ?? $sub;
    }

    private static function lengkapiModul(array $m, array $b, ?array $s): array
    {
        $m['bidang'] = $b['slug'];
        $m['bidang_nama'] = $b['nama'];
        $m['sub'] = $s['slug'] ?? null;
        $m['sub_nama'] = $s['nama'] ?? null;
        $m['aktif'] = ($m['status'] ?? 'segera') === 'aktif';
        $m['href'] = ! empty($m['route'])
            ? route($m['route'])
            : route('admin.bidang.modul', ['bidang' => $b['slug'], 'modul' => $m['slug']]);

        // Modul rincian (daftar per entitas) untuk modul rekap ini
        $m['rincian'] = null;
        if (empty($m['induk']) && ! empty($m['data']) && ($kunci = self::petaRincian()[$m['data']] ?? null)) {
            $def = config("modul_data.$kunci");
            $m['rincian'] = self::lengkapiModul([
                'slug' => $kunci,
                'nama' => $def['nama'] ?? 'Rincian '.$m['nama'],
                'status' => $m['status'] ?? 'segera',
                'icon' => $def['icon'] ?? 'list-ul',
                'data' => $kunci,
                'induk' => $m['slug'],
                'induk_nama' => $m['nama'],
            ], $b, $s);
        }

        return $m;
    }

    private static function petaRincian(): array
    {
        return self::$petaRincian ??= collect(config('modul_data', []))
            ->filter(fn ($d) => is_array($d) && ! empty($d['induk']))
            ->mapWithKeys(fn ($d, $kunci) => [$d['induk'] => $kunci])
            ->all();
    }
}
