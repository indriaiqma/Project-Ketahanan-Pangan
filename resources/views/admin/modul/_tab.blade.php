{{--
    Tab modul rekap & rinciannya, mis. "Rekap per Kecamatan" | "Daftar Sekolah".
    Parameter: $tabModul ([induk, rincian] atau []), $modul (modul aktif), $rute (route bidang/modul).
--}}
@if (! empty($tabModul))
    @php([$tabInduk, $tabRincian] = $tabModul)
    <nav class="modul-tabs" aria-label="Tampilan data {{ $tabInduk['nama'] }}">
        <a href="{{ route($rute['modul'], ['bidang' => $tabInduk['bidang'], 'modul' => $tabInduk['slug']]) }}"
           @class(['active' => $modul['slug'] === $tabInduk['slug']]) @if ($modul['slug'] === $tabInduk['slug']) aria-current="page" @endif>
            <i class="bi bi-bar-chart-line"></i>
            <span><b>Rekap per Kecamatan</b><small>Angka & capaian per periode</small></span>
        </a>
        <a href="{{ route($rute['modul'], ['bidang' => $tabRincian['bidang'], 'modul' => $tabRincian['slug']]) }}"
           @class(['active' => $modul['slug'] === $tabRincian['slug']]) @if ($modul['slug'] === $tabRincian['slug']) aria-current="page" @endif>
            <i class="bi bi-{{ $tabRincian['icon'] ?? 'list-ul' }}"></i>
            <span><b>{{ $tabRincian['nama'] }}</b><small>Rincian per lokasi</small></span>
        </a>
    </nav>
@endif
