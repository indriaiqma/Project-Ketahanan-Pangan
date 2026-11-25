<?php

/*
|--------------------------------------------------------------------------
| Struktur Bidang Bakorwil III Malang (single source of truth)
|--------------------------------------------------------------------------
| Sidebar, breadcrumb, halaman ringkasan bidang, pencarian modul, dan hak
| akses per bidang SEMUANYA membaca dari file ini. Jangan menulis menu
| bidang langsung di view; ubah di sini, lalu gunakan App\Support\Bidang.
|
| Bidang  -> Sub Bidang -> Modul
|
| Kunci modul:
|   slug   : bagian URL, unik dalam satu bidang
|   nama   : label yang ditampilkan
|   status : 'aktif' (punya halaman data) | 'segera' (halaman placeholder)
|   icon   : nama ikon Bootstrap Icons tanpa awalan "bi-"
|   route  : (opsional) nama route halaman lama yang sudah ada
|   pola   : (opsional) pola nama route untuk menandai menu aktif
|   data   : (opsional) kunci definisi modul data generik di config/modul_data.php
|
| Sekretariat sengaja tidak dimasukkan.
*/

return [

    /*
    | Perlakuan bidang & sub bidang di luar penugasan PETUGAS:
    |   'hidden'   : petugas hanya melihat bidang/sub bidang yang ditugaskan;
    |                sisanya tidak muncul di menu dan tidak bisa dibuka (404)
    |   'readonly' : semua tampil, tetapi hanya sub bidang tugas yang bisa diubah
    | Admin selalu melihat semua bidang. Situs publik (/data) menampilkan
    | semua bidang untuk siapa pun, termasuk pengunjung tanpa login.
    */
    'akses_luar_penugasan' => 'hidden',

    'bidang' => [

        [
            'slug' => 'pemerintahan',
            'nama' => 'Bidang Pemerintahan',
            'tagline' => 'Tata Kelola Pemerintahan & Ketertiban Wilayah',
            'icon' => 'buildings',
            'sub_bidang' => [
                [
                    'slug' => 'pemerintahan-1',
                    'nama' => 'Sub Bidang Pemerintahan I',
                    'modul' => [
                        ['slug' => 'rekap-kependudukan', 'nama' => 'Rekap Kependudukan', 'status' => 'aktif', 'icon' => 'people', 'data' => 'rekap-kependudukan'],
                        ['slug' => 'data-desa-kelurahan', 'nama' => 'Data Desa/Kelurahan', 'status' => 'aktif', 'icon' => 'house', 'data' => 'data-desa-kelurahan'],
                        ['slug' => 'statistik-kominfo', 'nama' => 'Statistik & Kominfo', 'status' => 'aktif', 'icon' => 'broadcast', 'data' => 'statistik-kominfo'],
                        ['slug' => 'perpustakaan-kearsipan', 'nama' => 'Perpustakaan & Kearsipan', 'status' => 'aktif', 'icon' => 'archive', 'data' => 'perpustakaan-kearsipan'],
                    ],
                ],
                [
                    'slug' => 'pemerintahan-2',
                    'nama' => 'Sub Bidang Pemerintahan II',
                    'modul' => [
                        ['slug' => 'trantibumlinmas', 'nama' => 'Trantibumlinmas', 'status' => 'aktif', 'icon' => 'shield-check', 'data' => 'trantibumlinmas'],
                        ['slug' => 'kesbangpol', 'nama' => 'Kesbangpol', 'status' => 'aktif', 'icon' => 'flag', 'data' => 'kesbangpol'],
                        ['slug' => 'kerja-sama-daerah', 'nama' => 'Kerja Sama Daerah', 'status' => 'aktif', 'icon' => 'people-fill', 'data' => 'kerja-sama-daerah'],
                        ['slug' => 'batas-wilayah', 'nama' => 'Batas Wilayah', 'status' => 'aktif', 'icon' => 'bounding-box', 'data' => 'batas-wilayah'],
                    ],
                ],
            ],
        ],

        [
            'slug' => 'pembangunan-ekonomi',
            'nama' => 'Bidang Pembangunan Ekonomi',
            'tagline' => 'Sinkronisasi Ekonomi Regional & Ketahanan Pangan',
            'icon' => 'graph-up-arrow',
            'sub_bidang' => [
                [
                    'slug' => 'ekonomi-1',
                    'nama' => 'Sub Bidang Pembangunan Ekonomi I',
                    'modul' => [
                        ['slug' => 'umkm-koperasi', 'nama' => 'UMKM & Koperasi', 'status' => 'aktif', 'icon' => 'shop', 'data' => 'umkm-koperasi'],
                        ['slug' => 'investasi', 'nama' => 'Investasi', 'status' => 'aktif', 'icon' => 'cash-coin', 'data' => 'investasi'],
                        ['slug' => 'perdagangan-industri', 'nama' => 'Perdagangan & Industri', 'status' => 'aktif', 'icon' => 'building-gear', 'data' => 'perdagangan-industri'],
                    ],
                ],
                [
                    'slug' => 'ekonomi-2',
                    'nama' => 'Sub Bidang Pembangunan Ekonomi II',
                    'modul' => [
                        ['slug' => 'perikanan', 'nama' => 'Perikanan', 'status' => 'aktif', 'icon' => 'water', 'data' => 'perikanan'],
                        ['slug' => 'ketahanan-pangan', 'nama' => 'Ketahanan Pangan', 'status' => 'aktif', 'icon' => 'basket', 'data' => 'ketahanan-pangan'],
                    ],
                ],
            ],
        ],

        [
            'slug' => 'kemasyarakatan',
            'nama' => 'Bidang Kemasyarakatan',
            'tagline' => 'Pembangunan SDM & Kesejahteraan Sosial',
            'icon' => 'person-hearts',
            'sub_bidang' => [
                [
                    'slug' => 'kemasyarakatan-1',
                    'nama' => 'Sub Bidang Kemasyarakatan I',
                    'modul' => [
                        ['slug' => 'pendidikan', 'nama' => 'Pendidikan', 'status' => 'aktif', 'icon' => 'mortarboard', 'data' => 'pendidikan'],
                        ['slug' => 'kesehatan', 'nama' => 'Kesehatan', 'status' => 'aktif', 'icon' => 'heart-pulse', 'data' => 'kesehatan'],
                        ['slug' => 'sosial', 'nama' => 'Sosial', 'status' => 'aktif', 'icon' => 'people', 'data' => 'sosial'],
                        ['slug' => 'tenaga-kerja-transmigrasi', 'nama' => 'Tenaga Kerja & Transmigrasi', 'status' => 'aktif', 'icon' => 'briefcase', 'data' => 'tenaga-kerja-transmigrasi'],
                    ],
                ],
                [
                    'slug' => 'kemasyarakatan-2',
                    'nama' => 'Sub Bidang Kemasyarakatan II',
                    'modul' => [
                        // Rekap angka saja, tanpa data identitas korban
                        ['slug' => 'pppa', 'nama' => 'PPPA', 'status' => 'aktif', 'icon' => 'person-arms-up', 'data' => 'pppa'],
                        ['slug' => 'keluarga-berencana', 'nama' => 'KB', 'status' => 'aktif', 'icon' => 'house-heart', 'data' => 'keluarga-berencana'],
                        ['slug' => 'kepemudaan-olahraga', 'nama' => 'Kepemudaan & Olahraga', 'status' => 'aktif', 'icon' => 'trophy', 'data' => 'kepemudaan-olahraga'],
                        ['slug' => 'budaya-pariwisata', 'nama' => 'Budaya & Pariwisata', 'status' => 'aktif', 'icon' => 'camera', 'data' => 'budaya-pariwisata'],
                    ],
                ],
            ],
        ],

        [
            'slug' => 'sarana-prasarana',
            'nama' => 'Bidang Sarana & Prasarana',
            'tagline' => 'Infrastruktur Wilayah & Pengelolaan SDA',
            'icon' => 'cone-striped',
            'sub_bidang' => [
                [
                    'slug' => 'sarpras-1',
                    'nama' => 'Sub Bidang Sarpras I',
                    'modul' => [
                        ['slug' => 'proyek-infrastruktur', 'nama' => 'Proyek Infrastruktur (PUPR)', 'status' => 'aktif', 'icon' => 'bricks', 'data' => 'proyek-infrastruktur'],
                        ['slug' => 'perumahan-permukiman', 'nama' => 'Perumahan & Permukiman', 'status' => 'aktif', 'icon' => 'houses', 'data' => 'perumahan-permukiman'],
                        ['slug' => 'pertanahan', 'nama' => 'Pertanahan', 'status' => 'aktif', 'icon' => 'map', 'data' => 'pertanahan'],
                        ['slug' => 'perhubungan', 'nama' => 'Perhubungan', 'status' => 'aktif', 'icon' => 'bus-front', 'data' => 'perhubungan'],
                    ],
                ],
                [
                    'slug' => 'sarpras-2',
                    'nama' => 'Sub Bidang Sarpras II',
                    'modul' => [
                        // Modul lama: tetap di route lamanya
                        ['slug' => 'kawasan-hutan', 'nama' => 'Kawasan Hutan', 'status' => 'aktif', 'icon' => 'tree', 'route' => 'admin.kawasan-hutan.index', 'pola' => 'admin.kawasan-hutan.*'],
                        ['slug' => 'lahan-kritis', 'nama' => 'Lahan Kritis', 'status' => 'aktif', 'icon' => 'exclamation-triangle', 'route' => 'admin.lahan-kritis.index', 'pola' => 'admin.lahan-kritis.*'],
                        ['slug' => 'lingkungan-hidup', 'nama' => 'Lingkungan Hidup', 'status' => 'aktif', 'icon' => 'globe-asia-australia', 'data' => 'lingkungan-hidup'],
                        ['slug' => 'esdm', 'nama' => 'ESDM', 'status' => 'aktif', 'icon' => 'lightning-charge', 'data' => 'esdm'],
                    ],
                ],
            ],
        ],

        /*
        | MENU KHUSUS (di luar struktur bidang)
        | 'khusus' => true : tampil sebagai menu tersendiri di sidebar panel dan
        |                    navbar situs publik, tidak termasuk daftar bidang.
        | 'akses_dari'     : penugasan petugas yang otomatis boleh mengelola menu ini
        |                    (selain Admin dan petugas yang ditugaskan langsung).
        */
        [
            'slug' => 'pertanian-peternakan',
            'nama' => 'Pertanian & Peternakan',
            'tagline' => 'Produksi Pertanian, Perkebunan & Peternakan Malang Selatan',
            'icon' => 'flower1',
            'khusus' => true,
            'akses_dari' => [['pembangunan-ekonomi', 'ekonomi-2']],
            'sub_bidang' => [],
            'modul' => [
                ['slug' => 'pertanian-perkebunan', 'nama' => 'Pertanian & Perkebunan', 'status' => 'aktif', 'icon' => 'flower1', 'data' => 'pertanian-perkebunan'],
                ['slug' => 'peternakan', 'nama' => 'Peternakan', 'status' => 'aktif', 'icon' => 'egg-fried', 'data' => 'peternakan'],
            ],
        ],

    ],
];
