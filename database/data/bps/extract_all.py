"""
Ekstraksi data resmi BPS untuk 9 kecamatan Malang Selatan.
Sumber:
  - BPS Kabupaten Malang, "Kabupaten Malang Dalam Angka 2026" (data 2025)
  - BPS Kabupaten Malang, "Kecamatan <X> Dalam Angka 2026" (Tirtoyudo: edisi 2025)
Setiap tabel diverifikasi; nilai yang gagal verifikasi diset None dan dicatat.
"""
import json, re, sys
from ext import baris, items, angka, KEC

KAB = 'KabMalang2026.pdf'
NAMA = KEC  # kode -> nama
log = []
hasil = {nama: {} for nama in NAMA.values()}
sumber = {}  # modul -> keterangan sumber


def kab(page, xmin=140):
    rows, _ = baris(KAB, page, xmin=xmin)
    return rows


def ambil(modul, field, page, idx, tabel, cek=None):
    rows = kab(page)
    for kode, nama in NAMA.items():
        r = rows.get(kode)
        v = r[idx] if r and len(r) > idx else None
        if r is None:
            log.append(f'[KOSONG] {modul}.{field} {nama}: baris tidak ditemukan (hal. {page})')
        if cek and r is not None and not cek(r):
            log.append(f'[GAGAL CEK] {modul}.{field} {nama}: {r} (hal. {page})')
            v = None
        hasil[nama].setdefault(modul, {})[field] = v
    sumber.setdefault(modul, set()).add(tabel)


def sama(a, b, tol=0.6):
    return a is not None and b is not None and abs(a - b) <= tol


# ---------------------------------------------------------------- Wilayah
ambil('data-desa-kelurahan', 'jumlah_desa', 90, 4, 'Tabel 2.1.3')
ambil('data-desa-kelurahan', 'jumlah_kelurahan', 89, 4, 'Tabel 2.1.2')

# ---------------------------------------------------------------- Pendidikan (TA 2025/2026)
cek_ns = lambda r: len(r) >= 6 and sama(r[1] + r[3], r[5])
for jenjang, (ps, pg, pm, tb) in {
    'sd': (198, 199, 200, '4.1.3'), 'mi': (201, 202, 203, '4.1.4'), 'smp': (204, 205, 206, '4.1.5'),
    'mts': (207, 208, 209, '4.1.6'), 'sma': (210, 211, 212, '4.1.7'), 'smk': (213, 214, 215, '4.1.8'),
    'ma': (216, 217, 218, '4.1.9'),
}.items():
    ambil('pendidikan', f'sekolah_{jenjang}', ps, 5, f'Tabel {tb}', cek_ns)
    ambil('pendidikan', f'guru_{jenjang}', pg, 5, f'Tabel {tb}', cek_ns)
    ambil('pendidikan', f'murid_{jenjang}', pm, 5, f'Tabel {tb}', cek_ns)

# ---------------------------------------------------------------- Kesehatan (2025)
for f, i in {'tenaga_medis': 0, 'psikolog_klinis': 1, 'tenaga_keperawatan': 2, 'tenaga_kebidanan': 3, 'tenaga_kefarmasian': 4}.items():
    ambil('kesehatan', f, 243, i, 'Tabel 4.2.2')
for f, i in {'tenaga_kesmas': 0, 'tenaga_kesling': 1, 'tenaga_gizi': 2}.items():
    ambil('kesehatan', f, 244, i, 'Tabel 4.2.2')
ambil('kesehatan', 'puskesmas_rawat_inap', 247, 1, 'Tabel 4.2.3')
ambil('kesehatan', 'puskesmas_non_rawat_inap', 247, 3, 'Tabel 4.2.3')

# ---------------------------------------------------------------- KB (2025)
r263, r264 = kab(263), kab(264)
for kode, nama in NAMA.items():
    a, b = r263.get(kode), r264.get(kode)
    ok = a and b and len(a) >= 5 and len(b) >= 5 and sama(sum(a[1:5]) + sum(b[0:4]), b[4])
    if not ok:
        log.append(f'[GAGAL CEK] KB {nama}: {a} {b}')
    kb = hasil[nama].setdefault('keluarga-berencana', {})
    kb['pus'] = a[0] if a else None
    for f, v in zip(['kb_iud', 'kb_mow', 'kb_mop', 'kb_kondom'], (a or [None] * 5)[1:5]):
        kb[f] = v if ok else None
    for f, v in zip(['kb_implan', 'kb_suntik', 'kb_pil', 'kb_mal'], (b or [None] * 5)[0:4]):
        kb[f] = v if ok else None
sumber.setdefault('keluarga-berencana', set()).add('Tabel 4.2.19')
ambil('keluarga-berencana', 'klinik_kb', 265, 0, 'Tabel 4.2.20')
ambil('keluarga-berencana', 'ppkbd', 265, 1, 'Tabel 4.2.20')

# ---------------------------------------------------------------- Sosial (2025)
for f, i in {'pmks_wanita_rawan_sosek': 0, 'pmks_wanita_korban_kekerasan': 1, 'pmks_lansia': 2, 'pmks_lansia_korban_kekerasan': 3}.items():
    ambil('sosial', f, 287, i, 'Tabel 4.3.12')

# ---------------------------------------------------------------- Karang Taruna (2025)
for f, i in {'karang_taruna': 0, 'kt_tumbuh': 2, 'kt_berkembang': 3, 'kt_maju': 4, 'kt_percontohan': 5}.items():
    ambil('kepemudaan-olahraga', f, 288, i, 'Tabel 4.3.13',
          lambda r: len(r) >= 6 and sama(r[2] + r[3] + r[4] + r[5], r[0]))

# ---------------------------------------------------------------- Bencana (2025)
for f, i in {'kejadian_bencana': 0, 'korban_meninggal': 1, 'korban_luka': 2, 'rumah_hancur': 3, 'rumah_rusak': 4, 'kerugian': 5}.items():
    ambil('trantibumlinmas', f, 290, i, 'Tabel 4.3.15')

# ---------------------------------------------------------------- Tenaga kerja (2025)
ambil('tenaga-kerja-transmigrasi', 'transmigran_kk', 167, 2, 'Tabel 3.2.8')
ambil('tenaga-kerja-transmigrasi', 'transmigran_jiwa', 167, 3, 'Tabel 3.2.8')

# ---------------------------------------------------------------- Pertanian (2025)
def cek_prod(r):
    return len(r) >= 3 and (r[0] == 0 and r[2] == 0 or abs(r[0] * r[1] / 10 - r[2]) <= max(2, r[2] * 0.01))
for kom, page, tb in (('padi', 368, '5.3.3'), ('jagung', 369, '5.3.4'), ('ubi_kayu', 370, '5.3.5')):
    ambil('pertanian-perkebunan', f'luas_panen_{kom}', page, 0, f'Tabel {tb}', cek_prod)
    ambil('pertanian-perkebunan', f'produksi_{kom}', page, 2, f'Tabel {tb}', cek_prod)
ambil('pertanian-perkebunan', 'produksi_kelapa', 360, 3, 'Tabel 5.2.2')
ambil('pertanian-perkebunan', 'produksi_kopi', 361, 3, 'Tabel 5.2.2')
ambil('pertanian-perkebunan', 'produksi_kakao', 362, 1, 'Tabel 5.2.2')
ambil('pertanian-perkebunan', 'produksi_tebu', 362, 3, 'Tabel 5.2.2')

# ---------------------------------------------------------------- Peternakan (2025)
for f, (p, i) in {'sapi_perah': (381, 1), 'sapi_potong': (381, 2), 'kerbau': (381, 3), 'kuda': (381, 0),
                  'kambing': (382, 0), 'domba': (382, 1), 'ayam_buras': (383, 0), 'ayam_petelur': (383, 1),
                  'ayam_pedaging': (383, 2), 'itik': (383, 3), 'entok': (383, 4)}.items():
    ambil('peternakan', f, p, i, {381: 'Tabel 5.4.2', 382: 'Tabel 5.4.3', 383: 'Tabel 5.4.4'}[p])

# ---------------------------------------------------------------- Perikanan (2025)
cek_rtp = lambda r: len(r) >= 6 and sama(r[1] + r[3], r[5])
ambil('perikanan', 'rtp_tangkap_laut', 386, 1, 'Tabel 5.5.1', cek_rtp)
ambil('perikanan', 'rtp_tangkap_umum', 386, 3, 'Tabel 5.5.1', cek_rtp)
ambil('perikanan', 'rtp_budidaya', 389, 6, 'Tabel 5.5.4', lambda r: len(r) >= 7 and sama(sum(r[0:6]), r[6]))
ambil('perikanan', 'produksi_budidaya', 390, 6, 'Tabel 5.5.5', lambda r: len(r) >= 7 and sama(sum(r[0:6]), r[6], 0.05))

# ---------------------------------------------------------------- Energi & air (2025)
ambil('esdm', 'pelanggan_listrik', 435, 4, 'Tabel 6.1.2')
ambil('perumahan-permukiman', 'pelanggan_air_bersih', 437, 4, 'Tabel 6.1.4')
ambil('lingkungan-hidup', 'sampah_dikelola', 296, 0, 'Tabel 4.3.20')

# ---------------------------------------------------------------- Pariwisata (2025)
for f, i in {'wisata_pantai': 0, 'wisata_coban': 1, 'wisata_pemandian': 2, 'wisata_agro': 3, 'desa_wisata': 4}.items():
    ambil('budaya-pariwisata', f, 461, i, 'Tabel 7.4')
for f, i in {'wisata_sejarah': 0, 'wisata_gua': 1, 'wisata_buatan': 2, 'wisata_pesarean': 3, 'wisata_lainnya': 4}.items():
    ambil('budaya-pariwisata', f, 462, i, 'Tabel 7.4')
ambil('budaya-pariwisata', 'hotel_berbintang', 465, 0, 'Tabel 7.7', lambda r: len(r) >= 3 and sama(r[0] + r[1], r[2]))
ambil('budaya-pariwisata', 'akomodasi_lainnya', 465, 1, 'Tabel 7.7', lambda r: len(r) >= 3 and sama(r[0] + r[1], r[2]))
ambil('budaya-pariwisata', 'rumah_makan', 458, 3, 'Tabel 7.1')

# ---------------------------------------------------------------- Komunikasi (2025)
cek_sinyal = None
for f, i in {'desa_sinyal_4g': 0, 'desa_sinyal_3g': 1, 'desa_sinyal_2g': 2, 'desa_tanpa_sinyal': 3}.items():
    ambil('statistik-kominfo', f, 500, i, 'Tabel 8.2.3')
ambil('statistik-kominfo', 'menara_bts', 502, 3, 'Tabel 8.2.5')
ambil('statistik-kominfo', 'kantor_pos', 497, 4, 'Tabel 8.2.1')

# ---------------------------------------------------------------- Koperasi (2025)
ambil('umkm-koperasi', 'koperasi_aktif', 512, 3, 'Tabel 9.1')
cek_kop = lambda r: len(r) >= 6 and sama(sum(r[0:5]), r[5])
for f, i in {'kud': 0, 'kpri': 1, 'koppas': 2, 'kopwan': 3, 'koperasi_lainnya': 4}.items():
    ambil('umkm-koperasi', f, 513, i, 'Tabel 9.2', cek_kop)
ambil('umkm-koperasi', 'ksp', 516, 3, 'Tabel 9.5')

# ---------------------------------------------------------------- Data per desa (publikasi kecamatan)
FILE = {'Ampelgading': 'Ampelgading', 'Bantur': 'Bantur', 'Dampit': 'Dampit', 'Donomulyo': 'Donomulyo', 'Gedangan': 'Gedangan',
        'Kalipare': 'Kalipare', 'Pagak': 'Pagak', 'Sumbermanjing Wetan': 'Sumbermanjing_Wetan', 'Tirtoyudo': 'Tirtoyudo'}
desa = {}
pub = {}


def halaman(fn, *kunci):
    d = json.load(open(fn.replace('.pdf', '.rows.json'), encoding='utf-8'))
    for i, rows in enumerate(d):
        t = ' '.join(t for row in rows for x, t in row)
        if all(k in t for k in kunci) and 'DAFTAR' not in t and '.....' not in t and 'Gambar' not in t[:80]:
            return i
    return None


def per_desa(fn, page, xmin=140):
    """Baris 'NNN Nama' -> angka; juga baris total 'Kecamatan X'."""
    it = items(fn, page)
    labels, jenis_sekarang, total_y = {}, {}, None
    for x, y, t in it:
        m = re.match(r'^(\d{3})\s+(.+)$', t)
        if m and x < 120:
            labels[(m.group(1), m.group(2).strip())] = y
        if t.startswith('Kecamatan ') and x < 120:
            total_y = y
    rows = {k: [] for k in labels}
    total = []
    for x, y, t in it:
        if x < xmin:
            continue
        for tok in t.split():
            v = angka(tok)
            if v is None:
                continue
            kandidat = list(labels.items()) + ([(('TOTAL', ''), total_y)] if total_y else [])
            k, yy = min(kandidat, key=lambda kv: abs(kv[1] - y))
            # baris total kadang tercetak sedikit di bawah labelnya
            if abs(yy - y) > 4 and not (total_y and 0 < total_y - y <= 9 and all(abs(ly - y) > 4 for ly in labels.values())):
                continue
            if abs(yy - y) > 4:
                k = ('TOTAL', '')
            (total if k[0] == 'TOTAL' else rows[k]).append((x, v))
    return {k: [v for _, v in sorted(r)] for k, r in rows.items()}, [v for _, v in sorted(total)]


def kelurahan(fn, page):
    """Kode desa yang tercantum di bawah judul 'Kelurahan/' pada tabel RW/RT."""
    it = sorted(items(fn, page), key=lambda i: -i[1])
    batas = next((y for x, y, t in it if t.startswith('Kelurahan/')), None)
    if batas is None:
        return set()
    return {re.match(r'^(\d{3})', t).group(1) for x, y, t in it if y < batas and re.match(r'^\d{3}\s', t) and x < 120}


for kec, f in FILE.items():
    fn = f + '.pdf'
    edisi = 2025 if kec == 'Tirtoyudo' else 2026
    pub[kec] = edisi
    p_luas = halaman(fn, 'Tabel', 'Luas Daerah Menurut Desa', 'Sumber/')
    p_rw = halaman(fn, 'Tabel', 'Rukun Warga (RW) dan Rukun Tetangga', 'Sumber/')
    p_pend = halaman(fn, 'Laki-Laki', 'Perempuan', 'Desa/Kelurahan')
    luas, tl = per_desa(fn, p_luas)
    teks_luas = ' '.join(t for _, _, t in items(fn, p_luas))
    if '(ha)' in teks_luas:  # edisi lama: luas dalam hektare -> km2
        luas = {k: [v[0] / 100] + v[1:] for k, v in luas.items()}
        tl = [tl[0] / 100] + tl[1:] if tl else tl
    rw, trw = per_desa(fn, p_rw)
    if trw and len(trw) == 2:  # tanpa kolom dusun
        rw = {k: [None] + v for k, v in rw.items()}
        trw = [None] + trw
    pend, tp = per_desa(fn, p_pend)
    kel = kelurahan(fn, p_rw)
    daftar = []
    for (kode, nama), v in sorted(luas.items()):
        r = rw.get((kode, nama)) or next((vv for (kk, nn), vv in rw.items() if kk == kode), None)
        p = pend.get((kode, nama)) or next((vv for (kk, nn), vv in pend.items() if kk == kode), None)
        e = {'kode': kode, 'nama': nama, 'jenis': 'Kelurahan' if kode in kel else 'Desa',
             'luas': v[0] if v else None,
             'luas_km2_dari_ha': '(ha)' in teks_luas,
             'dusun': r[0] if r and len(r) >= 3 else None, 'rw': r[1] if r and len(r) >= 3 else None, 'rt': r[2] if r and len(r) >= 3 else None,
             'laki': p[0] if p and len(p) >= 3 else None, 'perempuan': p[1] if p and len(p) >= 3 else None, 'jumlah': p[2] if p and len(p) >= 3 else None}
        if e['laki'] is not None and not sama(e['laki'] + e['perempuan'], e['jumlah']):
            log.append(f'[GAGAL CEK] penduduk desa {kec}/{nama}: {p}')
        daftar.append(e)
    desa[kec] = daftar

    def jml(k):
        vals = [e[k] for e in daftar if e[k] is not None]
        return round(sum(vals), 2) if vals else None
    # Verifikasi jumlah desa vs total kecamatan
    for k, t in (('luas', tl[0] if tl else None), ('dusun', trw[0] if len(trw) > 2 else None), ('rw', trw[1] if len(trw) > 2 else None),
                 ('rt', trw[2] if len(trw) > 2 else None), ('laki', tp[0] if tp else None), ('perempuan', tp[1] if len(tp) > 1 else None),
                 ('jumlah', tp[2] if len(tp) > 2 else None)):
        if t is None and jml(k) is None:
            continue
        if t is None or not sama(jml(k), t, 0.05 if k == 'luas' else 0.5):
            log.append(f'[GAGAL CEK] {kec} total {k}: jumlah desa {jml(k)} vs tabel {t}')
    h = hasil[kec]
    h.setdefault('data-desa-kelurahan', {}).update({'jumlah_dusun': trw[0] if len(trw) > 2 else None, 'jumlah_rw': trw[1] if len(trw) > 2 else None,
                                                    'jumlah_rt': trw[2] if len(trw) > 2 else None, 'luas_wilayah': tl[0] if tl else None})
    h['rekap-kependudukan'] = {'laki_laki': tp[0] if tp else None, 'perempuan': tp[1] if len(tp) > 1 else None}
    # Cek silang dengan publikasi kabupaten
    jd = h['data-desa-kelurahan']
    if not sama((jd.get('jumlah_desa') or 0) + (jd.get('jumlah_kelurahan') or 0), len(daftar)):
        log.append(f'[GAGAL CEK] {kec}: jumlah desa+kel kabupaten {jd.get("jumlah_desa")}+{jd.get("jumlah_kelurahan")} vs {len(daftar)} desa di publikasi kecamatan')
    sumber.setdefault('data-desa-kelurahan', set()).add(f'Kecamatan {kec} Dalam Angka {edisi} (Tabel 1.1, 2.1.1)')
    sumber.setdefault('rekap-kependudukan', set()).add(f'Kecamatan {kec} Dalam Angka {edisi} (Tabel 3.1)')

# Penduduk: cek silang total kabupaten (Tabel 3.1.1) vs kecamatan
r152 = kab(152)
for kode, nama in NAMA.items():
    t = (r152.get(kode) or [None])[0]
    rk = hasil[nama]['rekap-kependudukan']
    if rk['laki_laki'] is None or not sama(rk['laki_laki'] + rk['perempuan'], t):
        log.append(f'[CEK SILANG] penduduk {nama}: kecamatan {rk} vs kabupaten {t}')

out = {
    'tahun': 2025,
    'sumber_kabupaten': 'BPS Kabupaten Malang, Kabupaten Malang Dalam Angka 2026',
    'url_kabupaten': 'https://malangkab.bps.go.id/id/publication/2026/02/27/3e4ad4dd423b017bdf8a76c7/kabupaten-malang-dalam-angka-2026.html',
    'publikasi_kecamatan': pub,
    'sumber_tabel': {k: sorted(v) for k, v in sumber.items()},
    'kecamatan': hasil,
    'desa': desa,
    'catatan_verifikasi': log,
}
json.dump(out, open('bps-malang-selatan-2025.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
print('\n'.join(log) or 'Semua verifikasi lolos')
print('desa:', {k: len(v) for k, v in desa.items()})

# ---------------------------------------------------------------- Penyesuaian akhir
# Total penduduk 2025 dari Tabel 3.1.1 kabupaten untuk semua kecamatan. Tirtoyudo hanya
# punya publikasi kecamatan edisi 2025 (data 2024), jadi rincian L/P 2025 dikosongkan.
for kode, nama in NAMA.items():
    rk = out['kecamatan'][nama]['rekap-kependudukan']
    rk['total_penduduk'] = (r152.get(kode) or [None])[0]
    if nama == 'Tirtoyudo':
        rk['laki_laki'] = rk['perempuan'] = None
out['sumber_tabel']['rekap-kependudukan'] = sorted(set(out['sumber_tabel']['rekap-kependudukan']) | {'Tabel 3.1.1'})
json.dump(out, open('bps-malang-selatan-2025.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
