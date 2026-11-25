"""Ekstraksi baris kecamatan dari halaman PDF BPS berdasarkan posisi (x, y)."""
import re
from pypdf import PdfReader
KEC = {'010': 'Donomulyo', '020': 'Kalipare', '030': 'Pagak', '040': 'Bantur', '050': 'Gedangan',
       '060': 'Sumbermanjing Wetan', '070': 'Dampit', '080': 'Tirtoyudo', '090': 'Ampelgading'}
_cache = {}
def items(fn, i):
    key = (fn, i)
    if key in _cache: return _cache[key]
    r = _cache.setdefault(fn, PdfReader(fn))
    out = []
    def v(text, cm, tm, fd, fs):
        if not text.strip(): return
        a, b, c, d, e, f = tm; A, B, C, D, E, F = cm
        if abs(b) > 0.01 or abs(c) > 0.01: return
        out.append((e*A + f*C + E, e*B + f*D + F, text.strip()))
    r.pages[i].extract_text(visitor_text=v)
    # pecah token yang berisi beberapa angka
    pecah = []
    for x, y, t in out:
        pecah.append((x, y, t))
    _cache[key] = pecah
    return pecah
def angka(t):
    t = t.strip()
    if t in ('-', '–', '—', '�', '...', '…', '0'): return 0.0
    if not re.fullmatch(r'[\d.]+(,\d+)?', t): return None
    return float(t.replace('.', '').replace(',', '.'))
def baris(fn, i, xmin=140, tol=4.0, label_regex=r'^(0[1-9]0)(\s+.+)?$'):
    it = items(fn, i)
    labels = {}
    for x, y, t in it:
        m = re.match(label_regex, t)
        if m and x < 120: labels[m.group(1)] = y
        if t.startswith('Kabupaten Malang') and x < 120: labels['KAB'] = y
    rows = {k: [] for k in labels}
    sisa = []
    for x, y, t in it:
        if x < xmin: continue
        for tok in t.split():
            if angka(tok) is None: continue
            k = min(labels, key=lambda k: abs(labels[k] - y), default=None)
            if k is not None and abs(labels[k] - y) <= tol: rows[k].append((x, tok))
            else: sisa.append((round(y, 1), round(x), tok))
    return {k: [angka(t) for x, t in sorted(v)] for k, v in rows.items()}, sisa
if __name__ == '__main__':
    import sys
    for a in sys.argv[2:]:
        rows, sisa = baris(sys.argv[1], int(a))
        print('=== p', a)
        for k in list(KEC) + ['KAB']:
            print(' ', k, KEC.get(k, 'KAB'), rows.get(k))
        if sisa: print('  sisa:', sisa[:12])
