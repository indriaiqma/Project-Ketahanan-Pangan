// Ambil daftar sekolah formal 9 kecamatan Malang Selatan dari Data Referensi Kemendikdasmen
import puppeteer from 'puppeteer-core';
import fs from 'fs';
const OUT = process.argv[2];
const KEC = { '051801': 'Donomulyo', '051802': 'Kalipare', '051803': 'Pagak', '051804': 'Bantur', '051805': 'Gedangan',
  '051806': 'Sumbermanjing Wetan', '051807': 'Dampit', '051808': 'Tirtoyudo', '051809': 'Ampelgading' };
const BENTUK = ['SD', 'MI', 'SMP', 'MTs', 'SMA', 'SMK', 'MA'];
const BASE = 'https://referensi.data.kemendikdasmen.go.id';
const b = await puppeteer.launch({ executablePath: 'C:/Program Files (x86)/Microsoft/Edge/Application/msedge.exe', headless: true });
const p = await b.newPage();
await p.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0 Safari/537.36 Edg/126.0');
const sleep = (ms) => new Promise(r => setTimeout(r, ms));
let hasil = fs.existsSync(OUT) ? JSON.parse(fs.readFileSync(OUT, 'utf8')) : {};
for (const [kode, kec] of Object.entries(KEC)) {
  for (const jenis of ['dikdas', 'dikmen']) {
    await p.goto(`${BASE}/satpen/${jenis}/${kode}/3`, { waitUntil: 'networkidle2', timeout: 120000 });
    const rows = await p.evaluate(() => [...document.querySelectorAll('table tbody tr')].map(tr => [...tr.querySelectorAll('td')].map(td => td.innerText.trim())));
    const judul = await p.evaluate(() => document.body.innerText.match(/Kec\.[^\n]*/)?.[0] || '');
    let n = 0;
    for (const r of rows) {
      const [no, npsn, nama, bentuk, status, alamat, desa] = r;
      if (!BENTUK.includes(bentuk) || hasil[npsn]) continue;
      hasil[npsn] = { npsn, nama, bentuk, status, alamat, desa, kecamatan: kec, kode_kec: kode };
      n++;
    }
    console.log(kec, jenis, 'baris', rows.length, 'baru', n, '|', judul.slice(0, 60));
    fs.writeFileSync(OUT, JSON.stringify(hasil, null, 1));
    await sleep(800);
  }
}
// Detail: akreditasi, koordinat, listrik, internet
let i = 0;
for (const s of Object.values(hasil)) {
  if (s.detail) continue;
  try {
    await p.goto(`${BASE}/satpen/detail/${s.npsn}`, { waitUntil: 'domcontentloaded', timeout: 90000 });
    const t = await p.evaluate(() => document.body.textContent.replace(/\s+/g, ' '));
    const ambil = (re) => (t.match(re) || [])[1]?.trim() ?? null;
    const ak = t.match(/Akhir SK\s+(.*?)\s+↗ Lihat di BAN-PDM\s+(\d{4})\s+(\S+)/);
    s.akreditasi = ak ? ak[1].replace(/^-\s*/, '').trim() || null : null;
    s.tahun_akreditasi = ak ? ak[2] : null;
    s.sk_akreditasi = ak ? ak[3] : null;
    s.status_aktif = ambil(/Status Satuan Pendidikan ODS\s*(\S+)/);
    s.lintang = ambil(/Lintang\s*(-?[\d.]+)/);
    s.bujur = ambil(/Bujur\s*(-?[\d.]+)/);
    s.listrik = ambil(/Sumber Listrik\s*([A-Za-z ]+?)Daya/);
    s.internet = ambil(/Akses Internet 1\s*(.+?)Akses Internet 2/);
    s.luas_tanah = ambil(/Luas Tanah\s*([\d.,]+) m²/);
    s.detail = true;
  } catch (e) { s.detail_error = e.message; }
  if (++i % 20 === 0) { fs.writeFileSync(OUT, JSON.stringify(hasil, null, 1)); console.log('detail', i); }
  await sleep(300);
}
fs.writeFileSync(OUT, JSON.stringify(hasil, null, 1));
console.log('SELESAI', Object.keys(hasil).length, 'sekolah');
await b.close();
