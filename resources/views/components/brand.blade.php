{{--
    Identitas visual: lambang Provinsi Jawa Timur + nama instansi dan sistem.
    - variant : light (latar putih) | dark (latar gelap/hijau)
    - size    : sm | md | lg
    - sub     : teks baris kedua (nama sistem)
    - short   : versi singkat baris kedua untuk layar kecil
--}}
@props([
    'variant' => 'light',
    'size' => 'md',
    'sub' => 'Sistem Informasi Ketahanan Pangan',
    'short' => 'SIKP Malang Selatan',
])

<span {{ $attributes->class(['brandmark', 'brandmark--' . $variant, 'brandmark--' . $size]) }}>
    <img src="{{ asset('images/logo-jatim.png') }}" alt="Lambang Provinsi Jawa Timur" class="brandmark__emblem" width="110" height="150">
    <span class="brandmark__text">
        <span class="brandmark__org">Bakorwil III Malang</span>
        <span class="brandmark__name">
            <span class="brandmark__full">{{ $sub }}</span>
            <span class="brandmark__short" aria-hidden="true">{{ $short }}</span>
        </span>
    </span>
</span>
