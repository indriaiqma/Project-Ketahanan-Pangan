{{--
    Menu BIDANG di sidebar: pencarian modul + accordion per bidang.
    Seluruh isi dibaca dari config/bidang.php lewat App\Support\Bidang.
    Perilaku (satu bidang terbuka, pencarian, keyboard) ada di resources/js/app.js.
--}}
@php
    $posisi = \App\Support\Bidang::posisiSaatIni();
    $daftar = \App\Support\Bidang::untuk(auth()->user());
    $kecil = fn ($teks) => mb_strtolower((string) $teks);
@endphp

<div class="side-search" data-side-search>
    <i class="bi bi-search" aria-hidden="true"></i>
    <input type="search" placeholder="Cari modul…" aria-label="Cari modul atau bidang" autocomplete="off" data-side-search-input>
    <button type="button" class="clear" aria-label="Hapus pencarian" hidden data-side-search-clear><i class="bi bi-x-circle-fill"></i></button>
</div>
<p class="side-empty" hidden data-side-empty>Tidak ada modul yang cocok.</p>

<div class="acc-list" data-acc-list>
    @foreach ($daftar as $b)
        @php
            $terbuka = $posisi['bidang'] === $b['slug'];
            $namaPendek = preg_replace('/^Bidang /', '', $b['nama']);
        @endphp
        <div @class(['acc', 'open' => $terbuka]) data-acc data-awal="{{ $terbuka ? '1' : '0' }}" data-cari="{{ $kecil($b['nama'].' '.$b['tagline']) }}">
            <button type="button" id="acc-btn-{{ $b['slug'] }}" @class(['acc-btn', 'current' => $terbuka])
                    aria-expanded="{{ $terbuka ? 'true' : 'false' }}" aria-controls="acc-{{ $b['slug'] }}" data-acc-btn>
                <i class="bi bi-{{ $b['icon'] }}" aria-hidden="true"></i>
                <span>{{ $namaPendek }}</span>
                <i class="bi bi-chevron-down chev" aria-hidden="true"></i>
            </button>

            <div class="acc-panel" id="acc-{{ $b['slug'] }}" role="region" aria-labelledby="acc-btn-{{ $b['slug'] }}" @unless ($terbuka) inert @endunless>
                <div class="acc-inner">
                    <a href="{{ route('admin.bidang.show', $b['slug']) }}" data-item data-cari="ringkasan {{ $kecil($b['nama']) }}"
                       @class(['acc-overview', 'active' => $terbuka && ! $posisi['modul']])
                       @if ($terbuka && ! $posisi['modul']) aria-current="page" @endif>
                        <i class="bi bi-grid" aria-hidden="true"></i> Ringkasan bidang
                    </a>

                    @foreach (\App\Support\Bidang::kelompok($b) as $kelompok)
                        <div class="acc-group" data-group data-cari="{{ $kecil($kelompok['sub']['nama'] ?? '') }}">
                            @if ($kelompok['sub'])
                                <div class="acc-sub">{{ $kelompok['sub']['nama'] }}</div>
                            @endif
                            <ul class="acc-tree">
                                @foreach ($kelompok['modul'] as $m)
                                    @php($aktifSekarang = $terbuka && $posisi['modul'] === $m['slug'])
                                    <li data-item data-cari="{{ $kecil($m['nama']) }}">
                                        <a href="{{ $m['href'] }}" @class(['active' => $aktifSekarang, 'segera' => ! $m['aktif']])
                                           @if ($aktifSekarang) aria-current="page" @endif>
                                            <span class="nm">{{ $m['nama'] }}</span>
                                            @unless ($m['aktif'])<span class="tag">Segera</span>@endunless
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
