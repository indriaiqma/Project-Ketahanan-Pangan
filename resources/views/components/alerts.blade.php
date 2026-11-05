{{-- Notifikasi: pesan sukses/gagal dari session dan error validasi --}}
@if (session('success'))
    <div class="alert alert-success" role="status" data-autohide>
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
        <button type="button" class="close" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-error" role="alert">
        <i class="bi bi-exclamation-octagon-fill"></i>
        <div>{{ session('error') }}</div>
        <button type="button" class="close" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-error" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <b>Periksa kembali isian Anda:</b>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="close" aria-label="Tutup"><i class="bi bi-x-lg"></i></button>
    </div>
@endif
