"""Normalisasi hasil ambil Data Referensi Pendidikan -> database/data/sekolah-malang-selatan.json"""
import json, sys, re
from collections import Counter

src, dst, diakses = sys.argv[1], sys.argv[2], sys.argv[3]
d = json.load(open(src, encoding='utf-8'))
AKR = {'A': 'A', 'B': 'B', 'C': 'C', 'TT': 'Belum Terakreditasi', 'TIDAK TERAKREDITASI': 'Belum Terakreditasi', 'BELUM TERAKREDITASI': 'Belum Terakreditasi'}

out, tidak_aktif = [], []
for s in sorted(d.values(), key=lambda s: (s['kecamatan'], s['desa'], s['bentuk'], s['nama'])):
    aktif = (s.get('status_aktif') or '').replace('Indikator', '').strip()
    if s.get('detail') and aktif and aktif != 'Aktif':
        tidak_aktif.append(s['npsn'])
        continue
    akr = (s.get('akreditasi') or '').strip().upper()
    luas = s.get('luas_tanah')
    try:
        luas = float(luas.replace('.', '').replace(',', '.')) if luas else None
    except ValueError:
        luas = None
    lat, lon = s.get('lintang'), s.get('bujur')
    koordinat = f'{float(lat):.6f}, {float(lon):.6f}' if lat and lon and float(lat) != 0 and float(lon) != 0 else None
    internet = (s.get('internet') or '').strip()
    internet = None if internet in ('', '-') else internet
    out.append({
        'npsn': s['npsn'],
        'nama': re.sub(r'\s+', ' ', s['nama']).strip(),
        'jenjang': s['bentuk'],
        'status': s['status'].title(),
        'kecamatan': s['kecamatan'],
        'desa': s['desa'].strip().title() if s['desa'].isupper() else s['desa'].strip(),
        'alamat': re.sub(r'\s+', ' ', s['alamat']).strip() or None,
        'akreditasi': AKR.get(akr) if akr else None,
        'tahun_akreditasi': int(s['tahun_akreditasi']) if s.get('tahun_akreditasi') and AKR.get(akr) else None,
        'sk_akreditasi': s.get('sk_akreditasi') if AKR.get(akr) else None,
        'akses_internet': internet,
        'sumber_listrik': None if (s.get('listrik') or '').strip() in ('', '-') else s['listrik'].strip(),
        'luas_tanah': luas,
        'koordinat': koordinat,
    })

json.dump({
    'sumber': 'Kementerian Pendidikan Dasar dan Menengah, Data Referensi Pendidikan',
    'url': 'https://referensi.data.kemendikdasmen.go.id/',
    'diakses': diakses,
    'cakupan': 'Satuan pendidikan formal SD, MI, SMP, MTs, SMA, SMK, MA berstatus aktif di 9 kecamatan Malang Selatan',
    'jumlah': len(out),
    'sekolah': out,
}, open(dst, 'w', encoding='utf-8'), ensure_ascii=False, indent=1)
print(len(out), 'sekolah aktif;', len(tidak_aktif), 'tidak aktif dikeluarkan')
print(Counter(s['jenjang'] for s in out))
print('akreditasi:', Counter(s['akreditasi'] for s in out))
print('tanpa detail:', sum(1 for s in d.values() if not s.get('detail')))
