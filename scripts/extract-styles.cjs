/**
 * Memindahkan blok <style> di file Blade ke file CSS terpisah.
 *
 * Cara pakai (jalankan dari folder root project, yang berisi artisan):
 *
 *   node scripts/extract-styles.cjs            -> hanya MELIHAT rencana (tidak mengubah apa pun)
 *   node scripts/extract-styles.cjs --write    -> benar-benar memindahkan
 *
 * Yang dilakukan untuk tiap file resources/views/**\/*.blade.php yang punya <style>:
 *   1. Isi <style> disalin ke resources/css/pages/<nama-file>.css
 *   2. Blok <style> di file Blade diganti @vite('resources/css/pages/<nama-file>.css')
 *   3. File Blade asli dicadangkan ke scripts/backup-views/
 *
 * File yang aman dilewati (dan dilaporkan):
 *   - <style> yang berisi sintaks Blade ({{ }}, @if, @foreach, dst.)
 *   - File CSS tujuan sudah ada
 */

const fs = require('fs');
const path = require('path');

const ROOT = process.cwd();
const VIEWS_DIR = path.join(ROOT, 'resources', 'views');
const CSS_DIR = path.join(ROOT, 'resources', 'css', 'pages');
const BACKUP_DIR = path.join(ROOT, 'scripts', 'backup-views');
const WRITE = process.argv.includes('--write');

const STYLE_RE = /<style\b[^>]*>([\s\S]*?)<\/style>/gi;

// Sintaks Blade yang tidak boleh ikut dipindah ke file .css
const BLADE_RE =
    /\{\{|\{!!|@(?:php|if|elseif|else|endif|foreach|endforeach|forelse|for|endfor|while|endwhile|isset|empty|auth|guest|can|json|include|yield|section|endsection|vite|asset|push|stack|lang|csrf|error)\b/;

if (!fs.existsSync(VIEWS_DIR)) {
    console.error('Folder resources/views tidak ditemukan.');
    console.error('Jalankan skrip ini dari folder root project (yang berisi file artisan).');
    process.exit(1);
}

function walk(dir) {
    const out = [];
    for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        const full = path.join(dir, entry.name);
        if (entry.isDirectory()) out.push(...walk(full));
        else if (entry.name.endsWith('.blade.php')) out.push(full);
    }
    return out;
}

// Buang indentasi bersama supaya CSS rapi di file barunya
function dedent(css) {
    const lines = css.replace(/\r\n/g, '\n').split('\n');
    const indents = lines
        .filter((l) => l.trim() !== '')
        .map((l) => l.match(/^[ \t]*/)[0].length);
    const min = indents.length ? Math.min(...indents) : 0;
    return lines.map((l) => l.slice(min)).join('\n').trim() + '\n';
}

const moved = [];
const skipped = [];
let clean = 0;

for (const file of walk(VIEWS_DIR)) {
    const rel = path
        .relative(VIEWS_DIR, file)
        .split(path.sep)
        .join('/')
        .replace(/\.blade\.php$/, '');

    const src = fs.readFileSync(file, 'utf8');
    const blocks = [...src.matchAll(STYLE_RE)];

    if (blocks.length === 0) {
        clean++;
        continue;
    }

    const cssParts = blocks.map((m) => m[1]);

    if (cssParts.some((css) => BLADE_RE.test(css))) {
        skipped.push([rel, 'isi <style> memakai sintaks Blade ({{ }}, @if, dst.), kerjakan manual']);
        continue;
    }

    const cssFile = path.join(CSS_DIR, ...rel.split('/')) + '.css';

    if (fs.existsSync(cssFile)) {
        skipped.push([rel, 'file CSS tujuan sudah ada: ' + path.relative(ROOT, cssFile)]);
        continue;
    }

    const vitePath = `resources/css/pages/${rel}.css`;

    let n = 0;
    const out = src.replace(STYLE_RE, () => (n++ === 0 ? `@vite('${vitePath}')` : ''));

    const css =
        `/* Dipindahkan dari resources/views/${rel}.blade.php */\n\n` +
        cssParts.map(dedent).join('\n');

    if (WRITE) {
        const backupFile = path.join(BACKUP_DIR, ...rel.split('/')) + '.blade.php';
        fs.mkdirSync(path.dirname(backupFile), { recursive: true });
        fs.writeFileSync(backupFile, src);

        fs.mkdirSync(path.dirname(cssFile), { recursive: true });
        fs.writeFileSync(cssFile, css);

        fs.writeFileSync(file, out);
    }

    moved.push([rel, vitePath, blocks.length]);
}

console.log('');
console.log(WRITE ? '=== HASIL (file sudah diubah) ===' : '=== RENCANA (belum ada yang diubah) ===');
console.log('');

for (const [rel, vitePath, count] of moved) {
    console.log(`  OK    ${rel}.blade.php  ->  ${vitePath}` + (count > 1 ? `  (${count} blok digabung)` : ''));
}

for (const [rel, why] of skipped) {
    console.log(`  LEWAT ${rel}.blade.php  --  ${why}`);
}

console.log('');
console.log(`  Dipindahkan : ${moved.length} file`);
console.log(`  Dilewati    : ${skipped.length} file`);
console.log(`  Sudah bersih: ${clean} file`);
console.log('');

if (!WRITE && moved.length) {
    console.log('Kalau rencana di atas sudah benar, jalankan lagi dengan --write:');
    console.log('  node scripts/extract-styles.cjs --write');
    console.log('');
}

if (WRITE && moved.length) {
    console.log('Langkah berikutnya: hentikan "npm run dev" (Ctrl + C), lalu jalankan lagi.');
    console.log('Cadangan file Blade asli ada di scripts/backup-views/');
    console.log('');
}
