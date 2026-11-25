"""
Tambahan data resmi BPS ke bps-malang-selatan-2025.json:
  - Sarana perdagangan per desa (Kecamatan Dalam Angka, Tabel 7.6)  -> perdagangan-industri
  - Puskesmas pembantu (Kecamatan Dalam Angka, Tabel 4.2.2)          -> kesehatan.pustu
  - Pekerja migran (Kabupaten Malang Dalam Angka 2026, Tabel 3.2.11) -> tenaga-kerja-transmigrasi
Data kecamatan edisi 2025 (Tirtoyudo, data 2024) disimpan pada tahun 2024, bukan 2025.
"""
import json, re
from ext import baris, items, angka, KEC
from extract_all import per_desa, halaman, FILE, sama

out = json.load(open('bps-malang-selatan-2025.json', encoding='utf-8'))
log = out['catatan_verifikasi']
lain = out.setdefault('kecamatan_tahun_lain', {})


def taruh(kec, tahun, modul, nilai, tabel):
    if tahun == out['tahun']:
        out['kecamatan'][kec].setdefault(modul, {}).update(nilai)
    else:
        lain.setdefault(str(tahun), {}).setdefault(kec, {}).setdefault(modul, {}).update(nilai)
    out['sumber_tabel'].setdefault(modul, [])
    if tabel not in out['sumber_tabel'][modul]:
        out['sumber_tabel'][modul].append(tabel)


def nilai_label(fn, page, label):
    """Nilai kolom terakhir (tahun terbaru) pada baris berlabel teks, mis. 'Puskesmas Pembantu'."""
    it = items(fn, page)
    ys = [y for x, y, t in it if t.strip() == label and x < 120]
    if not ys:
        return None
    y0 = ys[0]
    vals = sorted((x, angka(t)) for x, y, t in it if x > 150 and abs(y - y0) <= 14 and y <= y0 + 2 and angka(t) is not None)
    # nilai tercetak satu baris di bawah label; ambil baris terdekat di bawah label
    baris_y = sorted({round(y, 1) for x, y, t in it if x > 150 and angka(t) is not None and 0 <= y0 - y <= 14})
    if not baris_y:
        return None
    yb = max(baris_y)
    vals = sorted((x, angka(t)) for x, y, t in it if x > 150 and abs(y - yb) < 1 and angka(t) is not None)
    return vals[-1][1] if vals else None


for kec, f in FILE.items():
    fn = f + '.pdf'
    edisi = out['publikasi_kecamatan'][kec]
    tahun = edisi - 1
    sumber = f'Kecamatan {kec} Dalam Angka {edisi}'

    # --- Sarana perdagangan (Tabel 7.6, dua halaman)
    p1 = halaman(fn, 'Tabel', 'Sarana Perdagangan Menurut Desa', 'Kelompok Pertokoan')
    p2 = p1 + 1
    a, ta = per_desa(fn, p1)
    b, tb = per_desa(fn, p2)
    ok = len(ta) == 3 and len(tb) == 3
    for i, t in enumerate(ta if ok else []):
        ok = ok and sama(sum(v[i] for v in a.values() if len(v) == 3), t)
    for i, t in enumerate(tb if ok else []):
        ok = ok and sama(sum(v[i] for v in b.values() if len(v) == 3), t)
    if not ok:
        log.append(f'[GAGAL CEK] perdagangan {kec}: {ta} {tb}')
    else:
        taruh(kec, tahun, 'perdagangan-industri', {
            'kelompok_pertokoan': ta[0], 'pasar_permanen': ta[1], 'pasar_semi_permanen': ta[2],
            'pasar_tanpa_bangunan': tb[0], 'minimarket': tb[1], 'restoran': tb[2],
        }, f'{sumber} (Tabel 7.6)')

    # --- Puskesmas pembantu (Tabel 4.2.2), hanya bila tahunnya sama dengan data utama
    p = halaman(fn, 'Tabel', 'Banyaknya Sarana Kesehatan Menurut Jenis')
    v = nilai_label(fn, p, 'Puskesmas Pembantu')
    if v is None:
        log.append(f'[KOSONG] pustu {kec}')
    elif tahun == out['tahun']:
        taruh(kec, tahun, 'kesehatan', {'pustu': v}, f'{sumber} (Tabel 4.2.2)')
    else:
        log.append(f'[TAHUN BERBEDA] pustu {kec}: {v} unit (data {tahun}) tidak dimasukkan ke 2025')

# --- Pekerja migran (Tabel 3.2.11, tiga halaman: jumlah seluruh negara penempatan)
rows = [baris('KabMalang2026.pdf', p)[0] for p in (170, 171, 172)]
kab_total = sum(sum(r.get('KAB') or []) for r in rows)
for kode, kec in KEC.items():
    tot = sum(sum(r.get(kode) or []) for r in rows)
    taruh(kec, out['tahun'], 'tenaga-kerja-transmigrasi', {'pekerja_migran': tot}, 'Tabel 3.2.11')
log.append(f'[INFO] Pekerja migran = jumlah seluruh negara penempatan (Kab. Malang total {kab_total:.0f}).')

json.dump(out, open('bps-malang-selatan-2025.json', 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
print('\n'.join(l for l in log if not l.startswith('[CEK SILANG]')))
for kec in ('Dampit', 'Tirtoyudo'):
    print(kec, out['kecamatan'][kec].get('perdagangan-industri'), out['kecamatan'][kec].get('kesehatan', {}).get('pustu'),
          out['kecamatan'][kec]['tenaga-kerja-transmigrasi'])
print('lain:', json.dumps(lain, ensure_ascii=False))
