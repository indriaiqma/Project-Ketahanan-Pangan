<p align="center">
  <img src="public/images/logo-jatim.png" alt="Lambang Provinsi Jawa Timur" height="90">
</p>

<h1 align="center">Sistem Informasi Ketahanan Pangan (SIKP) Malang Selatan</h1>

<p align="center">
  Aplikasi web Bakorwil III Malang, Pemerintah Provinsi Jawa Timur,<br>
  untuk mengelola dan menyajikan data kawasan hutan dan lahan kritis di wilayah Malang Selatan.
</p>

<p align="center">
  <img alt="Laravel 10" src="https://img.shields.io/badge/Laravel-10-FF2D20?logo=laravel&logoColor=white">
  <img alt="PHP 8.1+" src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?logo=php&logoColor=white">
  <img alt="PostgreSQL / MySQL" src="https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL-336791?logo=postgresql&logoColor=white">
  <img alt="Vite" src="https://img.shields.io/badge/Vite-4-646CFF?logo=vite&logoColor=white">
</p>

---

## Daftar Isi

1. [Tentang Aplikasi](#1-tentang-aplikasi)
2. [Fitur](#2-fitur)
3. [Role & Hak Akses](#3-role--hak-akses)
4. [Alur Aplikasi](#4-alur-aplikasi)
5. [Teknologi](#5-teknologi)
6. [Instalasi & Menjalankan](#6-instalasi--menjalankan)
7. [Akun Bawaan](#7-akun-bawaan)
8. [Format Import Excel](#8-format-import-excel)
9. [Struktur Folder](#9-struktur-folder)
10. [Catatan Penting untuk Developer](#10-catatan-penting-untuk-developer)
11. [Perubahan di Branch `Rayhan`](#11-perubahan-di-branch-rayhan)
12. [Cara Berkontribusi](#12-cara-berkontribusi)
13. [Mengatasi Masalah Umum](#13-mengatasi-masalah-umum)

---

## 1. Tentang Aplikasi

SIKP Malang Selatan memantau kondisi lahan yang berkaitan dengan ketahanan pangan di **9 kecamatan Malang Selatan**:

> Ampelgading · Bantur · Dampit · Donomulyo · Gedangan · Kalipare · Pagak · Sumbermanjing Wetan · Tirtoyudo

Aplikasi ini punya dua sisi:

| Sisi | Untuk siapa | Perlu login? |
|---|---|---|
| **Situs publik** | Masyarakat dan instansi lain | Tidak. Hanya melihat dashboard, grafik, tabel, dan detail data. |
| **Panel pengelola** (`/admin`) | Pegawai Bakorwil III Malang | Ya. Isi panel menyesuaikan role akun (lihat [bagian 3](#3-role--hak-akses)). |

Mengapa lahan kritis penting untuk ketahanan pangan? Lahan yang rusak atau gundul tidak produktif dan rawan bencana. Dari data ini pemerintah bisa menentukan wilayah mana yang paling membutuhkan rehabilitasi lahan atau penghijauan.

## 2. Fitur

### Modul data

| Modul | Status | Isi |
|---|---|---|
| **Kawasan Hutan** | ✅ Aktif | Nama kawasan, jenis (lindung, produksi, cagar alam, dll.), lokasi (kabupaten, kecamatan, desa), luas (Ha), keterangan |
| **Lahan Kritis** | ✅ Aktif | Satu data per kecamatan berisi luas 5 tingkat kekritisan (sangat kritis, kritis, agak kritis, potensial kritis, tidak kritis), dipisah **di dalam** dan **di luar** kawasan hutan. Total dihitung otomatis. |
| **Lingkungan Hidup** | 🕓 Disiapkan | Halaman sudah ada, menunggu format data |
| **SDM** | 🕓 Disiapkan | Halaman sudah ada, menunggu format data |

### Fitur umum
- Dashboard berisi ringkasan angka, grafik batang per kecamatan, dan grafik komposisi kekritisan
- Pencarian dan filter per kecamatan di setiap tabel
- Halaman detail setiap data
- **Import** data dari Excel (`.xlsx`, `.xls`, `.csv`) dan **export** ke Excel
- Kelola akun pengguna (khusus Administrator)
- Tampilan responsif (desktop dan HP), pesan dalam Bahasa Indonesia, zona waktu WIB
- Halaman error (403, 404, 419, 429, 500, 503) dengan desain yang sama
- Login dibatasi 5 percobaan per menit untuk mencegah tebak-tebakan password

## 3. Role & Hak Akses

| Fitur | Administrator | Petugas | Viewer |
|---|:---:|:---:|:---:|
| Login ke panel pengelola | ✅ | ✅ | ✅ |
| Lihat dashboard & semua data | ✅ | ✅ | ✅ |
| Export data ke Excel | ✅ | ✅ | ✅ |
| Tambah & ubah data | ✅ | ✅ | ❌ |
| Import data dari Excel | ✅ | ✅ | ❌ |
| **Hapus** data | ✅ | ❌ | ❌ |
| **Kelola akun pengguna** | ✅ | ❌ | ❌ |
| Ubah profil & password sendiri | ✅ | ✅ | ✅ |

- Pembatasan berlaku di **server**, tidak sekadar menyembunyikan tombol. Akses langsung lewat URL yang tidak diizinkan dijawab dengan halaman **403**.
- Setiap role punya warna khas di dashboard: Administrator **hijau**, Petugas **biru**, Viewer **amber**.
- Administrator tidak bisa menurunkan role akunnya sendiri, supaya sistem tidak pernah kehilangan admin.
- Daftar role ada di `App\Models\User::ROLES`. Pembatasannya dipasang lewat middleware `role:` di [routes/web.php](routes/web.php).

## 4. Alur Aplikasi

### Alur pengguna

```
PUBLIK (tanpa login)                       PANEL PENGELOLA (login di /login)
────────────────────                       ─────────────────────────────────
Beranda (/)                                Dashboard (/admin)
 ├─ ringkasan angka + grafik                ├─ banner sambutan sesuai role
 ├─ Kawasan Hutan → tabel → detail          ├─ Kawasan Hutan : lihat · tambah · ubah · hapus* · import · export
 ├─ Lahan Kritis  → tabel → detail          ├─ Lahan Kritis  : lihat · tambah · ubah · hapus* · import · export
 ├─ Lingkungan Hidup (segera)               ├─ Lingkungan Hidup / SDM (segera)
 └─ SDM (segera)                            ├─ Pengguna* : kelola akun
                                            └─ Profil Saya : ubah nama, email, password
                                            (* = khusus Administrator)
```

Siklus datanya: **petugas atau admin memasukkan data** (manual atau import Excel), data **disimpan di database**, lalu **dashboard dan halaman publik otomatis menampilkan angka dan grafik terbaru**.

### Alur teknis (contoh: membuka `/lahan-kritis`)

```
Browser
  → routes/web.php              (URL ini ditangani siapa?)
  → Middleware                  (khusus /admin: sudah login? role-nya boleh?)
  → app/Http/Controllers        (ambil & olah data)
  → app/Models                  (berbicara dengan database)
  → Database                    (PostgreSQL/Supabase atau MySQL)
  → resources/views             (susun halaman HTML dengan Blade)
  → Browser
```

## 5. Teknologi

| Bagian | Teknologi |
|---|---|
| Backend | Laravel 10, PHP 8.1+ |
| Database | PostgreSQL (dipakai di Supabase) **atau** MySQL. Keduanya didukung. |
| Excel | [maatwebsite/excel](https://laravel-excel.com) |
| Frontend | Blade, CSS buatan sendiri (tanpa framework CSS), JavaScript biasa |
| Build aset | Vite |
| Grafik | Chart.js |
| Ikon & font | Bootstrap Icons, Inter (dipasang lewat npm, tanpa CDN) |

## 6. Instalasi & Menjalankan

### Kebutuhan
- **PHP 8.1+** dengan extension: `pdo_pgsql` (untuk Supabase) **atau** `pdo_mysql`, ditambah `gd`, `zip`, `mbstring`, `fileinfo`
- **Composer**
- **Node.js 18+** dan npm
- Disarankan memakai [Laragon](https://laragon.org) di Windows

> **Pakai Supabase di Laragon?** Extension `pdo_pgsql` dan `pgsql` biasanya masih nonaktif. Aktifkan lewat menu Laragon **PHP → Extensions**, atau hapus tanda `;` di depan `extension=pdo_pgsql` dan `extension=pgsql` pada `php.ini`.

### Langkah-langkah

```bash
# 1. Ambil kode
git clone https://github.com/indriaiqma/Project-Ketahanan-Pangan.git
cd Project-Ketahanan-Pangan
git checkout Rayhan            # branch berisi pembaruan terbaru

# 2. Pasang dependency
composer install
npm install

# 3. Siapkan file konfigurasi
cp .env.example .env           # di Windows (CMD): copy .env.example .env
php artisan key:generate

# 4. Atur koneksi database di .env (lihat pilihan A atau B di bawah)

# 5. Buat tabel + akun bawaan
php artisan migrate --seed

# 6. Build tampilan (CSS/JS)
npm run build

# 7. Jalankan
php artisan serve
```

Buka **http://127.0.0.1:8000**. Biarkan terminal `php artisan serve` tetap terbuka selama aplikasi dipakai.

### Pengaturan database di `.env`

**Pilihan A: Supabase (database bersama tim)**

Minta isi `.env` tim kepada pengelola project lewat **jalur pribadi**. Jangan pernah meng-commit `.env` ke GitHub.

```env
DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-southeast-2.pooler.supabase.com   # host "Session pooler" dari Supabase
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.<project-id>
DB_PASSWORD="<password database>"                   # beri tanda kutip jika ada spasi atau #
DB_PERSISTENT=true                                  # pakai ulang koneksi agar lebih cepat
```

> Gunakan **Session pooler**, bukan *Direct connection*. Koneksi langsung Supabase umumnya hanya lewat IPv6 dan sering gagal di jaringan rumah atau kantor.

**Pilihan B: MySQL lokal (untuk coba-coba sendiri)**

Nyalakan MySQL di Laragon, buat database kosong (misalnya `ketahanan_pangan`), lalu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ketahanan_pangan
DB_USERNAME=root
DB_PASSWORD=
```

### Saat mengembangkan tampilan
Jalankan `npm run dev` di terminal kedua (bersamaan dengan `php artisan serve`) agar perubahan CSS/JS langsung terlihat tanpa build ulang. Setelah selesai, jalankan `npm run build`.

## 7. Akun Bawaan

Dibuat oleh `php artisan migrate --seed` (lihat [DatabaseSeeder.php](database/seeders/DatabaseSeeder.php)):

| Role | Email | Password |
|---|---|---|
| Administrator | `admin@bakorwil3.jatimprov.go.id` | `GantiPasswordIni123` |
| Petugas | `petugas@bakorwil3.jatimprov.go.id` | `PetugasBakorwil123` |
| Viewer | `viewer@bakorwil3.jatimprov.go.id` | `ViewerBakorwil123` |

> ⚠️ **Segera ganti password** lewat menu **Profil Saya** setelah login, karena password di atas tertulis di kode.
>
> - Menjalankan ulang `php artisan db:seed` akan **me-reset password Administrator** ke bawaan. Ini bisa dipakai saat lupa password.
> - Akun Petugas dan Viewer **tidak** di-reset jika sudah ada.
> - Akun baru dibuat oleh Administrator di menu **Pengguna → Tambah Pengguna**. Aplikasi tidak menyediakan pendaftaran mandiri.

## 8. Format Import Excel

Baris pertama file harus berisi **nama kolom persis** seperti di bawah (huruf kecil, pakai garis bawah). Ukuran file maksimal 2 MB. Cara termudah mendapatkan contoh format: klik **Export Excel**, lalu pakai file hasilnya sebagai template.

### Kawasan Hutan

| Kolom | Wajib | Contoh |
|---|:---:|---|
| `kabupaten` | ✅ | Kabupaten Malang |
| `kecamatan` | ✅ | Dampit |
| `nama_kawasan` | ✅ | RPH Dampit |
| `jenis_kawasan` | ✅ | Hutan Lindung |
| `desa` | | Sukodono |
| `luas_ha` | | 1250.75 |
| `keterangan` | | Dikelola Perhutani |

Data dengan `kabupaten` + `kecamatan` + `nama_kawasan` yang sudah ada akan **diperbarui**, tidak dibuat ganda.

### Lahan Kritis

| Kolom | Keterangan |
|---|---|
| `kabupaten` | Opsional, default "Kabupaten Malang" |
| `kecamatan` | **Wajib**, dan harus salah satu dari 9 kecamatan Malang Selatan (penulisan persis, misalnya `Sumbermanjing Wetan`). Kecamatan lain diabaikan. |
| `dalam_sangat_kritis`, `dalam_kritis`, `dalam_agak_kritis`, `dalam_potensial_kritis`, `dalam_tidak_kritis` | Luas (Ha) **di dalam** kawasan hutan |
| `luar_sangat_kritis`, `luar_kritis`, `luar_agak_kritis`, `luar_potensial_kritis`, `luar_tidak_kritis` | Luas (Ha) **di luar** kawasan hutan |

- Kolom luas yang kosong dianggap 0.
- **Total dihitung otomatis** dari 10 kolom luas, jadi kolom `total_ha` di file boleh ada atau tidak.
- Satu kecamatan = satu data. Kecamatan yang sudah ada akan **diperbarui**.

> Tulis angka **tanpa titik ribuan**, misalnya `1500.75`, bukan `1.500,75`.

## 9. Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php           login & logout
│   │   ├── DashboardController.php      dashboard publik & panel (+ cache ringkasan)
│   │   ├── KawasanHutanController.php   CRUD, import, export kawasan hutan
│   │   ├── LahanKritisController.php    CRUD, import, export lahan kritis
│   │   ├── UserController.php           kelola pengguna (khusus admin)
│   │   └── ProfileController.php        profil & ganti password
│   └── Middleware/RoleMiddleware.php    pembatas akses berdasarkan role
├── Imports/  &  Exports/                aturan baca/tulis file Excel
├── Models/                              User (+ daftar role), KawasanHutan, LahanKritis
└── helpers.php                          fungsi angka() untuk format 12.345,67

database/
├── migrations/                          struktur tabel
└── seeders/DatabaseSeeder.php           akun bawaan

resources/
├── css/app.css                          SELURUH gaya tampilan (satu file)
├── js/app.js                            grafik, efek animasi, dropdown, dll.
└── views/
    ├── layouts/        public.blade.php (situs publik) · admin.blade.php (panel)
    ├── components/     potongan tampilan bersama: brand (logo), stat, field (input form),
    │                   page-header, alerts, empty, module-placeholder
    ├── partials/       grafik yang dipakai di beberapa halaman
    ├── dashboard-viewer.blade.php      landing page / beranda publik
    ├── kawasan-hutan/  & lahan-kritis/ halaman publik + partial tabel & ringkasan
    ├── admin/          halaman panel pengelola
    ├── auth/           halaman login
    └── errors/         halaman 403, 404, dst.

routes/web.php                           daftar semua URL + pembatasan role
lang/id/validation.php                   pesan validasi Bahasa Indonesia
public/images/                           logo, lambang Jawa Timur, favicon
```

## 10. Catatan Penting untuk Developer

- 🔴 **Jangan jalankan `php artisan test` jika `.env` mengarah ke Supabase.** Tes yang memakai `RefreshDatabase` akan **mengosongkan database bersama**. Gunakan database lokal terpisah untuk pengujian.
- **`.env` tidak boleh di-commit.** File ini sudah ada di `.gitignore`. Bagikan isinya lewat jalur pribadi saja.
- **Setelah `git pull`**, jalankan `composer install`, `npm install`, `php artisan migrate`, dan `npm run build` jika ada perubahan dependency, migration, atau tampilan.
- **Mengubah tampilan?** Edit `resources/css/app.css` atau `resources/js/app.js`, lalu jalankan `npm run build`. Hasil build (`public/build`) tidak di-commit.
- **Database Supabase berada di Sydney**, sehingga setiap query cukup lambat (±0,2–0,9 detik). Karena itu:
  - jumlah query per halaman sengaja dibuat sedikit (rekap per kecamatan dalam 1 query);
  - ringkasan dashboard **di-cache 5 menit** dan otomatis dihapus setiap kali data kawasan atau lahan kritis berubah (lihat `booted()` di model);
  - `DB_PERSISTENT=true` memakai ulang koneksi database.
- **Pencarian tidak membedakan huruf besar/kecil** di PostgreSQL maupun MySQL (`likeOperator()` di `Controller.php`).
- **Format angka**: gunakan helper `angka($nilai)` (hasil: `12.345,67`) atau `angka($nilai, 0)` (hasil: `12.345`).
- **Menambah halaman admin baru**: pakai `@extends('layouts.admin')` dan komponen yang sudah ada (`<x-page-header>`, `<x-stat>`, `<x-field>`) agar tampilannya seragam.
- **Menambah role baru**: tambahkan di `User::ROLES`, lalu atur aksesnya di `routes/web.php` (`role:...`) dan di view (`isAdmin()`, `canEditData()`).

## 11. Perubahan di Branch `Rayhan`

Ringkasan perubahan dibanding branch `main`:

**Perbaikan error**
- Halaman detail publik error 500 bagi pengunjung yang belum login
- Banyak form dan tombol admin mengarah ke URL yang salah (404/405)
- Setelah login dan setelah menyimpan data, aplikasi mengarah ke halaman yang tidak ada
- Halaman Kawasan Hutan publik tampil tanpa CSS
- Angka dashboard memakai data contoh (tanggal tertulis tetap di kode), dan kategori "Potensial Kritis" ikut terhitung sebagai "Tidak Kritis"
- Import Excel dengan file yang salah format menampilkan halaman error. Sekarang muncul pesan yang jelas.
- Total lahan kritis dari import Excel kini dihitung otomatis
- Nilai luas yang terlalu besar membuat database error. Sekarang divalidasi di form.

**Fitur & tampilan**
- Desain ulang seluruh halaman: satu sistem desain, landing page modern, panel pengelola dengan sidebar, efek animasi halus, logo dan favicon yang konsisten
- Sistem 3 role: Administrator, Petugas, Viewer
- Dukungan PostgreSQL (Supabase), halaman lebih cepat (sebelumnya 9–13 detik, sekarang ±2 detik)
- Pesan validasi Bahasa Indonesia, zona waktu WIB, pembatasan percobaan login

## 12. Cara Berkontribusi

Setiap anggota tim bekerja di **branch masing-masing**, lalu menggabungkannya ke `main` lewat **Pull Request**:

```bash
git checkout main
git pull                       # ambil versi terbaru
git checkout -b nama-anda      # buat branch sendiri
# ... ubah kode ...
git add .
git commit -m "Jelaskan perubahan Anda"
git push -u origin nama-anda
```

Setelah itu buka repository di GitHub, klik **Compare & pull request**, lalu minta anggota lain meninjaunya sebelum digabung ke `main`.

## 13. Mengatasi Masalah Umum

| Masalah | Penyebab & solusi |
|---|---|
| Browser menampilkan `ERR_CONNECTION_REFUSED` | Server belum jalan. Jalankan `php artisan serve` dan biarkan terminalnya terbuka. |
| `could not find driver` | Extension database PHP belum aktif. Aktifkan `pdo_pgsql` (Supabase) atau `pdo_mysql` (MySQL). |
| `password authentication failed` | Password di `.env` salah, atau mengandung spasi/`#` tanpa tanda kutip. Tulis sebagai `DB_PASSWORD="..."` lalu jalankan `php artisan config:clear`. |
| Tampilan berantakan atau tanpa gaya | Aset belum di-build. Jalankan `npm install` lalu `npm run build`, kemudian tekan Ctrl+F5 di browser. |
| `Vite manifest not found` | Sama seperti di atas: jalankan `npm run build`. |
| "Terlalu Banyak Percobaan" saat login | Salah login 5 kali dalam 1 menit. Tunggu 1 menit. |
| Lupa password Administrator | Jalankan `php artisan db:seed` (password admin kembali ke bawaan), lalu segera ganti lewat Profil. |
| Perubahan `.env` tidak berpengaruh | Jalankan `php artisan config:clear`. |
| Halaman lambat dibuka | Normal untuk kunjungan pertama, karena database Supabase berada di Sydney. Kunjungan berikutnya lebih cepat. |

---

<p align="center">
  © Bakorwil III Malang · Pemerintah Provinsi Jawa Timur
</p>
