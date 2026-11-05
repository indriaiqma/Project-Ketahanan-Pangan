{{-- Halaman modul yang datanya belum tersedia (Lingkungan Hidup, SDM) --}}
@props(['title', 'module', 'icon', 'description'])

<x-page-header eyebrow="Modul Data" :title="$title" :description="$description">
    <x-slot:actions>
        <span class="badge amber"><span class="dot"></span>Menunggu Data</span>
    </x-slot:actions>
</x-page-header>

<section class="card">
    <x-empty :icon="$icon" :title="'Data ' . $module . ' belum tersedia'">
        Modul {{ $module }} sudah disiapkan di sistem. Data akan ditampilkan di sini setelah data resmi tersedia dan dimasukkan ke dalam sistem.
    </x-empty>
    <dl class="dl" style="border-top:1px solid var(--line-soft)">
        <div><dt>Modul</dt><dd>{{ $module }}</dd></div>
        <div><dt>Wilayah</dt><dd>Malang Selatan</dd></div>
        <div class="span-2"><dt>Status</dt><dd><span class="badge amber"><span class="dot"></span>Menunggu ketersediaan data</span></dd></div>
    </dl>
</section>
