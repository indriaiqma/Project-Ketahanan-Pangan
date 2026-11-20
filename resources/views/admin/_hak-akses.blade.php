{{-- Kartu "Hak Akses Anda" di dashboard. Parameter: $user, $hakAkses ([[fitur, boleh], ...]) --}}
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-key-fill"></i></span>
            <div><h2>Hak Akses Anda</h2><p>Sebagai {{ $user->roleLabel() }}</p></div>
        </div>
    </div>
    <ul class="perm-list">
        @foreach ($hakAkses as [$fitur, $boleh])
            <li @class(['yes' => $boleh, 'no' => ! $boleh])>
                <i class="bi bi-{{ $boleh ? 'check-circle-fill' : 'x-circle' }}"></i>
                <span>{{ $fitur }}</span>
            </li>
        @endforeach
    </ul>
    @unless ($user->isAdmin())
        <div class="card-foot">Perlu akses lebih? Hubungi Administrator sistem.</div>
    @endunless
</section>
