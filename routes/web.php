<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
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
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

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

Route::get('/lahan-kritis/{lahanKriti}', [LahanKritisController::class, 'show'])
    ->whereNumber('lahanKriti')
    ->name('lahan-kritis.show');


/*
|--------------------------------------------------------------------------
| LINGKUNGAN HIDUP - VIEWER
|--------------------------------------------------------------------------
*/

Route::get('/lingkungan-hidup', function () {
    return view('lingkungan-hidup.index');
})->name('lingkungan-hidup');


/*
|--------------------------------------------------------------------------
| SDM - VIEWER
|--------------------------------------------------------------------------
*/

Route::get('/sdm', function () {
    return view('sdm.index');
})->name('sdm');



/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Semua URL /admin/... membutuhkan login.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/', [DashboardController::class, 'adminIndex'])
        ->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | LINGKUNGAN HIDUP - ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/lingkungan-hidup', function () {
        return view('admin.lingkungan-hidup.index');
    })->name('admin.lingkungan-hidup.index');


    /*
    |--------------------------------------------------------------------------
    | SDM - ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/sdm', function () {
        return view('admin.sdm.index');
    })->name('admin.sdm.index');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('admin.profile');

    Route::put('/profile', [ProfileController::class, 'update']);

    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);


    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | KAWASAN HUTAN - ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/kawasan-hutan', [KawasanHutanController::class, 'adminIndex'])
        ->name('admin.kawasan-hutan.index');

    Route::get('/kawasan-hutan/tambah', [KawasanHutanController::class, 'create'])
        ->name('admin.kawasan-hutan.create');

    Route::post('/kawasan-hutan', [KawasanHutanController::class, 'store'])
        ->name('admin.kawasan-hutan.store');

    Route::post('/kawasan-hutan/import', [KawasanHutanController::class, 'import'])
        ->name('admin.kawasan-hutan.import');

    Route::get('/kawasan-hutan/export', [KawasanHutanController::class, 'export'])
        ->name('admin.kawasan-hutan.export');

    Route::get('/kawasan-hutan/{kawasanHutan}/edit', [KawasanHutanController::class, 'edit'])
        ->whereNumber('kawasanHutan')
        ->name('admin.kawasan-hutan.edit');

    Route::put('/kawasan-hutan/{kawasanHutan}', [KawasanHutanController::class, 'update'])
        ->whereNumber('kawasanHutan')
        ->name('admin.kawasan-hutan.update');

    Route::delete('/kawasan-hutan/{kawasanHutan}', [KawasanHutanController::class, 'destroy'])
        ->whereNumber('kawasanHutan')
        ->name('admin.kawasan-hutan.destroy');


    /*
    |--------------------------------------------------------------------------
    | LAHAN KRITIS - ADMIN
    |--------------------------------------------------------------------------
    */

    Route::get('/lahan-kritis', [LahanKritisController::class, 'adminIndex'])
        ->name('admin.lahan-kritis.index');

    Route::get('/lahan-kritis/tambah', [LahanKritisController::class, 'create'])
        ->name('admin.lahan-kritis.create');

    Route::post('/lahan-kritis', [LahanKritisController::class, 'store'])
        ->name('admin.lahan-kritis.store');

    Route::post('/lahan-kritis/import', [LahanKritisController::class, 'import'])
        ->name('admin.lahan-kritis.import');

    Route::get('/lahan-kritis/export', [LahanKritisController::class, 'export'])
        ->name('admin.lahan-kritis.export');

    Route::get('/lahan-kritis/{lahanKriti}/edit', [LahanKritisController::class, 'edit'])
        ->whereNumber('lahanKriti')
        ->name('admin.lahan-kritis.edit');

    Route::put('/lahan-kritis/{lahanKriti}', [LahanKritisController::class, 'update'])
        ->whereNumber('lahanKriti')
        ->name('admin.lahan-kritis.update');

    Route::delete('/lahan-kritis/{lahanKriti}', [LahanKritisController::class, 'destroy'])
        ->whereNumber('lahanKriti')
        ->name('admin.lahan-kritis.destroy');

});