<?php

/*
|--------------------------------------------------------------------------
| Definisi modul data generik
|--------------------------------------------------------------------------
| Setiap modul data (1 baris = 1 wilayah x 1 periode) cukup didefinisikan di
| sini. Halaman list, form input, validasi (client & server), grafik, kartu
| metrik, status, dan export Excel dibangun otomatis oleh ModulDataController
| dan App\Support\ModulData.
|
| Cara menambah modul baru:
|   1. Buat migration + model (pakai trait App\Models\Concerns\ModulData)
|   2. Tambahkan definisinya di bawah
|   3. Di config/bidang.php, ubah status modul menjadi 'aktif' dan isi 'data'
|
| Kunci definisi:
|   model      : kelas model Eloquent
|   periode    : 'semester' | 'bulan'
|   deskripsi  : teks singkat di header halaman
|   fields     : angka yang diinput. Opsi per field:
|                  label, satuan, grup (judul bagian form), hint,
|                  maks => field lain yang menjadi batas atas (bagian <= total)
|   total      : angka otomatis = jumlah beberapa field (disimpan di tabel)
|   persentase : angka otomatis = pembilang / penyebut x 100 (tidak disimpan)
|                  target => batas minimal untuk status "Baik"
|   metrik     : kunci yang tampil sebagai kartu metrik di atas tabel (2-4)
|   tabel      : kunci yang tampil sebagai kolom tabel
|   grafik     : field yang ditumpuk di grafik per wilayah
|   ringkasan  : field utama untuk ringkasan di halaman bidang
*/

return [

    'rekap-kependudukan' => [
        'model' => App\Models\RekapKependudukan::class,
        'periode' => 'semester',
        'deskripsi' => 'Rekap jumlah penduduk, KK, perekaman KTP-el, dan kepemilikan akta kelahiran per kecamatan.',

        'fields' => [
            'laki_laki' => ['label' => 'Laki-laki', 'satuan' => 'jiwa', 'grup' => 'Jumlah Penduduk'],
            'perempuan' => ['label' => 'Perempuan', 'satuan' => 'jiwa', 'grup' => 'Jumlah Penduduk'],
            'jumlah_kk' => ['label' => 'Jumlah Kartu Keluarga', 'satuan' => 'KK', 'grup' => 'Jumlah Penduduk'],

            'wajib_ktp_el' => ['label' => 'Wajib KTP-el', 'satuan' => 'jiwa', 'grup' => 'KTP Elektronik', 'hint' => 'Penduduk yang wajib memiliki KTP-el.'],
            'sudah_rekam_ktp_el' => ['label' => 'Sudah Rekam KTP-el', 'satuan' => 'jiwa', 'grup' => 'KTP Elektronik', 'maks' => 'wajib_ktp_el'],

            'penduduk_0_18' => ['label' => 'Penduduk Usia 0–18 Tahun', 'satuan' => 'jiwa', 'grup' => 'Akta Kelahiran'],
            'punya_akta' => ['label' => 'Memiliki Akta Kelahiran', 'satuan' => 'jiwa', 'grup' => 'Akta Kelahiran', 'maks' => 'penduduk_0_18', 'hint' => 'Dari penduduk usia 0–18 tahun.'],
        ],

        'total' => [
            'total_penduduk' => ['label' => 'Total Penduduk', 'satuan' => 'jiwa', 'dari' => ['laki_laki', 'perempuan']],
        ],

        'persentase' => [
            'persen_ktp_el' => ['label' => 'Perekaman KTP-el', 'pembilang' => 'sudah_rekam_ktp_el', 'penyebut' => 'wajib_ktp_el', 'target' => 95],
            'persen_akta' => ['label' => 'Kepemilikan Akta (0–18)', 'pembilang' => 'punya_akta', 'penyebut' => 'penduduk_0_18', 'target' => 90],
        ],

        'metrik' => ['total_penduduk', 'jumlah_kk', 'persen_ktp_el', 'persen_akta'],
        'tabel' => ['total_penduduk', 'jumlah_kk', 'persen_ktp_el', 'persen_akta'],
        'grafik' => ['laki_laki', 'perempuan'],
        'ringkasan' => 'total_penduduk',
    ],

];
