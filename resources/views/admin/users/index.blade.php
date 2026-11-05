@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')

<x-page-header compact eyebrow="Pengaturan" title="Kelola Pengguna" description="Atur akun yang dapat mengakses sistem beserta hak aksesnya.">
    <x-slot:actions>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Tambah Pengguna</a>
    </x-slot:actions>
</x-page-header>

<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-people-fill"></i></span>
            <div>
                <h2>Daftar Pengguna</h2>
                <p>{{ angka($users->count(), 0) }} akun · {{ angka($users->where('role', 'admin')->count(), 0) }} administrator · {{ angka($users->where('role', 'petugas')->count(), 0) }} petugas · {{ angka($users->where('role', 'viewer')->count(), 0) }} viewer</p>
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
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge green"><i class="bi bi-shield-check"></i> {{ $user->roleLabel() }}</span>
                                @elseif ($user->isPetugas())
                                    <span class="badge sky"><i class="bi bi-person-badge"></i> {{ $user->roleLabel() }}</span>
                                @elseif ($user->isViewer())
                                    <span class="badge"><i class="bi bi-eye"></i> {{ $user->roleLabel() }}</span>
                                @else
                                    <span class="badge amber" title="Role tidak dikenal, akun ini tidak dapat login"><i class="bi bi-question-circle"></i> {{ $user->roleLabel() }}</span>
                                @endif
                            </td>
                            <td class="muted">{{ $user->created_at?->translatedFormat('d M Y') ?? '–' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-icon" title="Ubah" aria-label="Ubah"><i class="bi bi-pencil"></i></a>
                                    @unless ($diriSendiri)
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
