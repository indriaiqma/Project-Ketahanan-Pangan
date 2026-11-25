# Data Resmi BPS — 9 Kecamatan Malang Selatan

File [`../bps-malang-selatan-2025.json`](../bps-malang-selatan-2025.json) berisi data resmi yang diimpor ke aplikasi dengan:

```bash
php artisan data:bps
```

## Sumber

| Publikasi | Data | Tautan |
|---|---|---|
| BPS Kabupaten Malang, *Kabupaten Malang Dalam Angka 2026* | Tahun 2025, per kecamatan | [malangkab.bps.go.id](https://malangkab.bps.go.id/id/publication/2026/02/27/3e4ad4dd423b017bdf8a76c7/kabupaten-malang-dalam-angka-2026.html) |
| BPS Kabupaten Malang, *Kecamatan … Dalam Angka 2026* (8 kecamatan) | Tahun 2025, per desa | halaman publikasi BPS Kabupaten Malang |
| BPS Kabupaten Malang, *Kecamatan Tirtoyudo Dalam Angka 2025* | Tahun 2024, per desa | edisi 2026 belum tersedia saat data diambil |

Nomor tabel sumber setiap modul tercatat di kunci `sumber_tabel` dan ikut tersimpan di kolom **Sumber Data** setiap baris.

## Cara ekstraksi

PDF BPS diunduh dari situs resmi, lalu tabelnya dibaca berdasarkan posisi teks (watermark miring dibuang) dengan [`ext.py`](ext.py) dan [`extract_all.py`](extract_all.py) (Python + `pypdf` + `cryptography`).

## Verifikasi

Setiap tabel diperiksa sebelum dipakai. Nilai yang gagal diperiksa **tidak diisi** (kosong, tampil "–"):

- negeri + swasta = jumlah (sekolah, guru, murid);
- jumlah per metode KB = total peserta KB aktif;
- karang taruna per klasifikasi = jumlah karang taruna;
- luas panen × produktivitas ≈ produksi (padi, jagung, ubi kayu);
- rumah tangga perikanan laut + perairan umum = jumlah; komponen budidaya = jumlah;
- jumlah per desa = total kecamatan (luas, dusun, RW, RT, penduduk L/P);
- laki-laki + perempuan = jumlah penduduk per desa;
- total penduduk kecamatan (publikasi kecamatan) = Tabel 3.1.1 publikasi kabupaten.

Catatan dari verifikasi (lihat `catatan_verifikasi` di file JSON):

- Produksi perikanan budidaya **Kalipare** dan **Tirtoyudo** dikosongkan karena jumlah di tabel BPS tidak sama dengan komponennya.
- Produksi perikanan **tangkap** tidak dipakai: tabel 5.5.2 pada PDF tercetak bergeser (baris Sumbermanjing Wetan hilang, kolom 2025 tidak konsisten).
- Data **akta kelahiran** (Tabel 3.1.4) tidak dipakai karena kolomnya tercetak bergeser antarbaris.
- **Tirtoyudo**: total penduduk 2025 dari Tabel 3.1.1; rincian laki-laki/perempuan 2025 tidak tersedia, dan data per desa memakai tahun 2024.

## Yang tidak tersedia di BPS tingkat kecamatan

Antara lain status IDM desa, kasus kekerasan PPPA, ormas, nilai investasi, stunting, RTLH, sengketa tanah, serta daftar nama sekolah/fasilitas per lokasi. Kolom-kolom ini dibiarkan kosong untuk diisi petugas dari sumber resmi masing-masing OPD.
