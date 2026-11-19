<?php

/*
|--------------------------------------------------------------------------
| Definisi modul data generik
|--------------------------------------------------------------------------
| Halaman list, form input, validasi (client & server), grafik, kartu metrik,
| status, dan export Excel dibangun otomatis oleh ModulDataController dan
| App\Support\ModulData dari definisi di bawah.
|
| Modul yang TIDAK menyebut 'model' disimpan di tabel bersama "modul_data"
| (kolom JSON). Untuk modul seperti itu, menambah/mengubah field CUKUP di file
| ini, tanpa migration. Modul baru: tambahkan definisinya di sini, lalu di
| config/bidang.php ubah status modul menjadi 'aktif' dan isi 'data'.
|
| Catatan: indikator di bawah adalah draf awal yang wajar per urusan; silakan
| disesuaikan dengan format data resmi masing-masing bidang.
|
| ── Jenis "rekap" (bawaan): 1 baris = 1 kecamatan x 1 periode ───────────────
|   periode    : 'semester' | 'bulan' | 'tahun'
|   fields     : angka yang diinput. Opsi: label, satuan, grup, hint,
|                tipe ('bulat' bawaan | 'desimal'),
|                maks => field lain yang menjadi batas atas (bagian <= total)
|   total      : angka otomatis = jumlah beberapa field
|   persentase : pembilang / penyebut x 100 (tidak disimpan). Opsi:
|                target      => minimal untuk status "Baik" (makin tinggi makin baik)
|                target_maks => maksimal untuk status "Baik" (makin rendah makin baik)
|   metrik     : kunci yang tampil sebagai kartu metrik (2-4)
|   tabel      : kunci yang tampil sebagai kolom tabel
|   grafik     : field yang ditumpuk di grafik per kecamatan
|   ringkasan  : field utama untuk ringkasan di halaman bidang
|
| ── Jenis "daftar": 1 baris = 1 entri bebas (proyek, dokumen, dll.) ─────────
|   fields     : tipe 'teks' | 'teks_panjang' | 'angka' | 'desimal' | 'persen' |
|                'tanggal' | 'tahun' | 'pilihan' (+ opsi) | 'wilayah'
|                Opsi lain: wajib, satuan, grup, hint, setelah (tanggal minimal)
|   tabel      : field yang tampil sebagai kolom tabel (kolom pertama = judul)
|   cari       : field teks yang bisa dicari
|   filter     : satu field pilihan untuk filter
|   grafik     : [satu field pilihan/wilayah] untuk grafik jumlah per kategori
|   metrik     : [['label', 'agregat' => jumlah|hitung|sum|avg, 'field', 'nilai', 'satuan', 'icon'], ...]
*/

$bidangLabel = ['Pemerintahan', 'Pembangunan Ekonomi', 'Kemasyarakatan', 'Sarana & Prasarana', 'Umum / Lintas Bidang'];

return [

    /* =====================================================================
     | BIDANG PEMERINTAHAN — Sub Bidang Pemerintahan I
     * ===================================================================== */

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

    'data-desa-kelurahan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Jumlah desa/kelurahan dan status Indeks Desa Membangun (IDM) per kecamatan.',
        'fields' => [
            'jumlah_desa' => ['label' => 'Jumlah Desa', 'satuan' => 'desa', 'grup' => 'Wilayah Administrasi'],
            'jumlah_kelurahan' => ['label' => 'Jumlah Kelurahan', 'satuan' => 'kelurahan', 'grup' => 'Wilayah Administrasi'],
            'desa_mandiri' => ['label' => 'Desa Mandiri', 'satuan' => 'desa', 'grup' => 'Status IDM', 'maks' => 'jumlah_desa'],
            'desa_maju' => ['label' => 'Desa Maju', 'satuan' => 'desa', 'grup' => 'Status IDM', 'maks' => 'jumlah_desa'],
            'desa_berkembang' => ['label' => 'Desa Berkembang', 'satuan' => 'desa', 'grup' => 'Status IDM', 'maks' => 'jumlah_desa'],
            'desa_tertinggal' => ['label' => 'Desa Tertinggal', 'satuan' => 'desa', 'grup' => 'Status IDM', 'maks' => 'jumlah_desa'],
        ],
        'total' => [
            'total_wilayah' => ['label' => 'Total Desa/Kelurahan', 'satuan' => 'wilayah', 'dari' => ['jumlah_desa', 'jumlah_kelurahan']],
            'desa_maju_mandiri' => ['label' => 'Desa Maju & Mandiri', 'satuan' => 'desa', 'dari' => ['desa_mandiri', 'desa_maju']],
        ],
        'persentase' => [
            'persen_maju_mandiri' => ['label' => 'Desa Maju & Mandiri', 'pembilang' => 'desa_maju_mandiri', 'penyebut' => 'jumlah_desa', 'target' => 50],
        ],
        'metrik' => ['total_wilayah', 'jumlah_desa', 'desa_tertinggal', 'persen_maju_mandiri'],
        'tabel' => ['jumlah_desa', 'jumlah_kelurahan', 'desa_mandiri', 'desa_tertinggal', 'persen_maju_mandiri'],
        'grafik' => ['desa_mandiri', 'desa_maju', 'desa_berkembang', 'desa_tertinggal'],
        'ringkasan' => 'total_wilayah',
    ],

    'statistik-kominfo' => [
        'periode' => 'tahun',
        'deskripsi' => 'Jangkauan internet, infrastruktur telekomunikasi, dan layanan informasi desa per kecamatan.',
        'fields' => [
            'jumlah_desa' => ['label' => 'Jumlah Desa/Kelurahan', 'satuan' => 'desa', 'grup' => 'Jangkauan Internet'],
            'desa_terjangkau_internet' => ['label' => 'Desa Terjangkau Internet 4G', 'satuan' => 'desa', 'grup' => 'Jangkauan Internet', 'maks' => 'jumlah_desa'],
            'desa_blank_spot' => ['label' => 'Desa Blank Spot', 'satuan' => 'desa', 'grup' => 'Jangkauan Internet', 'maks' => 'jumlah_desa'],
            'menara_bts' => ['label' => 'Menara BTS', 'satuan' => 'menara', 'grup' => 'Infrastruktur & Layanan'],
            'desa_punya_website' => ['label' => 'Desa Memiliki Website/Media Informasi', 'satuan' => 'desa', 'grup' => 'Infrastruktur & Layanan', 'maks' => 'jumlah_desa'],
        ],
        'persentase' => [
            'persen_internet' => ['label' => 'Desa Terjangkau Internet', 'pembilang' => 'desa_terjangkau_internet', 'penyebut' => 'jumlah_desa', 'target' => 90],
            'persen_website' => ['label' => 'Desa Punya Website', 'pembilang' => 'desa_punya_website', 'penyebut' => 'jumlah_desa'],
        ],
        'metrik' => ['menara_bts', 'desa_blank_spot', 'persen_internet', 'persen_website'],
        'tabel' => ['jumlah_desa', 'desa_blank_spot', 'menara_bts', 'persen_internet', 'persen_website'],
        'grafik' => ['desa_terjangkau_internet', 'desa_blank_spot'],
        'ringkasan' => 'desa_terjangkau_internet',
    ],

    'perpustakaan-kearsipan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Ketersediaan perpustakaan desa, koleksi, kunjungan, dan pengelolaan arsip per kecamatan.',
        'fields' => [
            'jumlah_desa' => ['label' => 'Jumlah Desa/Kelurahan', 'satuan' => 'desa', 'grup' => 'Perpustakaan'],
            'desa_punya_perpustakaan' => ['label' => 'Desa Memiliki Perpustakaan', 'satuan' => 'desa', 'grup' => 'Perpustakaan', 'maks' => 'jumlah_desa'],
            'koleksi_buku' => ['label' => 'Koleksi Buku', 'satuan' => 'eksemplar', 'grup' => 'Perpustakaan'],
            'pengunjung' => ['label' => 'Pengunjung Perpustakaan', 'satuan' => 'orang', 'grup' => 'Perpustakaan'],
            'desa_tertib_arsip' => ['label' => 'Desa Tertib Arsip', 'satuan' => 'desa', 'grup' => 'Kearsipan', 'maks' => 'jumlah_desa'],
        ],
        'persentase' => [
            'persen_perpustakaan' => ['label' => 'Desa Punya Perpustakaan', 'pembilang' => 'desa_punya_perpustakaan', 'penyebut' => 'jumlah_desa', 'target' => 75],
            'persen_arsip' => ['label' => 'Desa Tertib Arsip', 'pembilang' => 'desa_tertib_arsip', 'penyebut' => 'jumlah_desa'],
        ],
        'metrik' => ['koleksi_buku', 'pengunjung', 'persen_perpustakaan', 'persen_arsip'],
        'tabel' => ['desa_punya_perpustakaan', 'koleksi_buku', 'pengunjung', 'persen_perpustakaan', 'persen_arsip'],
        'grafik' => ['pengunjung'],
        'ringkasan' => 'koleksi_buku',
    ],

    /* =====================================================================
     | BIDANG PEMERINTAHAN — Sub Bidang Pemerintahan II
     * ===================================================================== */

    'trantibumlinmas' => [
        'periode' => 'semester',
        'deskripsi' => 'Ketenteraman, ketertiban umum, dan perlindungan masyarakat per kecamatan.',
        'fields' => [
            'kejadian_bencana' => ['label' => 'Kejadian Bencana', 'satuan' => 'kejadian', 'grup' => 'Kejadian'],
            'gangguan_trantibum' => ['label' => 'Gangguan Trantibum', 'satuan' => 'kejadian', 'grup' => 'Kejadian'],
            'gangguan_tertangani' => ['label' => 'Gangguan Tertangani', 'satuan' => 'kejadian', 'grup' => 'Kejadian', 'maks' => 'gangguan_trantibum'],
            'anggota_linmas' => ['label' => 'Anggota Satlinmas', 'satuan' => 'orang', 'grup' => 'Sumber Daya'],
            'pos_kamling' => ['label' => 'Pos Kamling Aktif', 'satuan' => 'pos', 'grup' => 'Sumber Daya'],
        ],
        'persentase' => [
            'persen_tertangani' => ['label' => 'Gangguan Tertangani', 'pembilang' => 'gangguan_tertangani', 'penyebut' => 'gangguan_trantibum', 'target' => 90],
        ],
        'metrik' => ['kejadian_bencana', 'gangguan_trantibum', 'anggota_linmas', 'persen_tertangani'],
        'tabel' => ['kejadian_bencana', 'gangguan_trantibum', 'anggota_linmas', 'pos_kamling', 'persen_tertangani'],
        'grafik' => ['kejadian_bencana', 'gangguan_trantibum'],
        'ringkasan' => 'gangguan_trantibum',
    ],

    'kesbangpol' => [
        'periode' => 'tahun',
        'deskripsi' => 'Organisasi kemasyarakatan, potensi konflik sosial, dan pembinaan wawasan kebangsaan per kecamatan.',
        'fields' => [
            'ormas_terdaftar' => ['label' => 'Ormas Terdaftar', 'satuan' => 'ormas', 'grup' => 'Organisasi Kemasyarakatan'],
            'ormas_aktif' => ['label' => 'Ormas Aktif', 'satuan' => 'ormas', 'grup' => 'Organisasi Kemasyarakatan', 'maks' => 'ormas_terdaftar'],
            'potensi_konflik' => ['label' => 'Potensi Konflik Sosial', 'satuan' => 'kasus', 'grup' => 'Kewaspadaan'],
            'konflik_terselesaikan' => ['label' => 'Konflik Terselesaikan', 'satuan' => 'kasus', 'grup' => 'Kewaspadaan', 'maks' => 'potensi_konflik'],
            'kegiatan_wasbang' => ['label' => 'Kegiatan Wawasan Kebangsaan', 'satuan' => 'kegiatan', 'grup' => 'Pembinaan'],
        ],
        'persentase' => [
            'persen_ormas_aktif' => ['label' => 'Ormas Aktif', 'pembilang' => 'ormas_aktif', 'penyebut' => 'ormas_terdaftar'],
            'persen_konflik_selesai' => ['label' => 'Konflik Terselesaikan', 'pembilang' => 'konflik_terselesaikan', 'penyebut' => 'potensi_konflik', 'target' => 80],
        ],
        'metrik' => ['ormas_terdaftar', 'potensi_konflik', 'kegiatan_wasbang', 'persen_konflik_selesai'],
        'tabel' => ['ormas_terdaftar', 'potensi_konflik', 'kegiatan_wasbang', 'persen_ormas_aktif', 'persen_konflik_selesai'],
        'grafik' => ['ormas_terdaftar'],
        'ringkasan' => 'ormas_terdaftar',
    ],

    'kerja-sama-daerah' => [
        'jenis' => 'daftar',
        'deskripsi' => 'Daftar perjanjian kerja sama daerah beserta mitra, masa berlaku, dan statusnya.',
        'fields' => [
            'judul' => ['label' => 'Judul Kerja Sama', 'wajib' => true, 'lebar' => 'penuh', 'grup' => 'Perjanjian'],
            'mitra' => ['label' => 'Mitra', 'wajib' => true, 'grup' => 'Perjanjian', 'contoh' => 'Pemkab Blitar / PT …'],
            'jenis_kerja_sama' => ['label' => 'Jenis', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Perjanjian',
                'opsi' => ['Antar Daerah', 'Dengan Pihak Ketiga', 'Luar Negeri']],
            'nomor' => ['label' => 'Nomor Perjanjian', 'grup' => 'Perjanjian'],
            'tanggal_mulai' => ['label' => 'Tanggal Mulai', 'tipe' => 'tanggal', 'wajib' => true, 'grup' => 'Masa Berlaku'],
            'tanggal_berakhir' => ['label' => 'Tanggal Berakhir', 'tipe' => 'tanggal', 'grup' => 'Masa Berlaku', 'setelah' => 'tanggal_mulai'],
            'status' => ['label' => 'Status', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Masa Berlaku',
                'opsi' => ['Draf', 'Aktif', 'Berakhir']],
            'ruang_lingkup' => ['label' => 'Ruang Lingkup', 'tipe' => 'teks_panjang', 'grup' => 'Masa Berlaku'],
        ],
        'tabel' => ['judul', 'mitra', 'jenis_kerja_sama', 'tanggal_mulai', 'tanggal_berakhir', 'status'],
        'cari' => ['judul', 'mitra', 'nomor'],
        'filter' => 'status',
        'grafik' => ['jenis_kerja_sama'],
        'metrik' => [
            ['label' => 'Total Kerja Sama', 'icon' => 'people-fill', 'satuan' => 'perjanjian'],
            ['label' => 'Aktif', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Aktif', 'icon' => 'check2-circle', 'satuan' => 'perjanjian'],
            ['label' => 'Antar Daerah', 'agregat' => 'hitung', 'field' => 'jenis_kerja_sama', 'nilai' => 'Antar Daerah', 'icon' => 'signpost-split', 'satuan' => 'perjanjian'],
            ['label' => 'Sudah Berakhir', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Berakhir', 'icon' => 'hourglass-bottom', 'satuan' => 'perjanjian'],
        ],
    ],

    'batas-wilayah' => [
        'jenis' => 'daftar',
        'deskripsi' => 'Daftar segmen batas wilayah kecamatan/desa beserta status penegasannya.',
        'fields' => [
            'segmen' => ['label' => 'Nama Segmen', 'wajib' => true, 'grup' => 'Segmen Batas', 'contoh' => 'Batas Desa A – Desa B'],
            'kecamatan' => ['label' => 'Kecamatan', 'tipe' => 'wilayah', 'wajib' => true, 'grup' => 'Segmen Batas'],
            'berbatasan_dengan' => ['label' => 'Berbatasan Dengan', 'wajib' => true, 'grup' => 'Segmen Batas', 'contoh' => 'Kecamatan / desa / kabupaten tetangga'],
            'panjang_km' => ['label' => 'Panjang Segmen', 'tipe' => 'desimal', 'satuan' => 'km', 'grup' => 'Segmen Batas'],
            'status' => ['label' => 'Status Penegasan', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Status',
                'opsi' => ['Belum Ditegaskan', 'Proses Penegasan', 'Sudah Ditegaskan', 'Bersengketa']],
            'dasar_hukum' => ['label' => 'Dasar Hukum', 'grup' => 'Status', 'contoh' => 'Permendagri / Perbup …'],
        ],
        'tabel' => ['segmen', 'kecamatan', 'berbatasan_dengan', 'panjang_km', 'status'],
        'cari' => ['segmen', 'berbatasan_dengan'],
        'filter' => 'status',
        'grafik' => ['status'],
        'metrik' => [
            ['label' => 'Total Segmen', 'icon' => 'bounding-box', 'satuan' => 'segmen'],
            ['label' => 'Sudah Ditegaskan', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Sudah Ditegaskan', 'icon' => 'check2-circle', 'satuan' => 'segmen'],
            ['label' => 'Bersengketa', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Bersengketa', 'icon' => 'exclamation-triangle', 'satuan' => 'segmen'],
            ['label' => 'Total Panjang', 'agregat' => 'sum', 'field' => 'panjang_km', 'icon' => 'rulers', 'satuan' => 'km'],
        ],
    ],

    /* =====================================================================
     | BIDANG PEMBANGUNAN EKONOMI — Sub Bidang Pembangunan Ekonomi I
     * ===================================================================== */

    'umkm-koperasi' => [
        'periode' => 'tahun',
        'deskripsi' => 'Jumlah UMKM, UMKM binaan, dan keaktifan koperasi per kecamatan.',
        'fields' => [
            'jumlah_umkm' => ['label' => 'Jumlah UMKM', 'satuan' => 'unit', 'grup' => 'UMKM'],
            'umkm_binaan' => ['label' => 'UMKM Binaan', 'satuan' => 'unit', 'grup' => 'UMKM', 'maks' => 'jumlah_umkm'],
            'tenaga_kerja_umkm' => ['label' => 'Tenaga Kerja UMKM', 'satuan' => 'orang', 'grup' => 'UMKM'],
            'koperasi_terdaftar' => ['label' => 'Koperasi Terdaftar', 'satuan' => 'unit', 'grup' => 'Koperasi'],
            'koperasi_aktif' => ['label' => 'Koperasi Aktif', 'satuan' => 'unit', 'grup' => 'Koperasi', 'maks' => 'koperasi_terdaftar'],
        ],
        'persentase' => [
            'persen_binaan' => ['label' => 'UMKM Binaan', 'pembilang' => 'umkm_binaan', 'penyebut' => 'jumlah_umkm'],
            'persen_koperasi_aktif' => ['label' => 'Koperasi Aktif', 'pembilang' => 'koperasi_aktif', 'penyebut' => 'koperasi_terdaftar', 'target' => 70],
        ],
        'metrik' => ['jumlah_umkm', 'tenaga_kerja_umkm', 'koperasi_terdaftar', 'persen_koperasi_aktif'],
        'tabel' => ['jumlah_umkm', 'umkm_binaan', 'tenaga_kerja_umkm', 'koperasi_terdaftar', 'persen_koperasi_aktif'],
        'grafik' => ['jumlah_umkm'],
        'ringkasan' => 'jumlah_umkm',
    ],

    'investasi' => [
        'periode' => 'semester',
        'deskripsi' => 'Realisasi investasi PMDN dan PMA, jumlah proyek, dan tenaga kerja terserap per kecamatan.',
        'fields' => [
            'nilai_pmdn' => ['label' => 'Realisasi PMDN', 'tipe' => 'desimal', 'satuan' => 'juta Rp', 'grup' => 'Nilai Investasi'],
            'nilai_pma' => ['label' => 'Realisasi PMA', 'tipe' => 'desimal', 'satuan' => 'juta Rp', 'grup' => 'Nilai Investasi'],
            'jumlah_proyek' => ['label' => 'Jumlah Proyek', 'satuan' => 'proyek', 'grup' => 'Proyek & Tenaga Kerja'],
            'tenaga_kerja' => ['label' => 'Tenaga Kerja Terserap', 'satuan' => 'orang', 'grup' => 'Proyek & Tenaga Kerja'],
        ],
        'total' => [
            'total_investasi' => ['label' => 'Total Investasi', 'satuan' => 'juta Rp', 'dari' => ['nilai_pmdn', 'nilai_pma']],
        ],
        'metrik' => ['total_investasi', 'nilai_pma', 'jumlah_proyek', 'tenaga_kerja'],
        'tabel' => ['nilai_pmdn', 'nilai_pma', 'total_investasi', 'jumlah_proyek', 'tenaga_kerja'],
        'grafik' => ['nilai_pmdn', 'nilai_pma'],
        'ringkasan' => 'total_investasi',
    ],

    'perdagangan-industri' => [
        'periode' => 'tahun',
        'deskripsi' => 'Sarana perdagangan, industri kecil menengah (IKM), dan tenaga kerja industri per kecamatan.',
        'fields' => [
            'pasar_rakyat' => ['label' => 'Pasar Rakyat', 'satuan' => 'pasar', 'grup' => 'Perdagangan'],
            'toko_modern' => ['label' => 'Toko Modern', 'satuan' => 'toko', 'grup' => 'Perdagangan'],
            'jumlah_ikm' => ['label' => 'Industri Kecil Menengah (IKM)', 'satuan' => 'unit', 'grup' => 'Industri'],
            'ikm_bersertifikat' => ['label' => 'IKM Bersertifikat (Halal/SNI/PIRT)', 'satuan' => 'unit', 'grup' => 'Industri', 'maks' => 'jumlah_ikm'],
            'tenaga_kerja_industri' => ['label' => 'Tenaga Kerja Industri', 'satuan' => 'orang', 'grup' => 'Industri'],
        ],
        'persentase' => [
            'persen_ikm_sertifikat' => ['label' => 'IKM Bersertifikat', 'pembilang' => 'ikm_bersertifikat', 'penyebut' => 'jumlah_ikm', 'target' => 50],
        ],
        'metrik' => ['pasar_rakyat', 'jumlah_ikm', 'tenaga_kerja_industri', 'persen_ikm_sertifikat'],
        'tabel' => ['pasar_rakyat', 'toko_modern', 'jumlah_ikm', 'tenaga_kerja_industri', 'persen_ikm_sertifikat'],
        'grafik' => ['jumlah_ikm'],
        'ringkasan' => 'jumlah_ikm',
    ],

    /* =====================================================================
     | BIDANG PEMBANGUNAN EKONOMI — Sub Bidang Pembangunan Ekonomi II
     * ===================================================================== */

    'pertanian-perkebunan' => [
        'periode' => 'semester',
        'deskripsi' => 'Luas tanam, luas panen, dan produksi komoditas pertanian & perkebunan utama per kecamatan.',
        'fields' => [
            'luas_tanam_padi' => ['label' => 'Luas Tanam Padi', 'tipe' => 'desimal', 'satuan' => 'ha', 'grup' => 'Padi'],
            'luas_panen_padi' => ['label' => 'Luas Panen Padi', 'tipe' => 'desimal', 'satuan' => 'ha', 'grup' => 'Padi'],
            'produksi_padi' => ['label' => 'Produksi Padi (GKG)', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Padi'],
            'produksi_jagung' => ['label' => 'Produksi Jagung', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Palawija'],
            'produksi_kopi' => ['label' => 'Produksi Kopi', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Perkebunan'],
            'produksi_tebu' => ['label' => 'Produksi Tebu', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Perkebunan'],
        ],
        'metrik' => ['luas_panen_padi', 'produksi_padi', 'produksi_jagung', 'produksi_kopi'],
        'tabel' => ['luas_panen_padi', 'produksi_padi', 'produksi_jagung', 'produksi_kopi', 'produksi_tebu'],
        'grafik' => ['produksi_padi', 'produksi_jagung'],
        'ringkasan' => 'produksi_padi',
    ],

    'peternakan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Populasi ternak utama dan produksi susu per kecamatan.',
        'fields' => [
            'sapi_potong' => ['label' => 'Sapi Potong', 'satuan' => 'ekor', 'grup' => 'Populasi Ternak'],
            'sapi_perah' => ['label' => 'Sapi Perah', 'satuan' => 'ekor', 'grup' => 'Populasi Ternak'],
            'kambing_domba' => ['label' => 'Kambing & Domba', 'satuan' => 'ekor', 'grup' => 'Populasi Ternak'],
            'unggas' => ['label' => 'Unggas', 'satuan' => 'ekor', 'grup' => 'Populasi Ternak'],
            'produksi_susu' => ['label' => 'Produksi Susu', 'tipe' => 'desimal', 'satuan' => 'ribu liter', 'grup' => 'Produksi'],
        ],
        'total' => [
            'ternak_besar' => ['label' => 'Total Sapi', 'satuan' => 'ekor', 'dari' => ['sapi_potong', 'sapi_perah']],
        ],
        'metrik' => ['ternak_besar', 'kambing_domba', 'unggas', 'produksi_susu'],
        'tabel' => ['sapi_potong', 'sapi_perah', 'kambing_domba', 'unggas', 'produksi_susu'],
        'grafik' => ['sapi_potong', 'sapi_perah'],
        'ringkasan' => 'ternak_besar',
    ],

    'perikanan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Produksi perikanan tangkap dan budidaya, serta jumlah nelayan dan pembudidaya per kecamatan.',
        'fields' => [
            'produksi_tangkap' => ['label' => 'Produksi Perikanan Tangkap', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Produksi'],
            'produksi_budidaya' => ['label' => 'Produksi Perikanan Budidaya', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Produksi'],
            'nelayan' => ['label' => 'Nelayan', 'satuan' => 'orang', 'grup' => 'Pelaku Usaha'],
            'pembudidaya' => ['label' => 'Pembudidaya Ikan', 'satuan' => 'orang', 'grup' => 'Pelaku Usaha'],
        ],
        'total' => [
            'total_produksi' => ['label' => 'Total Produksi Ikan', 'satuan' => 'ton', 'dari' => ['produksi_tangkap', 'produksi_budidaya']],
        ],
        'metrik' => ['total_produksi', 'produksi_tangkap', 'nelayan', 'pembudidaya'],
        'tabel' => ['produksi_tangkap', 'produksi_budidaya', 'total_produksi', 'nelayan', 'pembudidaya'],
        'grafik' => ['produksi_tangkap', 'produksi_budidaya'],
        'ringkasan' => 'total_produksi',
    ],

    'ketahanan-pangan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Ketersediaan dan kebutuhan beras, serta jumlah desa rawan pangan per kecamatan.',
        'fields' => [
            'ketersediaan_beras' => ['label' => 'Ketersediaan Beras', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Neraca Pangan'],
            'kebutuhan_beras' => ['label' => 'Kebutuhan Beras', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Neraca Pangan'],
            'jumlah_desa' => ['label' => 'Jumlah Desa/Kelurahan', 'satuan' => 'desa', 'grup' => 'Kerawanan Pangan'],
            'desa_rawan_pangan' => ['label' => 'Desa Rawan Pangan', 'satuan' => 'desa', 'grup' => 'Kerawanan Pangan', 'maks' => 'jumlah_desa'],
            'lumbung_pangan' => ['label' => 'Lumbung Pangan Masyarakat', 'satuan' => 'unit', 'grup' => 'Kerawanan Pangan'],
        ],
        'persentase' => [
            'rasio_ketersediaan' => ['label' => 'Rasio Ketersediaan Beras', 'pembilang' => 'ketersediaan_beras', 'penyebut' => 'kebutuhan_beras', 'target' => 100],
            'persen_rawan' => ['label' => 'Desa Rawan Pangan', 'pembilang' => 'desa_rawan_pangan', 'penyebut' => 'jumlah_desa', 'target_maks' => 5],
        ],
        'metrik' => ['ketersediaan_beras', 'kebutuhan_beras', 'rasio_ketersediaan', 'persen_rawan'],
        'tabel' => ['ketersediaan_beras', 'kebutuhan_beras', 'desa_rawan_pangan', 'rasio_ketersediaan', 'persen_rawan'],
        'grafik' => ['ketersediaan_beras', 'kebutuhan_beras'],
        'ringkasan' => 'ketersediaan_beras',
    ],

    /* =====================================================================
     | BIDANG KEMASYARAKATAN — Sub Bidang Kemasyarakatan I
     * ===================================================================== */

    'pendidikan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Satuan pendidikan dasar, jumlah siswa, dan partisipasi sekolah anak usia 7–15 tahun per kecamatan.',
        'fields' => [
            'sekolah_sd' => ['label' => 'SD/MI', 'satuan' => 'sekolah', 'grup' => 'Satuan Pendidikan'],
            'sekolah_smp' => ['label' => 'SMP/MTs', 'satuan' => 'sekolah', 'grup' => 'Satuan Pendidikan'],
            'siswa_sd' => ['label' => 'Siswa SD/MI', 'satuan' => 'siswa', 'grup' => 'Siswa'],
            'siswa_smp' => ['label' => 'Siswa SMP/MTs', 'satuan' => 'siswa', 'grup' => 'Siswa'],
            'anak_7_15' => ['label' => 'Anak Usia 7–15 Tahun', 'satuan' => 'anak', 'grup' => 'Partisipasi Sekolah'],
            'anak_7_15_sekolah' => ['label' => 'Anak 7–15 Tahun yang Bersekolah', 'satuan' => 'anak', 'grup' => 'Partisipasi Sekolah', 'maks' => 'anak_7_15'],
        ],
        'total' => [
            'total_siswa' => ['label' => 'Total Siswa', 'satuan' => 'siswa', 'dari' => ['siswa_sd', 'siswa_smp']],
        ],
        'persentase' => [
            'persen_partisipasi' => ['label' => 'Partisipasi Sekolah 7–15', 'pembilang' => 'anak_7_15_sekolah', 'penyebut' => 'anak_7_15', 'target' => 95],
        ],
        'metrik' => ['sekolah_sd', 'sekolah_smp', 'total_siswa', 'persen_partisipasi'],
        'tabel' => ['sekolah_sd', 'sekolah_smp', 'total_siswa', 'persen_partisipasi'],
        'grafik' => ['siswa_sd', 'siswa_smp'],
        'ringkasan' => 'total_siswa',
    ],

    'kesehatan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Fasilitas kesehatan, prevalensi stunting, serta kematian ibu dan bayi per kecamatan.',
        'fields' => [
            'puskesmas' => ['label' => 'Puskesmas', 'satuan' => 'unit', 'grup' => 'Fasilitas'],
            'posyandu' => ['label' => 'Posyandu Aktif', 'satuan' => 'unit', 'grup' => 'Fasilitas'],
            'balita_diukur' => ['label' => 'Balita Diukur', 'satuan' => 'balita', 'grup' => 'Stunting'],
            'balita_stunting' => ['label' => 'Balita Stunting', 'satuan' => 'balita', 'grup' => 'Stunting', 'maks' => 'balita_diukur'],
            'kematian_ibu' => ['label' => 'Kematian Ibu', 'satuan' => 'kasus', 'grup' => 'Kematian Ibu & Bayi'],
            'kematian_bayi' => ['label' => 'Kematian Bayi', 'satuan' => 'kasus', 'grup' => 'Kematian Ibu & Bayi'],
        ],
        'persentase' => [
            'persen_stunting' => ['label' => 'Prevalensi Stunting', 'pembilang' => 'balita_stunting', 'penyebut' => 'balita_diukur', 'target_maks' => 14],
        ],
        'metrik' => ['puskesmas', 'kematian_ibu', 'kematian_bayi', 'persen_stunting'],
        'tabel' => ['puskesmas', 'posyandu', 'balita_stunting', 'kematian_ibu', 'kematian_bayi', 'persen_stunting'],
        'grafik' => ['balita_stunting'],
        'ringkasan' => 'balita_stunting',
    ],

    'sosial' => [
        'periode' => 'semester',
        'deskripsi' => 'Keluarga dalam data kesejahteraan sosial (DTKS), penerima bantuan, dan PPKS per kecamatan.',
        'fields' => [
            'keluarga_dtks' => ['label' => 'Keluarga Terdaftar DTKS', 'satuan' => 'KK', 'grup' => 'Data Kesejahteraan'],
            'penerima_pkh' => ['label' => 'Penerima PKH', 'satuan' => 'KK', 'grup' => 'Bantuan Sosial', 'maks' => 'keluarga_dtks'],
            'penerima_bpnt' => ['label' => 'Penerima BPNT/Sembako', 'satuan' => 'KK', 'grup' => 'Bantuan Sosial', 'maks' => 'keluarga_dtks'],
            'ppks' => ['label' => 'Pemerlu Pelayanan Kesejahteraan Sosial (PPKS)', 'satuan' => 'jiwa', 'grup' => 'PPKS'],
            'ppks_tertangani' => ['label' => 'PPKS Tertangani', 'satuan' => 'jiwa', 'grup' => 'PPKS', 'maks' => 'ppks'],
        ],
        'persentase' => [
            'persen_ppks_tertangani' => ['label' => 'PPKS Tertangani', 'pembilang' => 'ppks_tertangani', 'penyebut' => 'ppks', 'target' => 80],
        ],
        'metrik' => ['keluarga_dtks', 'penerima_pkh', 'penerima_bpnt', 'persen_ppks_tertangani'],
        'tabel' => ['keluarga_dtks', 'penerima_pkh', 'penerima_bpnt', 'ppks', 'persen_ppks_tertangani'],
        'grafik' => ['penerima_pkh', 'penerima_bpnt'],
        'ringkasan' => 'keluarga_dtks',
    ],

    'tenaga-kerja-transmigrasi' => [
        'periode' => 'tahun',
        'deskripsi' => 'Angkatan kerja, pengangguran, pekerja migran, dan transmigran per kecamatan.',
        'fields' => [
            'angkatan_kerja' => ['label' => 'Angkatan Kerja', 'satuan' => 'orang', 'grup' => 'Ketenagakerjaan'],
            'pengangguran' => ['label' => 'Pengangguran Terbuka', 'satuan' => 'orang', 'grup' => 'Ketenagakerjaan', 'maks' => 'angkatan_kerja'],
            'pencari_kerja_terdaftar' => ['label' => 'Pencari Kerja Terdaftar (AK/1)', 'satuan' => 'orang', 'grup' => 'Ketenagakerjaan'],
            'pekerja_migran' => ['label' => 'Pekerja Migran Indonesia', 'satuan' => 'orang', 'grup' => 'Migrasi'],
            'transmigran' => ['label' => 'Transmigran Diberangkatkan', 'satuan' => 'KK', 'grup' => 'Migrasi'],
        ],
        'persentase' => [
            'tpt' => ['label' => 'Tingkat Pengangguran Terbuka', 'pembilang' => 'pengangguran', 'penyebut' => 'angkatan_kerja', 'target_maks' => 5],
        ],
        'metrik' => ['angkatan_kerja', 'pengangguran', 'pekerja_migran', 'tpt'],
        'tabel' => ['angkatan_kerja', 'pengangguran', 'pekerja_migran', 'transmigran', 'tpt'],
        'grafik' => ['pengangguran', 'pekerja_migran'],
        'ringkasan' => 'angkatan_kerja',
    ],

    /* =====================================================================
     | BIDANG KEMASYARAKATAN — Sub Bidang Kemasyarakatan II
     * ===================================================================== */

    // Rekap angka saja. JANGAN menambah field identitas korban.
    'pppa' => [
        'periode' => 'semester',
        'deskripsi' => 'Rekap jumlah kasus kekerasan terhadap perempuan dan anak serta penanganannya (tanpa data identitas korban).',
        'fields' => [
            'kasus_perempuan' => ['label' => 'Kasus Kekerasan terhadap Perempuan', 'satuan' => 'kasus', 'grup' => 'Kasus'],
            'kasus_anak' => ['label' => 'Kasus Kekerasan terhadap Anak', 'satuan' => 'kasus', 'grup' => 'Kasus'],
            'kasus_ditangani' => ['label' => 'Kasus Mendapat Layanan', 'satuan' => 'kasus', 'grup' => 'Penanganan', 'maks' => 'total_kasus'],
            'kelompok_pkk_aktif' => ['label' => 'Kelompok PKK/PUSPAGA Aktif', 'satuan' => 'kelompok', 'grup' => 'Penanganan'],
        ],
        'total' => [
            'total_kasus' => ['label' => 'Total Kasus', 'satuan' => 'kasus', 'dari' => ['kasus_perempuan', 'kasus_anak']],
        ],
        'persentase' => [
            'persen_ditangani' => ['label' => 'Kasus Mendapat Layanan', 'pembilang' => 'kasus_ditangani', 'penyebut' => 'total_kasus', 'target' => 100],
        ],
        'metrik' => ['total_kasus', 'kasus_perempuan', 'kasus_anak', 'persen_ditangani'],
        'tabel' => ['kasus_perempuan', 'kasus_anak', 'total_kasus', 'persen_ditangani'],
        'grafik' => ['kasus_perempuan', 'kasus_anak'],
        'ringkasan' => 'total_kasus',
    ],

    'keluarga-berencana' => [
        'periode' => 'tahun',
        'deskripsi' => 'Pasangan usia subur, peserta KB aktif, dan Kampung KB per kecamatan.',
        'fields' => [
            'pus' => ['label' => 'Pasangan Usia Subur (PUS)', 'satuan' => 'pasangan', 'grup' => 'Keluarga Berencana'],
            'peserta_kb_aktif' => ['label' => 'Peserta KB Aktif', 'satuan' => 'pasangan', 'grup' => 'Keluarga Berencana', 'maks' => 'pus'],
            'unmet_need' => ['label' => 'Unmet Need', 'satuan' => 'pasangan', 'grup' => 'Keluarga Berencana', 'maks' => 'pus'],
            'kampung_kb' => ['label' => 'Kampung KB', 'satuan' => 'kampung', 'grup' => 'Program'],
        ],
        'persentase' => [
            'persen_kb_aktif' => ['label' => 'Kesertaan KB Aktif (CPR)', 'pembilang' => 'peserta_kb_aktif', 'penyebut' => 'pus', 'target' => 75],
            'persen_unmet' => ['label' => 'Unmet Need', 'pembilang' => 'unmet_need', 'penyebut' => 'pus', 'target_maks' => 10],
        ],
        'metrik' => ['pus', 'peserta_kb_aktif', 'persen_kb_aktif', 'persen_unmet'],
        'tabel' => ['pus', 'peserta_kb_aktif', 'kampung_kb', 'persen_kb_aktif', 'persen_unmet'],
        'grafik' => ['peserta_kb_aktif', 'unmet_need'],
        'ringkasan' => 'peserta_kb_aktif',
    ],

    'kepemudaan-olahraga' => [
        'periode' => 'tahun',
        'deskripsi' => 'Organisasi kepemudaan, sarana olahraga, klub, dan atlet berprestasi per kecamatan.',
        'fields' => [
            'organisasi_pemuda' => ['label' => 'Organisasi Kepemudaan', 'satuan' => 'organisasi', 'grup' => 'Kepemudaan'],
            'karang_taruna_aktif' => ['label' => 'Karang Taruna Aktif', 'satuan' => 'organisasi', 'grup' => 'Kepemudaan'],
            'sarana_olahraga' => ['label' => 'Sarana Olahraga', 'satuan' => 'unit', 'grup' => 'Olahraga'],
            'klub_olahraga' => ['label' => 'Klub Olahraga', 'satuan' => 'klub', 'grup' => 'Olahraga'],
            'atlet_berprestasi' => ['label' => 'Atlet Berprestasi', 'satuan' => 'orang', 'grup' => 'Olahraga'],
        ],
        'metrik' => ['organisasi_pemuda', 'sarana_olahraga', 'klub_olahraga', 'atlet_berprestasi'],
        'tabel' => ['organisasi_pemuda', 'karang_taruna_aktif', 'sarana_olahraga', 'klub_olahraga', 'atlet_berprestasi'],
        'grafik' => ['sarana_olahraga', 'klub_olahraga'],
        'ringkasan' => 'sarana_olahraga',
    ],

    'budaya-pariwisata' => [
        'periode' => 'tahun',
        'deskripsi' => 'Destinasi wisata, kunjungan wisatawan, desa wisata, dan cagar budaya per kecamatan.',
        'fields' => [
            'destinasi_wisata' => ['label' => 'Destinasi Wisata', 'satuan' => 'destinasi', 'grup' => 'Pariwisata'],
            'desa_wisata' => ['label' => 'Desa Wisata', 'satuan' => 'desa', 'grup' => 'Pariwisata'],
            'kunjungan_wisnus' => ['label' => 'Kunjungan Wisatawan Nusantara', 'satuan' => 'kunjungan', 'grup' => 'Kunjungan'],
            'kunjungan_wisman' => ['label' => 'Kunjungan Wisatawan Mancanegara', 'satuan' => 'kunjungan', 'grup' => 'Kunjungan'],
            'cagar_budaya' => ['label' => 'Cagar Budaya', 'satuan' => 'objek', 'grup' => 'Kebudayaan'],
            'sanggar_seni' => ['label' => 'Sanggar Seni', 'satuan' => 'sanggar', 'grup' => 'Kebudayaan'],
        ],
        'total' => [
            'total_kunjungan' => ['label' => 'Total Kunjungan', 'satuan' => 'kunjungan', 'dari' => ['kunjungan_wisnus', 'kunjungan_wisman']],
        ],
        'metrik' => ['destinasi_wisata', 'desa_wisata', 'total_kunjungan', 'cagar_budaya'],
        'tabel' => ['destinasi_wisata', 'desa_wisata', 'total_kunjungan', 'cagar_budaya', 'sanggar_seni'],
        'grafik' => ['kunjungan_wisnus', 'kunjungan_wisman'],
        'ringkasan' => 'total_kunjungan',
    ],

    /* =====================================================================
     | BIDANG SARANA & PRASARANA — Sub Bidang Sarpras I
     * ===================================================================== */

    'proyek-infrastruktur' => [
        'jenis' => 'daftar',
        'deskripsi' => 'Daftar proyek infrastruktur (PUPR) beserta lokasi, sumber dana, anggaran, dan progres.',
        'fields' => [
            'nama_proyek' => ['label' => 'Nama Proyek', 'wajib' => true, 'lebar' => 'penuh', 'grup' => 'Proyek'],
            'kecamatan' => ['label' => 'Lokasi (Kecamatan)', 'tipe' => 'wilayah', 'wajib' => true, 'grup' => 'Proyek'],
            'jenis_proyek' => ['label' => 'Jenis', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Proyek',
                'opsi' => ['Jalan', 'Jembatan', 'Irigasi', 'Air Bersih', 'Drainase', 'Gedung', 'Lainnya']],
            'tahun_anggaran' => ['label' => 'Tahun Anggaran', 'tipe' => 'tahun', 'wajib' => true, 'grup' => 'Anggaran'],
            'sumber_dana' => ['label' => 'Sumber Dana', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Anggaran',
                'opsi' => ['APBN', 'APBD Provinsi', 'APBD Kabupaten', 'Dana Desa', 'Lainnya']],
            'nilai_anggaran' => ['label' => 'Nilai Anggaran', 'tipe' => 'desimal', 'satuan' => 'juta Rp', 'grup' => 'Anggaran'],
            'progres' => ['label' => 'Progres Fisik', 'tipe' => 'persen', 'grup' => 'Pelaksanaan'],
            'status' => ['label' => 'Status', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Pelaksanaan',
                'opsi' => ['Perencanaan', 'Pelaksanaan', 'Selesai', 'Mangkrak']],
        ],
        'tabel' => ['nama_proyek', 'kecamatan', 'jenis_proyek', 'tahun_anggaran', 'nilai_anggaran', 'progres', 'status'],
        'cari' => ['nama_proyek'],
        'filter' => 'status',
        'grafik' => ['kecamatan'],
        'metrik' => [
            ['label' => 'Total Proyek', 'icon' => 'bricks', 'satuan' => 'proyek'],
            ['label' => 'Total Anggaran', 'agregat' => 'sum', 'field' => 'nilai_anggaran', 'icon' => 'cash-stack', 'satuan' => 'juta Rp'],
            ['label' => 'Rata-rata Progres', 'agregat' => 'avg', 'field' => 'progres', 'icon' => 'speedometer2', 'satuan' => '%'],
            ['label' => 'Selesai', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Selesai', 'icon' => 'check2-circle', 'satuan' => 'proyek'],
        ],
    ],

    'perumahan-permukiman' => [
        'periode' => 'tahun',
        'deskripsi' => 'Rumah tidak layak huni (RTLH), kawasan kumuh, dan akses air minum layak per kecamatan.',
        'fields' => [
            'rtlh' => ['label' => 'Rumah Tidak Layak Huni (RTLH)', 'satuan' => 'unit', 'grup' => 'Perumahan'],
            'rtlh_ditangani' => ['label' => 'RTLH Ditangani', 'satuan' => 'unit', 'grup' => 'Perumahan', 'maks' => 'rtlh'],
            'kawasan_kumuh' => ['label' => 'Luas Kawasan Kumuh', 'tipe' => 'desimal', 'satuan' => 'ha', 'grup' => 'Permukiman'],
            'jumlah_kk' => ['label' => 'Jumlah KK', 'satuan' => 'KK', 'grup' => 'Air Minum'],
            'kk_akses_air_minum' => ['label' => 'KK Akses Air Minum Layak', 'satuan' => 'KK', 'grup' => 'Air Minum', 'maks' => 'jumlah_kk'],
        ],
        'persentase' => [
            'persen_rtlh_ditangani' => ['label' => 'RTLH Ditangani', 'pembilang' => 'rtlh_ditangani', 'penyebut' => 'rtlh'],
            'persen_air_minum' => ['label' => 'Akses Air Minum Layak', 'pembilang' => 'kk_akses_air_minum', 'penyebut' => 'jumlah_kk', 'target' => 90],
        ],
        'metrik' => ['rtlh', 'kawasan_kumuh', 'persen_rtlh_ditangani', 'persen_air_minum'],
        'tabel' => ['rtlh', 'rtlh_ditangani', 'kawasan_kumuh', 'persen_rtlh_ditangani', 'persen_air_minum'],
        'grafik' => ['rtlh', 'rtlh_ditangani'],
        'ringkasan' => 'rtlh',
    ],

    'pertanahan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Bidang tanah terdaftar/bersertifikat dan kasus sengketa tanah per kecamatan.',
        'fields' => [
            'bidang_tanah' => ['label' => 'Perkiraan Jumlah Bidang Tanah', 'satuan' => 'bidang', 'grup' => 'Pendaftaran Tanah'],
            'bidang_bersertifikat' => ['label' => 'Bidang Bersertifikat', 'satuan' => 'bidang', 'grup' => 'Pendaftaran Tanah', 'maks' => 'bidang_tanah'],
            'sertifikat_ptsl' => ['label' => 'Sertifikat PTSL Tahun Ini', 'satuan' => 'sertifikat', 'grup' => 'Pendaftaran Tanah'],
            'sengketa_tanah' => ['label' => 'Kasus Sengketa Tanah', 'satuan' => 'kasus', 'grup' => 'Sengketa'],
            'sengketa_selesai' => ['label' => 'Sengketa Terselesaikan', 'satuan' => 'kasus', 'grup' => 'Sengketa', 'maks' => 'sengketa_tanah'],
        ],
        'persentase' => [
            'persen_sertifikat' => ['label' => 'Bidang Bersertifikat', 'pembilang' => 'bidang_bersertifikat', 'penyebut' => 'bidang_tanah', 'target' => 80],
            'persen_sengketa_selesai' => ['label' => 'Sengketa Terselesaikan', 'pembilang' => 'sengketa_selesai', 'penyebut' => 'sengketa_tanah'],
        ],
        'metrik' => ['bidang_bersertifikat', 'sertifikat_ptsl', 'sengketa_tanah', 'persen_sertifikat'],
        'tabel' => ['bidang_tanah', 'bidang_bersertifikat', 'sengketa_tanah', 'persen_sertifikat', 'persen_sengketa_selesai'],
        'grafik' => ['bidang_bersertifikat', 'sertifikat_ptsl'],
        'ringkasan' => 'bidang_bersertifikat',
    ],

    'perhubungan' => [
        'periode' => 'tahun',
        'deskripsi' => 'Panjang dan kondisi jalan, sarana transportasi, dan kejadian kecelakaan per kecamatan.',
        'fields' => [
            'panjang_jalan' => ['label' => 'Panjang Jalan Kabupaten', 'tipe' => 'desimal', 'satuan' => 'km', 'grup' => 'Jalan'],
            'jalan_kondisi_baik' => ['label' => 'Jalan Kondisi Baik/Sedang', 'tipe' => 'desimal', 'satuan' => 'km', 'grup' => 'Jalan', 'maks' => 'panjang_jalan'],
            'terminal' => ['label' => 'Terminal', 'satuan' => 'unit', 'grup' => 'Transportasi'],
            'trayek_angkutan' => ['label' => 'Trayek Angkutan Umum', 'satuan' => 'trayek', 'grup' => 'Transportasi'],
            'kecelakaan' => ['label' => 'Kecelakaan Lalu Lintas', 'satuan' => 'kejadian', 'grup' => 'Keselamatan'],
        ],
        'persentase' => [
            'persen_jalan_mantap' => ['label' => 'Kemantapan Jalan', 'pembilang' => 'jalan_kondisi_baik', 'penyebut' => 'panjang_jalan', 'target' => 70],
        ],
        'metrik' => ['panjang_jalan', 'trayek_angkutan', 'kecelakaan', 'persen_jalan_mantap'],
        'tabel' => ['panjang_jalan', 'jalan_kondisi_baik', 'terminal', 'kecelakaan', 'persen_jalan_mantap'],
        'grafik' => ['jalan_kondisi_baik', 'panjang_jalan'],
        'ringkasan' => 'panjang_jalan',
    ],

    /* =====================================================================
     | BIDANG SARANA & PRASARANA — Sub Bidang Sarpras II
     | (Kawasan Hutan & Lahan Kritis memakai modul lama; tidak di sini)
     * ===================================================================== */

    'lingkungan-hidup' => [
        'periode' => 'tahun',
        'deskripsi' => 'Pengelolaan sampah, bank sampah, ruang terbuka hijau, dan kasus pencemaran per kecamatan.',
        'fields' => [
            'timbulan_sampah' => ['label' => 'Timbulan Sampah', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Persampahan'],
            'sampah_terkelola' => ['label' => 'Sampah Terkelola', 'tipe' => 'desimal', 'satuan' => 'ton', 'grup' => 'Persampahan', 'maks' => 'timbulan_sampah'],
            'bank_sampah' => ['label' => 'Bank Sampah Aktif', 'satuan' => 'unit', 'grup' => 'Persampahan'],
            'luas_rth' => ['label' => 'Luas Ruang Terbuka Hijau', 'tipe' => 'desimal', 'satuan' => 'ha', 'grup' => 'Lingkungan'],
            'kasus_pencemaran' => ['label' => 'Kasus Pencemaran Lingkungan', 'satuan' => 'kasus', 'grup' => 'Lingkungan'],
        ],
        'persentase' => [
            'persen_sampah_terkelola' => ['label' => 'Sampah Terkelola', 'pembilang' => 'sampah_terkelola', 'penyebut' => 'timbulan_sampah', 'target' => 70],
        ],
        'metrik' => ['timbulan_sampah', 'bank_sampah', 'luas_rth', 'persen_sampah_terkelola'],
        'tabel' => ['timbulan_sampah', 'bank_sampah', 'luas_rth', 'kasus_pencemaran', 'persen_sampah_terkelola'],
        'grafik' => ['sampah_terkelola', 'timbulan_sampah'],
        'ringkasan' => 'timbulan_sampah',
    ],

    'esdm' => [
        'periode' => 'tahun',
        'deskripsi' => 'Rasio elektrifikasi, energi terbarukan, penerangan jalan, dan izin pertambangan per kecamatan.',
        'fields' => [
            'rumah_tangga' => ['label' => 'Jumlah Rumah Tangga', 'satuan' => 'RT', 'grup' => 'Kelistrikan'],
            'rumah_tangga_berlistrik' => ['label' => 'Rumah Tangga Berlistrik', 'satuan' => 'RT', 'grup' => 'Kelistrikan', 'maks' => 'rumah_tangga'],
            'pju' => ['label' => 'Penerangan Jalan Umum (PJU)', 'satuan' => 'titik', 'grup' => 'Kelistrikan'],
            'plts_ebt' => ['label' => 'Instalasi Energi Terbarukan (PLTS/Mikrohidro)', 'satuan' => 'unit', 'grup' => 'Energi Terbarukan'],
            'izin_tambang' => ['label' => 'Izin Usaha Pertambangan Aktif', 'satuan' => 'izin', 'grup' => 'Pertambangan'],
            'sumur_bor' => ['label' => 'Sumur Bor Air Tanah', 'satuan' => 'unit', 'grup' => 'Air Tanah'],
        ],
        'persentase' => [
            'rasio_elektrifikasi' => ['label' => 'Rasio Elektrifikasi', 'pembilang' => 'rumah_tangga_berlistrik', 'penyebut' => 'rumah_tangga', 'target' => 100],
        ],
        'metrik' => ['pju', 'plts_ebt', 'izin_tambang', 'rasio_elektrifikasi'],
        'tabel' => ['rumah_tangga', 'pju', 'plts_ebt', 'izin_tambang', 'rasio_elektrifikasi'],
        'grafik' => ['pju'],
        'ringkasan' => 'rumah_tangga_berlistrik',
    ],

    /* =====================================================================
     | KELOMPOK JABATAN FUNGSIONAL
     * ===================================================================== */

    'pejabat-fungsional' => [
        'jenis' => 'daftar',
        'deskripsi' => 'Daftar pejabat fungsional di lingkungan Bakorwil III Malang beserta jenjang dan bidang penugasannya.',
        'fields' => [
            'nama' => ['label' => 'Nama', 'wajib' => true, 'grup' => 'Pegawai'],
            'jabatan' => ['label' => 'Jabatan Fungsional', 'wajib' => true, 'grup' => 'Pegawai', 'contoh' => 'Analis Kebijakan, Perencana, …'],
            'jenjang' => ['label' => 'Jenjang', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Pegawai',
                'opsi' => ['Terampil', 'Mahir', 'Penyelia', 'Ahli Pertama', 'Ahli Muda', 'Ahli Madya', 'Ahli Utama']],
            'pangkat_golongan' => ['label' => 'Pangkat/Golongan', 'grup' => 'Pegawai', 'contoh' => 'Penata / III-c'],
            'bidang_penugasan' => ['label' => 'Bidang Penugasan', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Penugasan', 'opsi' => $bidangLabel],
            'tmt_jabatan' => ['label' => 'TMT Jabatan', 'tipe' => 'tanggal', 'grup' => 'Penugasan'],
            'status' => ['label' => 'Status', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Penugasan',
                'opsi' => ['Aktif', 'Tugas Belajar', 'Purna Tugas']],
        ],
        'tabel' => ['nama', 'jabatan', 'jenjang', 'bidang_penugasan', 'status'],
        'cari' => ['nama', 'jabatan'],
        'filter' => 'bidang_penugasan',
        'grafik' => ['jenjang'],
        'metrik' => [
            ['label' => 'Total Pejabat Fungsional', 'icon' => 'person-badge', 'satuan' => 'orang'],
            ['label' => 'Aktif', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Aktif', 'icon' => 'check2-circle', 'satuan' => 'orang'],
            ['label' => 'Jenjang Ahli Madya', 'agregat' => 'hitung', 'field' => 'jenjang', 'nilai' => 'Ahli Madya', 'icon' => 'award', 'satuan' => 'orang'],
        ],
    ],

    'kajian-analisis' => [
        'jenis' => 'daftar',
        'deskripsi' => 'Daftar dokumen kajian dan analisis kebijakan beserta bidang terkait, penyusun, dan statusnya.',
        'fields' => [
            'judul' => ['label' => 'Judul Kajian', 'wajib' => true, 'lebar' => 'penuh', 'grup' => 'Kajian'],
            'tahun' => ['label' => 'Tahun', 'tipe' => 'tahun', 'wajib' => true, 'grup' => 'Kajian'],
            'bidang_terkait' => ['label' => 'Bidang Terkait', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Kajian', 'opsi' => $bidangLabel],
            'penyusun' => ['label' => 'Penyusun', 'grup' => 'Kajian'],
            'status' => ['label' => 'Status', 'tipe' => 'pilihan', 'wajib' => true, 'grup' => 'Kajian',
                'opsi' => ['Rencana', 'Proses', 'Selesai']],
            'ringkasan' => ['label' => 'Ringkasan / Rekomendasi', 'tipe' => 'teks_panjang', 'grup' => 'Isi'],
        ],
        'tabel' => ['judul', 'tahun', 'bidang_terkait', 'penyusun', 'status'],
        'cari' => ['judul', 'penyusun', 'ringkasan'],
        'filter' => 'bidang_terkait',
        'grafik' => ['bidang_terkait'],
        'metrik' => [
            ['label' => 'Total Kajian', 'icon' => 'journal-text', 'satuan' => 'dokumen'],
            ['label' => 'Selesai', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Selesai', 'icon' => 'check2-circle', 'satuan' => 'dokumen'],
            ['label' => 'Dalam Proses', 'agregat' => 'hitung', 'field' => 'status', 'nilai' => 'Proses', 'icon' => 'hourglass-split', 'satuan' => 'dokumen'],
        ],
    ],

];
