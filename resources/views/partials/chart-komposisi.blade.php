{{--
    Grafik donat komposisi tingkat kekritisan lahan.
    Parameter: $ringkasan = [['label' => ..., 'ha' => ..., 'color' => ...], ...]
--}}
@php
    $chartId = 'kp-' . uniqid();
    $totalKomposisi = collect($ringkasan)->sum('ha');
@endphp
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-pie-chart-fill"></i></span>
            <div>
                <h2>Komposisi Tingkat Kekritisan</h2>
                <p>Proporsi luas lahan per kategori</p>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($totalKomposisi > 0)
            <div class="donut">
                <div class="chart">
                    <canvas id="{{ $chartId }}" aria-label="Grafik komposisi tingkat kekritisan lahan" role="img"></canvas>
                    <div class="center"><span>Total luas</span><b>{{ angka($totalKomposisi) }}</b><span>Hektare</span></div>
                </div>
                <ul>
                    @foreach ($ringkasan as $row)
                        <li style="--c: {{ $row['color'] }}">
                            <i></i>
                            <span>{{ $row['label'] }}</span>
                            <span class="v">{{ angka($row['ha']) }} Ha</span>
                            <em>{{ angka($row['ha'] / $totalKomposisi * 100, 1) }}%</em>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <x-empty icon="pie-chart" title="Belum ada data">Komposisi akan muncul setelah data lahan kritis ditambahkan.</x-empty>
        @endif
    </div>
</section>

@if ($totalKomposisi > 0)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows = @json($ringkasan);
            SIKP.donutChart(document.getElementById(@json($chartId)), {
                labels: rows.map(r => r.label),
                data: rows.map(r => r.ha),
                colors: rows.map(r => r.color),
            });
        });
    </script>
    @endpush
@endif
