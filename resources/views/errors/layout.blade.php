<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('code') · @yield('title')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    @vite(['resources/css/app.css'])
</head>
<body>
    <main style="min-height:100vh;display:grid;place-content:center;justify-items:center;gap:24px;padding:24px">
        <a href="{{ url('/') }}" aria-label="Ke beranda"><x-brand /></a>
        <div class="card" style="max-width:480px;width:100%">
            <div class="empty" style="padding:44px 32px">
                <div class="ico"><i class="bi bi-@yield('icon', 'exclamation-circle')"></i></div>
                <div class="muted" style="font-size:13px;font-weight:600;letter-spacing:.08em">KODE @yield('code')</div>
                <h3 style="font-size:20px;margin-top:6px">@yield('title')</h3>
                <p>@yield('message')</p>
                <div style="display:flex;gap:10px;justify-content:center;margin-top:22px;flex-wrap:wrap">
                    <a href="javascript:history.back()" class="btn btn-outline"><i class="bi bi-arrow-left"></i> Kembali</a>
                    <a href="{{ url('/') }}" class="btn btn-primary"><i class="bi bi-house"></i> Ke Beranda</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
