<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    ];

    /**
     * Daftar role beserta labelnya.
     * - admin   : akses penuh, termasuk hapus data dan kelola pengguna
     * - petugas : tambah, ubah, import & export data (tanpa hapus & kelola pengguna)
     * - viewer  : hanya melihat data di panel dan export Excel (tanpa mengubah apa pun)
     */
    public const ROLES = [
        'admin'   => 'Administrator',
        'petugas' => 'Petugas',
        'viewer'  => 'Viewer',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isViewer(): bool
    {
        return $this->role === 'viewer';
    }

    /** Semua role terdaftar boleh masuk ke panel pengelolaan. */
    public function isStaff(): bool
    {
        return array_key_exists($this->role, self::ROLES);
    }

    /** Boleh menambah, mengubah, dan mengimpor data (admin & petugas). */
    public function canEditData(): bool
    {
        return $this->isAdmin() || $this->isPetugas();
    }

    public function roleLabel(): string
    {
        return self::ROLES[$this->role] ?? ucfirst((string) $this->role);
    }
}
