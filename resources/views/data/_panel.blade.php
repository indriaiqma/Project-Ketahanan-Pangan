{{-- Panel ringkasan satu bidang di halaman Data Bidang. Parameter: $r (baris RingkasanBidang::semua) --}}
    @php($b = $r['bidang'])
    @php($pct = $r['jumlah_modul'] ? round($r['modul_terisi'] / $r['jumlah_modul'] * 100) : 0)
    <section class="card bidang-panel" id="{{ $b['slug'] }}">
        <div class="bidang-panel-head">
            <span class="ico-box" aria-hidden="true"><i class="bi bi-{{ $b['icon'] }}"></i></span>
            <div class="bp-title">
                <h2>{{ $b['nama'] }}</h2>
                <p>{{ $b['tagline'] }}</p>
            </div>
            <div class="bp-meter" title="{{ $r['modul_terisi'] }} dari {{ $r['jumlah_modul'] }} modul berisi data">
                <span><b>{{ $r['modul_terisi'] }}</b>/{{ $r['jumlah_modul'] }} modul berisi data</span>
                <span class="meter"><i style="--w: {{ $pct }}%"></i></span>
            </div>
            <a href="{{ route('data.bidang', $b['slug']) }}" class="btn btn-outline btn-sm">Lihat bidang <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="modul-grid">
            @foreach ($r['modul'] as $m)
                @php($s = $m['statistik'])
                <a href="{{ $m['href_publik'] }}" @class(['modul-chip', 'kosong' => ! $s['jumlah']])>
                    <span class="mc-ico"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i></span>
                    <span class="mc-info">
                        <b>{{ $m['nama'] }}</b>
                        <small>
                            @if ($s['jumlah'])
                                {{ angka($s['jumlah'], 0) }} data · {{ $s['terakhir']?->diffForHumans() ?? '' }}
                            @else
                                Belum ada data
                            @endif
                        </small>
                    </span>
                    <i class="bi bi-chevron-right mc-go" aria-hidden="true"></i>
                </a>
            @endforeach
        </div>
    </section>
