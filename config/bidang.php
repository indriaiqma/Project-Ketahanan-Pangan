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
    | Perlakuan bidang di luar penugasan petugas:
    |   'readonly' : tetap tampil, bisa dilihat, tidak bisa input/edit
    |   'hidden'   : disembunyikan dari sidebar dan tidak bisa dibuka
    */
    'akses_luar_penugasan' => 'readonly',

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
                        ['slug' => 'data-desa-kelurahan', 'nama' => 'Data Desa/Kelurahan', 'status' => 'segera', 'icon' => 'house'],
                        ['slug' => 'statistik-kominfo', 'nama' => 'Statistik & Kominfo', 'status' => 'segera', 'icon' => 'broadcast'],
                        ['slug' => 'perpustakaan-kearsipan', 'nama' => 'Perpustakaan & Kearsipan', 'status' => 'segera', 'icon' => 'archive'],
                    ],
                ],
                [
                    'slug' => 'pemerintahan-2',
                    'nama' => 'Sub Bidang Pemerintahan II',
                    'modul' => [
                        ['slug' => 'trantibumlinmas', 'nama' => 'Trantibumlinmas', 'status' => 'segera', 'icon' => 'shield-check'],
                        ['slug' => 'kesbangpol', 'nama' => 'Kesbangpol', 'status' => 'segera', 'icon' => 'flag'],
                        ['slug' => 'kerja-sama-daerah', 'nama' => 'Kerja Sama Daerah', 'status' => 'segera', 'icon' => 'people-fill'],
                        ['slug' => 'batas-wilayah', 'nama' => 'Batas Wilayah', 'status' => 'segera', 'icon' => 'bounding-box'],
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
                        ['slug' => 'umkm-koperasi', 'nama' => 'UMKM & Koperasi', 'status' => 'segera', 'icon' => 'shop'],
                        ['slug' => 'investasi', 'nama' => 'Investasi', 'status' => 'segera', 'icon' => 'cash-coin'],
                        ['slug' => 'perdagangan-industri', 'nama' => 'Perdagangan & Industri', 'status' => 'segera', 'icon' => 'building-gear'],
                    ],
                ],
                [
                    'slug' => 'ekonomi-2',
                    'nama' => 'Sub Bidang Pembangunan Ekonomi II',
                    'modul' => [
                        ['slug' => 'pertanian-perkebunan', 'nama' => 'Pertanian & Perkebunan', 'status' => 'segera', 'icon' => 'flower1'],
                        ['slug' => 'peternakan', 'nama' => 'Peternakan', 'status' => 'segera', 'icon' => 'egg-fried'],
                        ['slug' => 'perikanan', 'nama' => 'Perikanan', 'status' => 'segera', 'icon' => 'water'],
                        ['slug' => 'ketahanan-pangan', 'nama' => 'Ketahanan Pangan', 'status' => 'segera', 'icon' => 'basket'],
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
                        ['slug' => 'pendidikan', 'nama' => 'Pendidikan', 'status' => 'segera', 'icon' => 'mortarboard'],
                        ['slug' => 'kesehatan', 'nama' => 'Kesehatan', 'status' => 'segera', 'icon' => 'heart-pulse'],
                        ['slug' => 'sosial', 'nama' => 'Sosial', 'status' => 'segera', 'icon' => 'people'],
                        ['slug' => 'tenaga-kerja-transmigrasi', 'nama' => 'Tenaga Kerja & Transmigrasi', 'status' => 'segera', 'icon' => 'briefcase'],
                    ],
                ],
                [
                    'slug' => 'kemasyarakatan-2',
                    'nama' => 'Sub Bidang Kemasyarakatan II',
                    'modul' => [
                        // Rekap angka saja, tanpa data identitas korban
                        ['slug' => 'pppa', 'nama' => 'PPPA', 'status' => 'segera', 'icon' => 'person-arms-up'],
                        ['slug' => 'keluarga-berencana', 'nama' => 'KB', 'status' => 'segera', 'icon' => 'house-heart'],
                        ['slug' => 'kepemudaan-olahraga', 'nama' => 'Kepemudaan & Olahraga', 'status' => 'segera', 'icon' => 'trophy'],
                        ['slug' => 'budaya-pariwisata', 'nama' => 'Budaya & Pariwisata', 'status' => 'segera', 'icon' => 'camera'],
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
                        ['slug' => 'proyek-infrastruktur', 'nama' => 'Proyek Infrastruktur (PUPR)', 'status' => 'segera', 'icon' => 'bricks'],
                        ['slug' => 'perumahan-permukiman', 'nama' => 'Perumahan & Permukiman', 'status' => 'segera', 'icon' => 'houses'],
                        ['slug' => 'pertanahan', 'nama' => 'Pertanahan', 'status' => 'segera', 'icon' => 'map'],
                        ['slug' => 'perhubungan', 'nama' => 'Perhubungan', 'status' => 'segera', 'icon' => 'bus-front'],
                    ],
                ],
                [
                    'slug' => 'sarpras-2',
                    'nama' => 'Sub Bidang Sarpras II',
                    'modul' => [
                        // Modul lama: tetap di route lamanya
                        ['slug' => 'kawasan-hutan', 'nama' => 'Kawasan Hutan', 'status' => 'aktif', 'icon' => 'tree', 'route' => 'admin.kawasan-hutan.index', 'pola' => 'admin.kawasan-hutan.*'],
                        ['slug' => 'lahan-kritis', 'nama' => 'Lahan Kritis', 'status' => 'aktif', 'icon' => 'exclamation-triangle', 'route' => 'admin.lahan-kritis.index', 'pola' => 'admin.lahan-kritis.*'],
                        ['slug' => 'lingkungan-hidup', 'nama' => 'Lingkungan Hidup', 'status' => 'segera', 'icon' => 'globe-asia-australia'],
                        ['slug' => 'esdm', 'nama' => 'ESDM', 'status' => 'segera', 'icon' => 'lightning-charge'],
                    ],
                ],
            ],
        ],

        [
            'slug' => 'jabatan-fungsional',
            'nama' => 'Kelompok Jabatan Fungsional',
            'tagline' => 'Dukungan Keahlian Spesifik',
            'icon' => 'award',
            'sub_bidang' => [],
            'modul' => [
                ['slug' => 'pejabat-fungsional', 'nama' => 'Daftar Pejabat Fungsional', 'status' => 'segera', 'icon' => 'person-badge'],
                ['slug' => 'kajian-analisis', 'nama' => 'Kajian & Analisis', 'status' => 'segera', 'icon' => 'journal-text'],
            ],
        ],

    ],
];
