{{--
    Dashboard panel pengelola: ringkasan seluruh bidang & modul yang boleh dilihat pengguna.
    Data dari App\Support\RingkasanBidang::landing($user) (di-cache, otomatis diperbarui saat data berubah).
    Admin melihat semua bidang; Petugas hanya sub bidang tugasnya.
--}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@php
    $user = auth()->user();
    $jam = (int) now()->format('H');
    $salam = match (true) {
        $jam < 11 => 'Selamat pagi',
        $jam < 15 => 'Selamat siang',
        $jam < 18 => 'Selamat sore',
        default   => 'Selamat malam',
    };

    // Daftar sub bidang tugas petugas, mis. "Sub Bidang Pemerintahan I, Sub Bidang Sarpras II"
    $namaTugas = collect($tugas)->map(fn ($k) => $k['sub']['nama'] ?? $k['bidang']['nama'])->implode(', ');
    $modulTugas = collect($tugas)->flatMap(fn ($k) => $k['modul']);

    $peran = [
        'admin'   => ['shield-fill-check', 'Anda memiliki akses penuh: mengelola data seluruh bidang, menghapus data, dan mengatur akun pengguna.'],
        'petugas' => ['person-badge-fill', $namaTugas
            ? 'Anda bertugas menginput dan memperbarui data di '.$namaTugas.'.'
            : 'Akun Anda belum ditugaskan ke sub bidang mana pun. Hubungi Administrator.'],
    ][$user->role] ?? ['person-fill', 'Selamat datang di panel pengelola.'];

    // Matriks hak akses (ditampilkan sesuai role yang sedang login)
    $hakAkses = $user->isPetugas()
        ? [
            ['Melihat data sub bidang tugas', true],
            ['Tambah, ubah & hapus data sub bidang tugas', true],
            ['Import & export data Excel', true],
            ['Melihat sub bidang lain', ! $dibatasi],
            ['Kelola akun pengguna', false],
        ]
        : [
            ['Melihat dashboard & seluruh data', true],
            ['Tambah, ubah & hapus data seluruh bidang', true],
            ['Import & export data Excel', true],
            ['Kelola akun & persetujuan pendaftaran', true],
        ];

    $inputCepat = $modulTugas->filter(fn ($m) => $m['input'])->take(2);
    $kecamatanTerdata = $wilayah->where('jumlah', '>', 0)->count();
    $maksWilayah = max(1, $wilayah->max('jumlah'));
    $pctTerisi = $total['modul'] ? round($total['terisi'] / $total['modul'] * 100) : 0;
    $perluTindakan = $menungguPendaftaran + $menungguReset;
@endphp

@section('content')

{{-- ===== Banner sambutan ===== --}}
<section class="welcome role-{{ $user->role }}">
    <div class="welcome-bg" aria-hidden="true"><span class="blob b1"></span><span class="blob b2"></span></div>

    <div class="welcome-copy">
        <span class="role-chip"><i class="bi bi-{{ $peran[0] }}"></i> {{ $user->roleLabel() }}</span>
        <h1>{{ $salam }}, {{ $user->name }}</h1>
        <p>{{ $peran[1] }}</p>
        <div class="welcome-meta">
            <span><i class="bi bi-calendar3"></i> {{ now()->translatedFormat('l, d F Y') }}</span>
            @if ($dibatasi)
                <span><i class="bi bi-grid-3x3-gap"></i> {{ $modulTugas->count() }} modul ditugaskan</span>
            @endif
            <span><i class="bi bi-clock-history"></i> {{ $total['terakhir'] ? 'Data diperbarui '.$total['terakhir']->translatedFormat('d F Y, H:i').' WIB' : 'Belum ada data' }}</span>
        </div>
    </div>

    <div class="welcome-actions">
        @if ($dibatasi)
            @foreach ($inputCepat as $m)
                <a href="{{ $m['input'] }}" class="quick">
                    <i class="bi bi-{{ $m['icon'] ?? 'plus-lg' }}"></i><span><b>Input {{ $m['nama'] }}</b><small>{{ $m['sub_nama'] ?? $m['bidang_nama'] }}</small></span>
                </a>
            @endforeach
        @elseif ($user->isAdmin())
            <a href="{{ route('admin.users.index') }}" class="quick">
                <i class="bi bi-person-check"></i><span><b>Persetujuan Akun</b><small>{{ $perluTindakan ? $perluTindakan.' menunggu tindakan' : 'Tidak ada yang menunggu' }}</small></span>
            </a>
            <a href="{{ route('admin.users.create') }}" class="quick">
                <i class="bi bi-person-plus"></i><span><b>Tambah Pengguna</b><small>Administrator & petugas</small></span>
            </a>
        @endif
        <a href="{{ route('dashboard') }}" class="quick" target="_blank" rel="noopener">
            <i class="bi bi-globe2"></i><span><b>Lihat Situs Publik</b><small>Tampilan untuk masyarakat</small></span>
        </a>
    </div>
</section>

{{-- ===== Statistik utama ===== --}}
<section class="grid grid-4">
    <x-stat icon="database-fill" label="Total Data" :value="angka($total['data'], 0)" unit="baris data {{ $dibatasi ? 'sub bidang tugas' : 'seluruh bidang' }}" />
    <x-stat icon="collection-fill" label="Modul Berisi Data" :value="$total['terisi'].' / '.$total['modul']" unit="{{ $pctTerisi }}% modul sudah diinput" tone="sky" />
    <x-stat icon="geo-alt-fill" label="Kecamatan Terdata" :value="$kecamatanTerdata.' / '.$wilayah->count()" unit="kecamatan Malang Selatan" tone="amber" />
    <x-stat icon="clock-history" label="Update Terakhir"
            :value="$total['terakhir'] ? $total['terakhir']->translatedFormat('d M Y') : '–'"
            :unit="$total['terakhir'] ? 'pukul '.$total['terakhir']->format('H:i').' WIB' : 'belum ada data diinput'" />
</section>

{{-- ===== Kelengkapan data per bidang + panel samping ===== --}}
<section class="grid grid-main">
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-bar-chart-steps"></i></span>
                <div>
                    <h2>Kelengkapan Data per Bidang</h2>
                    <p>Modul yang sudah berisi data dan jumlah data setiap bidang</p>
                </div>
            </div>
        </div>
        @if ($semua->isEmpty())
            <x-empty icon="person-exclamation" title="Belum ada bidang">Akun Anda belum ditugaskan ke sub bidang mana pun.</x-empty>
        @else
            <ul class="kelengkapan-list">
                @foreach ($semua as $r)
                    @php($b = $r['bidang'])
                    @php($pct = $r['jumlah_modul'] ? round($r['modul_terisi'] / $r['jumlah_modul'] * 100) : 0)
                    <li>
                        <a href="{{ route('admin.bidang.show', $b['slug']) }}">
                            <span class="kl-ico"><i class="bi bi-{{ $b['icon'] }}"></i></span>
                            <span class="kl-info">
                                <span class="kl-judul">
                                    <b>{{ $b['nama'] }}</b>
                                    @if ($r['khusus'])<span class="badge">Menu khusus</span>@endif
                                </span>
                                <span class="meter"><i style="--w: {{ $pct }}%"></i></span>
                                <small>{{ $r['modul_terisi'] }}/{{ $r['jumlah_modul'] }} modul terisi · {{ angka($r['jumlah_data'], 0) }} data
                                    @if ($r['terakhir']) · diperbarui {{ $r['terakhir']->diffForHumans() }}@endif</small>
                            </span>
                            <span class="kl-pct">{{ $pct }}%</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <div class="stack">
        @if ($user->isAdmin())
            <section class="card">
                <div class="card-head">
                    <div class="card-title">
                        <span class="ico"><i class="bi bi-bell-fill"></i></span>
                        <div><h2>Perlu Tindakan</h2><p>Hal yang menunggu Administrator</p></div>
                    </div>
                </div>
                <ul class="tindakan-list">
                    <li @class(['ada' => $menungguPendaftaran])>
                        <a href="{{ route('admin.users.index') }}">
                            <i class="bi bi-person-plus"></i>
                            <span><b>Pendaftaran akun</b><small>{{ $menungguPendaftaran ? 'menunggu persetujuan' : 'tidak ada yang menunggu' }}</small></span>
                            <em>{{ $menungguPendaftaran }}</em>
                        </a>
                    </li>
                    <li @class(['ada' => $menungguReset])>
                        <a href="{{ route('admin.users.index') }}">
                            <i class="bi bi-key"></i>
                            <span><b>Permintaan reset password</b><small>{{ $menungguReset ? 'menunggu diproses' : 'tidak ada yang menunggu' }}</small></span>
                            <em>{{ $menungguReset }}</em>
                        </a>
                    </li>
                    <li @class(['ada' => $modulKosong->isNotEmpty()])>
                        <a href="#modul-kosong">
                            <i class="bi bi-inbox"></i>
                            <span><b>Modul belum berisi data</b><small>{{ $modulKosong->isNotEmpty() ? 'perlu diinput petugas' : 'semua modul sudah berisi data' }}</small></span>
                            <em>{{ $modulKosong->count() }}</em>
                        </a>
                    </li>
                </ul>
            </section>
        @endif
        @include('admin._hak-akses')
    </div>
</section>

{{-- ===== Petugas: modul tugas ===== --}}
@if ($dibatasi)
    <div class="section-title">
        <div>
            <span class="kicker">Tugas Anda</span>
            <h2>Modul yang Anda kelola</h2>
            <p>Input dan perbarui data sub bidang tugas Anda</p>
        </div>
    </div>
    @forelse ($tugas as $k)
        <section class="card">
            <div class="card-head">
                <div class="card-title">
                    <span class="ico"><i class="bi bi-{{ $k['bidang']['icon'] }}"></i></span>
                    <div>
                        <h2>{{ $k['sub']['nama'] ?? $k['bidang']['nama'] }}</h2>
                        <p>{{ $k['bidang']['nama'] }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.bidang.show', $k['bidang']['slug']) }}" class="btn btn-outline btn-sm">Ringkasan <i class="bi bi-arrow-right"></i></a>
            </div>
            <ul class="modul-list">
                @foreach ($k['modul'] as $m)
                    <li>
                        <div class="modul-row">
                            <span class="st"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i></span>
                            <a href="{{ $m['href'] }}" class="info" style="color:inherit">
                                <b>{{ $m['nama'] }}</b>
                                <small>{{ $m['ringkasan']['teks'] }}</small>
                            </a>
                            @if ($m['input'])
                                <a href="{{ $m['input'] }}" class="btn btn-outline btn-sm"><i class="bi bi-plus-lg"></i> Input</a>
                            @endif
                            <a href="{{ $m['href'] }}" class="btn btn-ghost btn-icon" aria-label="Buka {{ $m['nama'] }}"><i class="bi bi-chevron-right"></i></a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    @empty
        <section class="card">
            <x-empty icon="person-exclamation" title="Belum ada penugasan">
                Akun Anda belum ditugaskan ke sub bidang mana pun, sehingga belum ada modul yang dapat dikelola. Hubungi Administrator untuk mengatur penugasan.
            </x-empty>
        </section>
    @endforelse
@endif

{{-- ===== Indikator utama ===== --}}
<div class="section-title">
    <div>
        <span class="kicker">Indikator</span>
        <h2>Indikator terbaru {{ $dibatasi ? 'sub bidang Anda' : 'seluruh bidang' }}</h2>
        <p>Angka periode terakhir setiap modul, dijumlahkan dari seluruh kecamatan</p>
    </div>
</div>
@if ($sorotan->isEmpty())
    <section class="card">
        <x-empty icon="clipboard-data" title="Belum ada data">Indikator akan tampil setelah data diinput.</x-empty>
    </section>
@else
    <section class="grid grid-4 sorotan-grid">
        @foreach ($sorotan as $s)
            <a href="{{ $s['href'] }}" class="card sorotan">
                <div class="so-head">
                    <span class="so-ico"><i class="bi bi-{{ $s['icon'] }}"></i></span>
                    <span class="so-modul"><b>{{ $s['nama'] }}</b><small>{{ $s['sub_nama'] }}</small></span>
                </div>
                <div class="so-label">
                    <span>{{ $s['label'] }}</span>
                    @if ($s['status'])
                        <span @class(['badge', 'green' => $s['status']['baik'], 'amber' => ! $s['status']['baik']]) title="{{ $s['status']['target'] }}">
                            <span class="dot"></span>{{ $s['status']['baik'] ? 'Capai target' : 'Di bawah target' }}
                        </span>
                    @endif
                </div>
                <div class="so-nilai">{{ $s['nilai'] }}<small>{{ $s['satuan'] }}</small></div>
                <div class="so-foot"><span><i class="bi bi-calendar3"></i> {{ $s['periode'] }}</span></div>
            </a>
        @endforeach
    </section>
@endif

{{-- ===== Pembaruan & cakupan wilayah ===== --}}
<section class="grid grid-main">
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-activity"></i></span>
                <div><h2>Pembaruan Terbaru</h2><p>Data yang terakhir diinput atau diubah</p></div>
            </div>
        </div>
        @if ($pembaruan->isEmpty())
            <x-empty icon="clock-history" title="Belum ada pembaruan">Aktivitas input data akan tampil di sini.</x-empty>
        @else
            <ul class="timeline">
                @foreach ($pembaruan as $p)
                    <li>
                        <span class="tl-ico"><i class="bi bi-{{ $p['icon'] }}"></i></span>
                        <a href="{{ $p['href'] }}" class="tl-info">
                            <b>{{ $p['nama'] }}</b>
                            <small>{{ $p['bidang_nama'] }} · {{ $p['keterangan'] }}</small>
                        </a>
                        <time datetime="{{ $p['waktu']->toIso8601String() }}" title="{{ $p['waktu']->translatedFormat('d F Y, H:i') }} WIB">{{ $p['waktu']->diffForHumans() }}</time>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-geo-alt"></i></span>
                <div><h2>Cakupan Wilayah</h2><p>Jumlah data rekap per kecamatan</p></div>
            </div>
            <span class="muted" style="font-size:13px">{{ $kecamatanTerdata }}/{{ $wilayah->count() }} terdata</span>
        </div>
        <ul class="wilayah-list">
            @foreach ($wilayah->sortByDesc('jumlah') as $w)
                <li @class(['kosong' => ! $w['jumlah']])>
                    <span class="wl-nama"><span class="dot"></span>{{ $w['nama'] }}</span>
                    <span class="meter"><i style="--w: {{ round($w['jumlah'] / $maksWilayah * 100) }}%"></i></span>
                    <b>{{ angka($w['jumlah'], 0) }}</b>
                </li>
            @endforeach
        </ul>
    </section>
</section>

{{-- ===== Modul belum berisi data ===== --}}
@if ($modulKosong->isNotEmpty())
    <section class="card" id="modul-kosong">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-inbox"></i></span>
                <div>
                    <h2>Modul Belum Berisi Data</h2>
                    <p>{{ $modulKosong->count() }} modul menunggu input dari petugas sub bidang terkait</p>
                </div>
            </div>
        </div>
        <div class="modul-grid">
            @foreach ($modulKosong as $m)
                <a href="{{ $m['href'] }}" class="modul-chip kosong">
                    <span class="mc-ico"><i class="bi bi-{{ $m['icon'] ?? 'grid' }}"></i></span>
                    <span class="mc-info">
                        <b>{{ $m['nama'] }}</b>
                        <small>{{ $m['sub_nama'] ?? $m['bidang_nama'] }}</small>
                    </span>
                    <i class="bi bi-chevron-right mc-go" aria-hidden="true"></i>
                </a>
            @endforeach
        </div>
    </section>
@endif

@endsection
