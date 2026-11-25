@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<x-page-header compact eyebrow="Pengaturan" title="Kelola Pengguna" description="Atur akun yang dapat mengakses sistem beserta hak aksesnya.">
    <x-slot:actions>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah Pengguna</a>
    </x-slot:actions>
</x-page-header>

{{-- Password sementara: hanya ditampilkan sekali setelah dibuat --}}
@if ($baru = session('password_sementara'))
    <section class="card reset-hasil" role="status">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-key-fill"></i></span>
                <div>
                    <h2>Password sementara untuk {{ $baru['nama'] }}</h2>
                    <p>{{ $baru['email'] }} · hanya ditampilkan sekali, sampaikan langsung kepada pemilik akun</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="kode-sementara">
                <code id="password-sementara">{{ $baru['password'] }}</code>
                <button type="button" class="btn btn-outline btn-sm" data-salin="#password-sementara"><i class="bi bi-clipboard"></i> Salin</button>
            </div>
            <p class="muted" style="margin:10px 0 0;font-size:13px">
                Pengguna wajib membuat password baru saat pertama kali masuk dengan password ini. Sampaikan melalui jalur pribadi (bukan grup).
            </p>
        </div>
    </section>
@endif

{{-- Permintaan reset password dari halaman "Lupa Password" --}}
@if ($permintaan->isNotEmpty())
    <section class="card">
        <div class="card-head">
            <div class="card-title">
                <span class="ico"><i class="bi bi-shield-lock-fill"></i></span>
                <div>
                    <h2>Permintaan Reset Password</h2>
                    <p>{{ $permintaan->count() }} permintaan menunggu · pastikan permintaan benar berasal dari pemilik akun sebelum memproses</p>
                </div>
            </div>
        </div>
        <ul class="permintaan-list">
            @foreach ($permintaan as $p)
                <li>
                    <span class="avatar">{{ strtoupper(mb_substr($p->user->name, 0, 1)) }}</span>
                    <div class="info">
                        <b>{{ $p->user->name }}</b> <small>{{ $p->user->email }} · {{ $p->user->roleLabel() }}</small>
                        <small>Diminta {{ $p->created_at->diffForHumans() }}{{ $p->ip ? ' dari IP '.$p->ip : '' }}{{ $p->catatan ? ' · "'.$p->catatan.'"' : '' }}</small>
                    </div>
                    <div class="actions">
                        <form action="{{ route('admin.users.reset-password', $p->user) }}" method="POST"
                              data-confirm="Buat password sementara untuk {{ $p->user->name }}? Password lama tidak berlaku lagi.">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-key"></i> Buat Password Sementara</button>
                        </form>
                        <form action="{{ route('admin.users.permintaan.tolak', $p) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-sm">Tolak</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
@endif

<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-people-fill"></i></span>
            <div>
                <h2>Daftar Pengguna</h2>
                <p>{{ angka($users->count(), 0) }} akun · {{ angka($users->where('role', 'admin')->count(), 0) }} administrator · {{ angka($users->where('role', 'petugas')->count(), 0) }} petugas</p>
            </div>
        </div>
    </div>

    @if ($users->isEmpty())
        <x-empty icon="people" title="Belum ada pengguna" />
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th class="no">No</th>
                        <th>Pengguna</th>
                        <th>Hak Akses</th>
                        <th>Terdaftar</th>
                        <th class="r">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php($diriSendiri = auth()->id() === $user->id)
                        <tr>
                            <td class="no">{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-cell">
                                    <span class="avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                                    <div>
                                        <span class="strong">{{ $user->name }}</span>
                                        @if ($diriSendiri)<span class="badge sky" style="margin-left:6px;height:20px">Anda</span>@endif
                                        <small>{{ $user->email }}</small>
                                        @if ($user->wajib_ganti_password)
                                            <small class="wajib-ganti"><i class="bi bi-shield-exclamation"></i> Memakai password sementara</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge green"><i class="bi bi-shield-check"></i> {{ $user->roleLabel() }}</span>
                                @elseif ($user->isPetugas())
                                    <span class="badge sky"><i class="bi bi-person-badge"></i> {{ $user->roleLabel() }}</span>
                                    <small class="muted" style="display:block;font-size:12px;margin-top:4px">
                                        {{ $user->aksesBidang->map(fn ($a) => \App\Support\Bidang::labelPenugasan($a->bidang, $a->sub_bidang))->implode(', ') ?: 'Belum ditugaskan' }}
                                    </small>
                                @else
                                    <span class="badge amber" title="Role ini sudah tidak dipakai sehingga akun tidak dapat login. Ubah role-nya atau hapus akun."><i class="bi bi-question-circle"></i> {{ $user->roleLabel() }}</span>
                                @endif
                            </td>
                            <td class="muted">{{ $user->created_at?->translatedFormat('d M Y') ?? '–' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-icon" title="Ubah" aria-label="Ubah"><i class="bi bi-pencil"></i></a>
                                    @unless ($diriSendiri)
                                        <form action="{{ route('admin.users.reset-password', $user) }}" method="POST"
                                              data-confirm="Buat password sementara untuk {{ $user->name }}? Password lama tidak berlaku lagi dan pengguna wajib menggantinya saat login.">
                                            @csrf
                                            <button type="submit" class="btn btn-outline btn-icon" title="Reset password" aria-label="Reset password {{ $user->name }}"><i class="bi bi-key"></i></button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                              data-confirm="Hapus akun {{ $user->name }} ({{ $user->email }})? Tindakan ini tidak dapat dibatalkan.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline btn-icon danger" title="Hapus" aria-label="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>

@endsection
