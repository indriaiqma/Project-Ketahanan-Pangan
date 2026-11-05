import './bootstrap';
import Chart from 'chart.js/auto';

/* =========================================================================
   Grafik: gaya seragam untuk semua halaman.
   Dipakai dari Blade lewat window.SIKP (lihat @push('scripts') di view).
   ========================================================================= */
const nf = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 });

Chart.defaults.font.family = "'Inter Variable', 'Inter', system-ui, sans-serif";
Chart.defaults.font.size = 12;
Chart.defaults.color = '#627168';
Chart.defaults.plugins.tooltip.backgroundColor = '#14211b';
Chart.defaults.plugins.tooltip.padding = 10;
Chart.defaults.plugins.tooltip.cornerRadius = 8;

export const WARNA = {
    sangatKritis: '#e5484d',
    kritis: '#f5a524',
    agakKritis: '#7cb82f',
    potensialKritis: '#2f80c2',
    tidakKritis: '#c9d1cc',
    utama: '#18774d',
};

function barChart(canvas, { labels, datasets, stacked = false, unit = 'Ha' }) {
    if (!canvas) return null;
    return new Chart(canvas, {
        type: 'bar',
        data: {
            labels,
            datasets: datasets.map((d) => ({
                borderRadius: 6,
                maxBarThickness: 46,
                backgroundColor: WARNA.utama,
                ...d,
            })),
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            // Hanya animasikan tinggi batang; posisi horizontal langsung di tempatnya
            animations: { x: { duration: 0 }, width: { duration: 0 } },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: (c) => ` ${c.dataset.label}: ${nf.format(c.parsed.y)} ${unit}` } },
            },
            scales: {
                x: { stacked, grid: { display: false }, border: { display: false } },
                y: {
                    stacked,
                    beginAtZero: true,
                    border: { display: false },
                    grid: { color: '#eef2ef' },
                    ticks: { callback: (v) => nf.format(v) },
                },
            },
        },
    });
}

function donutChart(canvas, { labels, data, colors, unit = 'Ha' }) {
    if (!canvas) return null;
    return new Chart(canvas, {
        type: 'doughnut',
        data: { labels, datasets: [{ data, backgroundColor: colors, borderWidth: 2, borderColor: '#fff', hoverOffset: 4 }] },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: (c) => ` ${c.label}: ${nf.format(c.parsed)} ${unit}` } },
            },
        },
    });
}

window.SIKP = { barChart, donutChart, WARNA };

/* =========================================================================
   Interaksi umum
   ========================================================================= */
document.addEventListener('click', (e) => {
    // Dropdown: klik tombol untuk buka/tutup, klik di luar untuk menutup.
    const trigger = e.target.closest('[data-dropdown-toggle]');
    document.querySelectorAll('.dropdown.open').forEach((d) => {
        if (!trigger || d !== trigger.closest('.dropdown')) d.classList.remove('open');
    });
    if (trigger) {
        e.preventDefault();
        trigger.closest('.dropdown').classList.toggle('open');
        trigger.setAttribute('aria-expanded', trigger.closest('.dropdown').classList.contains('open'));
    }

    // Menu publik di layar kecil
    if (e.target.closest('[data-nav-toggle]')) {
        document.querySelector('.site-menu')?.classList.toggle('open');
        updateNav();
    }

    // Tombol "kembali ke atas" di footer
    if (e.target.closest('[data-back-to-top]')) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Sidebar admin di layar kecil
    if (e.target.closest('[data-sidebar-toggle]') || e.target.closest('.backdrop')) {
        document.querySelector('.admin')?.classList.toggle('nav-open');
    }

    // Tampilkan / sembunyikan password
    const eye = e.target.closest('[data-toggle-password]');
    if (eye) {
        const input = eye.parentElement.querySelector('input');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        eye.textContent = show ? 'Sembunyikan' : 'Lihat';
    }

    // Tutup notifikasi
    if (e.target.closest('.alert .close')) {
        e.target.closest('.alert').remove();
    }
});

// Konfirmasi sebelum aksi berbahaya (hapus data)
document.addEventListener('submit', (e) => {
    const form = e.target;
    if (form.dataset.confirm && !window.confirm(form.dataset.confirm)) {
        e.preventDefault();
        return;
    }
    // Cegah klik ganda saat menyimpan
    form.querySelectorAll('button[type="submit"]').forEach((b) => {
        b.disabled = true;
        if (b.dataset.loading) b.innerHTML = b.dataset.loading;
    });
    startLoading();
});

// Nama file yang dipilih pada form import
document.addEventListener('change', (e) => {
    const input = e.target.closest('[data-file-input]');
    if (!input) return;
    const label = document.querySelector(input.dataset.fileInput);
    const submit = input.form?.querySelector('button[type="submit"]');
    if (label) label.textContent = input.files[0]?.name ?? 'Belum ada file dipilih';
    if (submit) submit.disabled = !input.files.length;
});

// Notifikasi sukses hilang otomatis
setTimeout(() => {
    document.querySelectorAll('.alert-success[data-autohide]').forEach((a) => {
        a.style.transition = 'opacity .4s';
        a.style.opacity = '0';
        setTimeout(() => a.remove(), 400);
    });
}, 5000);

// Saat kembali dengan tombol Back, aktifkan lagi tombol yang sempat dinonaktifkan
window.addEventListener('pageshow', () => {
    document.querySelectorAll('form button[type="submit"][disabled]:not([data-keep-disabled])').forEach((b) => (b.disabled = false));
    document.documentElement.classList.remove('is-loading');
});

/* =========================================================================
   Efek tampilan
   ========================================================================= */
const kurangiGerak = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// ---- Bar loading tipis di atas layar saat pindah halaman ----
// (database berada jauh, jadi beri tanda bahwa halaman sedang dimuat)
const progress = document.createElement('div');
progress.className = 'top-progress';
document.body.appendChild(progress);

function startLoading() {
    document.documentElement.classList.add('is-loading');
}

document.addEventListener('click', (e) => {
    const a = e.target.closest('a[href]');
    if (!a || e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
    if ((a.target && a.target !== '_self') || a.hasAttribute('download')) return;

    const url = new URL(a.href, location.href);
    if (url.origin !== location.origin) return;
    if (url.pathname === location.pathname && url.search === location.search && url.hash) return; // lompat ke bagian halaman
    if (/\/export$/.test(url.pathname)) return; // unduhan file, halaman tidak berpindah

    startLoading();
});

// ---- Navbar: transparan di atas hero, solid setelah di-scroll ----
const nav = document.querySelector('[data-site-nav]');
const navDiAtasHero = document.body.classList.contains('has-hero');

function updateNav() {
    if (!nav) return;
    const turun = window.scrollY > 24;
    const menuTerbuka = document.querySelector('.site-menu.open');
    nav.classList.toggle('scrolled', turun);
    if (navDiAtasHero) nav.classList.toggle('on-dark', !turun && !menuTerbuka);
}
updateNav();
window.addEventListener('scroll', updateNav, { passive: true });

// ---- Sorotan cahaya mengikuti kursor pada kartu ----
document.addEventListener('pointermove', (e) => {
    const el = e.target.closest?.('.tile, .stat, .quick, .region');
    if (!el) return;
    const r = el.getBoundingClientRect();
    el.style.setProperty('--mx', `${e.clientX - r.left}px`);
    el.style.setProperty('--my', `${e.clientY - r.top}px`);
}, { passive: true });

// ---- Angka statistik menghitung naik ----
const formatId = (n, dec) => new Intl.NumberFormat('id-ID', { minimumFractionDigits: dec, maximumFractionDigits: dec }).format(n);

function hitungNaik(el) {
    const teks = el.textContent.trim();
    // Hanya angka format Indonesia, misal "18" atau "13.649,68"
    if (!/^-?[\d.]+(,\d+)?$/.test(teks)) return;
    const [bulat, pecahan = ''] = teks.split(',');
    const target = parseFloat(`${bulat.replace(/\./g, '')}.${pecahan || 0}`);
    if (!target) return;

    const durasi = 1400;
    const mulai = performance.now();
    const langkah = (t) => {
        const p = Math.min((t - mulai) / durasi, 1);
        const ease = 1 - Math.pow(1 - p, 3);
        el.textContent = formatId(target * ease, pecahan.length);
        if (p < 1) requestAnimationFrame(langkah);
        else el.textContent = teks; // pastikan nilai akhir persis sama
    };
    requestAnimationFrame(langkah);
}

// ---- Elemen muncul halus saat di-scroll ----
if (!kurangiGerak && 'IntersectionObserver' in window) {
    const angka = document.querySelectorAll('.stat .value, [data-count-to]');
    const selektor = 'main .card, main .page-head, main .section-title, main .welcome, main .cta-band, .hero-copy, .hero-visual';
    const target = document.querySelectorAll(selektor);

    target.forEach((el) => {
        // Kartu yang berdampingan muncul bergantian (stagger)
        const saudara = [...el.parentElement.children].filter((s) => s.matches(selektor));
        el.style.setProperty('--d', `${Math.min(saudara.indexOf(el), 5) * 80}ms`);
        el.classList.add('reveal');
    });

    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            io.unobserve(el);

            if (el.classList.contains('reveal')) {
                el.classList.add('in');
                // Lepas kelas setelah selesai agar efek hover kartu kembali normal
                el.addEventListener('transitionend', function selesai(ev) {
                    if (ev.target !== el || ev.propertyName !== 'opacity') return;
                    el.classList.remove('reveal', 'in');
                    el.style.removeProperty('--d');
                    el.removeEventListener('transitionend', selesai);
                });
            }
            el.querySelectorAll?.('.stat .value, [data-count-to]').forEach(hitungNaik);
            if (el.matches('.stat .value, [data-count-to]')) hitungNaik(el);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    target.forEach((el) => io.observe(el));
    // Angka yang tidak berada di dalam elemen ber-animasi tetap dihitung naik
    angka.forEach((el) => { if (!el.closest('.reveal')) io.observe(el); });
}
