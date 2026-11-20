<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\DataBidangController;
use App\Http\Controllers\ModulDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KawasanHutanController;
use App\Http\Controllers\LahanKritisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| VIEWER / PUBLIK
|--------------------------------------------------------------------------
| Semua URL tanpa /admin adalah VIEWER.
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| DASHBOARD VIEWER
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| KAWASAN HUTAN - VIEWER
|--------------------------------------------------------------------------
*/

Route::get('/kawasan-hutan', [KawasanHutanController::class, 'index'])
    ->name('kawasan-hutan.index');

Route::get('/kawasan-hutan/export', [KawasanHutanController::class, 'export'])
    ->middleware('auth')
    ->name('kawasan-hutan.export');

Route::get('/kawasan-hutan/{kawasanHutan}', [KawasanHutanController::class, 'show'])
    ->whereNumber('kawasanHutan')
    ->name('kawasan-hutan.show');


/*
|--------------------------------------------------------------------------
| LAHAN KRITIS - VIEWER
|--------------------------------------------------------------------------
*/

Route::get('/lahan-kritis', [LahanKritisController::class, 'index'])
    ->name('lahan-kritis.index');

Route::get('/lahan-kritis/export', [LahanKritisController::class, 'export'])
    ->middleware('auth')
    ->name('lahan-kritis.export');

Route::get('/lahan-kritis/{lahanKriti}', [LahanKritisController::class, 'show'])
    ->whereNumber('lahanKriti')
    ->name('lahan-kritis.show');


/*
|--------------------------------------------------------------------------
| LINGKUNGAN HIDUP - VIEWER
|--------------------------------------------------------------------------
*/

Route::permanentRedirect('/lingkungan-hidup', '/data/sarana-prasarana/lingkungan-hidup')
    ->name('lingkungan-hidup');


/*
|--------------------------------------------------------------------------
| SDM - VIEWER
|--------------------------------------------------------------------------
*/

Route::permanentRedirect('/sdm', '/data/kemasyarakatan')
    ->name('sdm');


/*
|--------------------------------------------------------------------------
| DATA BIDANG (situs publik, hanya-baca, wajib login)
|--------------------------------------------------------------------------
| Halaman utama role Viewer: melihat hasil input Admin & Petugas di seluruh
| bidang dengan tampilan landing page. Petugas tetap dibatasi penugasannya
| (bidang:lihat), Admin & Viewer melihat semua bidang.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('data')->group(function () {
    Route::get('/', [DataBidangController::class, 'index'])
        ->name('data.index');

    Route::middleware('bidang:lihat')->group(function () {
        Route::get('/{bidang}', [DataBidangController::class, 'bidang'])
            ->name('data.bidang');

        Route::get('/{bidang}/{modul}', [DataBidangController::class, 'modul'])
            ->name('data.modul');

        Route::get('/{bidang}/{modul}/export', [ModulDataController::class, 'export'])
            ->name('data.export');

        Route::get('/{bidang}/{modul}/lampiran/{lampiran}', [ModulDataController::class, 'lampiran'])
            ->whereNumber('lampiran')
            ->name('data.lampiran');
    });
});


/*
|--------------------------------------------------------------------------
| PROFIL (semua role)
|--------------------------------------------------------------------------
| Viewer memakai layout landing page, Admin & Petugas layout panel.
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('admin.profile');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('admin.profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('admin.profile.password');
});



/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Semua URL /admin/... membutuhkan login Admin atau Petugas.
| - Viewer      : tidak memakai panel; melihat data di /data (landing page)
| - Petugas     : + tambah, ubah, import   (role:admin,petugas)
| - Admin       : + hapus & kelola pengguna (role:admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,petugas'])->prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DashboardController::class, 'adminIndex'])
        ->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | ROUTE LAMA LINGKUNGAN HIDUP & SDM
    |--------------------------------------------------------------------------
    | Kini menjadi bagian struktur bidang (config/bidang.php). Nama route
    | dipertahankan agar tautan lama tetap berfungsi (redirect permanen).
    */

    Route::permanentRedirect('/lingkungan-hidup', '/admin/bidang/sarana-prasarana/lingkungan-hidup')
        ->name('admin.lingkungan-hidup.index');

    Route::permanentRedirect('/sdm', '/admin/bidang/kemasyarakatan')
        ->name('admin.sdm.index');


    /*
    |--------------------------------------------------------------------------
    | BIDANG & MODUL (struktur dari config/bidang.php)
    |--------------------------------------------------------------------------
    | - bidang:lihat  : bidang harus ada (dan tidak disembunyikan untuk user)
    | - bidang:ubah   : petugas harus ditugaskan di sub bidang modul tersebut
    */

    Route::middleware('bidang:lihat')->group(function () {
        Route::get('/bidang/{bidang}', [BidangController::class, 'show'])
            ->name('admin.bidang.show');

        Route::get('/bidang/{bidang}/{modul}', [BidangController::class, 'modul'])
            ->name('admin.bidang.modul');

        // Modul data generik (lihat config/modul_data.php)
        Route::get('/bidang/{bidang}/{modul}/export', [ModulDataController::class, 'export'])
            ->name('admin.modul.export');

        Route::get('/bidang/{bidang}/{modul}/lampiran/{lampiran}', [ModulDataController::class, 'lampiran'])
            ->whereNumber('lampiran')
            ->name('admin.modul.lampiran');
    });

    Route::middleware(['role:admin,petugas', 'bidang:ubah'])->group(function () {
        Route::get('/bidang/{bidang}/{modul}/tambah', [ModulDataController::class, 'create'])
            ->name('admin.modul.create');

        Route::post('/bidang/{bidang}/{modul}', [ModulDataController::class, 'store'])
            ->name('admin.modul.store');

        Route::get('/bidang/{bidang}/{modul}/{id}/edit', [ModulDataController::class, 'edit'])
            ->whereNumber('id')
            ->name('admin.modul.edit');

        Route::put('/bidang/{bidang}/{modul}/{id}', [ModulDataController::class, 'update'])
            ->whereNumber('id')
            ->name('admin.modul.update');
    });

    Route::delete('/bidang/{bidang}/{modul}/{id}', [ModulDataController::class, 'destroy'])
        ->whereNumber('id')
        ->middleware(['role:admin', 'bidang:lihat'])
        ->name('admin.modul.destroy');




    /*
    |--------------------------------------------------------------------------
    | USERS (khusus Admin)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

    Route::get('/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/users/tambah', [UserController::class, 'create'])
        ->name('admin.users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('admin.users.store');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->whereNumber('user')
        ->name('admin.users.edit');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->whereNumber('user')
        ->name('admin.users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->whereNumber('user')
        ->name('admin.users.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | KAWASAN HUTAN - ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/kawasan-hutan', [KawasanHutanController::class, 'adminIndex'])
        ->middleware('bidang:lihat,sarana-prasarana,sarpras-2')
        ->name('admin.kawasan-hutan.index');

    Route::get('/kawasan-hutan/tambah', [KawasanHutanController::class, 'create'])
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.kawasan-hutan.create');

    Route::post('/kawasan-hutan', [KawasanHutanController::class, 'store'])
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.kawasan-hutan.store');

    Route::post('/kawasan-hutan/import', [KawasanHutanController::class, 'import'])
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.kawasan-hutan.import');

    Route::get('/kawasan-hutan/export', [KawasanHutanController::class, 'export'])
        ->middleware('bidang:lihat,sarana-prasarana,sarpras-2')
        ->name('admin.kawasan-hutan.export');

    Route::get('/kawasan-hutan/{kawasanHutan}/edit', [KawasanHutanController::class, 'edit'])
        ->whereNumber('kawasanHutan')
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.kawasan-hutan.edit');

    Route::put('/kawasan-hutan/{kawasanHutan}', [KawasanHutanController::class, 'update'])
        ->whereNumber('kawasanHutan')
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.kawasan-hutan.update');

    Route::delete('/kawasan-hutan/{kawasanHutan}', [KawasanHutanController::class, 'destroy'])
        ->whereNumber('kawasanHutan')
        ->middleware('role:admin')
        ->name('admin.kawasan-hutan.destroy');


    /*
    |--------------------------------------------------------------------------
    | LAHAN KRITIS - ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/lahan-kritis', [LahanKritisController::class, 'adminIndex'])
        ->middleware('bidang:lihat,sarana-prasarana,sarpras-2')
        ->name('admin.lahan-kritis.index');

    Route::get('/lahan-kritis/tambah', [LahanKritisController::class, 'create'])
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.lahan-kritis.create');

    Route::post('/lahan-kritis', [LahanKritisController::class, 'store'])
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.lahan-kritis.store');

    Route::post('/lahan-kritis/import', [LahanKritisController::class, 'import'])
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.lahan-kritis.import');

    Route::get('/lahan-kritis/export', [LahanKritisController::class, 'export'])
        ->middleware('bidang:lihat,sarana-prasarana,sarpras-2')
        ->name('admin.lahan-kritis.export');

    Route::get('/lahan-kritis/{lahanKriti}/edit', [LahanKritisController::class, 'edit'])
        ->whereNumber('lahanKriti')
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.lahan-kritis.edit');

    Route::put('/lahan-kritis/{lahanKriti}', [LahanKritisController::class, 'update'])
        ->whereNumber('lahanKriti')
        ->middleware(['role:admin,petugas', 'bidang:ubah,sarana-prasarana,sarpras-2'])
        ->name('admin.lahan-kritis.update');

    Route::delete('/lahan-kritis/{lahanKriti}', [LahanKritisController::class, 'destroy'])
        ->whereNumber('lahanKriti')
        ->middleware('role:admin')
        ->name('admin.lahan-kritis.destroy');

});