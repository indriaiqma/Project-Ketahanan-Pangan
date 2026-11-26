<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'wajib_ganti_password',
        'status_akun',
        'no_hp',
        'jabatan',
        'pengajuan_penugasan',
        'catatan_pendaftaran',
        'alasan_ditolak',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'wajib_ganti_password' => 'boolean',
        'pengajuan_penugasan' => 'array',
        'diverifikasi_pada' => 'datetime',
    ];

    /** Status akun: aktif (bisa login), menunggu (persetujuan Admin), ditolak. */
    public const STATUS_AKUN = [
        'aktif' => 'Aktif',
        'menunggu' => 'Menunggu persetujuan',
        'ditolak' => 'Ditolak',
    ];

    public function isAktif(): bool
    {
        return ($this->status_akun ?? 'aktif') === 'aktif';
    }

    public function scopeMenungguPersetujuan($query)
    {
        return $query->where('status_akun', 'menunggu');
    }

    /** Email tautan reset password berbahasa Indonesia. */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Daftar role beserta labelnya.
     * - admin   : akses penuh, termasuk hapus data dan kelola pengguna
     * - petugas : tambah, ubah, import & export data (tanpa hapus & kelola pengguna)
     *
     * Tidak ada role "viewer": masyarakat melihat data langsung di situs publik
     * (landing page & Data Bidang) tanpa login. Akun lama dengan role lain
     * tidak dapat login sampai Administrator mengubah role-nya.
     */
    public const ROLES = [
        'admin'   => 'Administrator',
        'petugas' => 'Petugas',
    ];

    /** Administrator aktif (pendaftar Administrator yang belum disetujui tidak termasuk). */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' && $this->isAktif();
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Role yang memakai panel pengelola (/admin): Admin & Petugas.
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'petugas'], true);
    }

    /** Halaman tujuan setelah login sesuai role. */
    public function beranda(): string
    {
        return $this->isStaff() ? route('admin.dashboard') : route('dashboard');
    }

    /**
     * Boleh menambah, mengubah, dan mengimpor data KEHUTANAN
     * (Kawasan Hutan & Lahan Kritis, Sub Bidang Sarpras II).
     * Dipakai dashboard dan halaman kehutanan. Untuk modul lain gunakan canEditModul().
     */
    public function canEditData(): bool
    {
        return $this->canEditModul('sarana-prasarana', 'sarpras-2');
    }

    public function roleLabel(): string
    {
        return self::ROLES[$this->role] ?? ucfirst((string) $this->role);
    }

    /** Penugasan bidang / sub bidang (khusus petugas). */
    public function aksesBidang(): HasMany
    {
        return $this->hasMany(UserBidangAccess::class)->orderBy('id');
    }

    /**
     * Boleh input/edit data modul di bidang & sub bidang tertentu?
     * - admin   : selalu boleh
     * - petugas : hanya pada sub bidang (atau seluruh bidang) yang ditugaskan
     */
    public function canEditModul(string $bidang, ?string $subBidang = null): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if (! $this->isPetugas()) {
            return false;
        }

        // Hanya bidang/sub bidang yang ditugaskan langsung (termasuk menu khusus)
        return $this->aksesBidang->contains(
            fn ($akses) => $akses->bidang === $bidang
                && ($akses->sub_bidang === null || $akses->sub_bidang === $subBidang)
        );
    }
}
