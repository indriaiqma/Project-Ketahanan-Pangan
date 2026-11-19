<?php

/*
|--------------------------------------------------------------------------
| Entry point untuk Vercel (serverless)
|--------------------------------------------------------------------------
| Di Vercel, folder project hanya bisa dibaca. Satu-satunya tempat yang
| bisa ditulis adalah /tmp, jadi folder storage Laravel (cache view,
| file sementara import/export Excel, dll.) dipindahkan ke /tmp.
| Untuk menjalankan di komputer sendiri tetap pakai: php artisan serve
*/

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$storage = '/tmp/storage';
foreach (['framework/views', 'framework/cache/data', 'framework/cache/laravel-excel', 'framework/sessions', 'app', 'logs'] as $dir) {
    if (! is_dir("$storage/$dir")) {
        @mkdir("$storage/$dir", 0755, true);
    }
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->useStoragePath($storage);

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
