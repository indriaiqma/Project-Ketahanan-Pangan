@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')

<x-page-header compact eyebrow="Pengaturan" title="Profil Saya" description="Perbarui informasi akun dan password Anda." />

<section class="grid grid-side">
    <aside class="card">
        <div class="card-body" style="text-align:center">
            <span class="avatar lg" style="margin:0 auto">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
            <h2 style="font-size:17px;margin-top:14px">{{ $user->name }}</h2>
            <p class="muted" style="font-size:13px">{{ $user->email }}</p>
            <span class="badge green" style="margin-top:12px"><i class="bi bi-shield-check"></i> {{ $user->roleLabel() }}</span>
        </div>
        <dl class="dl" style="grid-template-columns:1fr;border-top:1px solid var(--line-soft)">
            <div style="border-right:0"><dt>Terdaftar sejak</dt><dd>{{ $user->created_at?->translatedFormat('d F Y') ?? '–' }}</dd></div>
            <div style="border-right:0;border-bottom:0"><dt>Terakhir diperbarui</dt><dd>{{ $user->updated_at?->translatedFormat('d F Y, H:i') ?? '–' }}</dd></div>
        </dl>
    </aside>

    <div class="stack">
        <form action="{{ route('admin.profile.update') }}" method="POST" class="card">
            @csrf
            @method('PUT')
            <div class="card-head">
                <div class="card-title">
                    <span class="ico"><i class="bi bi-person-fill"></i></span>
                    <div><h2>Informasi Profil</h2><p>Nama dan email untuk login</p></div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <x-field label="Nama Lengkap" name="name" :value="$user->name" required maxlength="255" icon="person" />
                    <x-field label="Email" name="email" type="email" :value="$user->email" required icon="envelope" />
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" data-loading="Menyimpan…"><i class="bi bi-check-lg"></i> Simpan Profil</button>
            </div>
        </form>

        <form action="{{ route('admin.profile.password') }}" method="POST" class="card" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card-head">
                <div class="card-title">
                    <span class="ico"><i class="bi bi-key-fill"></i></span>
                    <div><h2>Ganti Password</h2><p>Gunakan minimal 6 karakter yang sulit ditebak</p></div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <x-field label="Password Lama" name="password_lama" type="password" required icon="lock" autocomplete="current-password" class="span-2" />
                    <x-field label="Password Baru" name="password_baru" type="password" required minlength="6" icon="lock-fill" autocomplete="new-password" />
                    <x-field label="Ulangi Password Baru" name="password_baru_confirmation" type="password" required minlength="6" icon="lock-fill" autocomplete="new-password" />
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" data-loading="Menyimpan…"><i class="bi bi-shield-lock"></i> Ganti Password</button>
            </div>
        </form>
    </div>
</section>

@endsection
