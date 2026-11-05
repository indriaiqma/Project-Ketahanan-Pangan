{{--
    Grafik batang luas kawasan hutan per kecamatan.
    Parameter: $labels (daftar kecamatan), $values (luas Ha)
--}}
@php($chartId = 'kh-' . uniqid())
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-bar-chart-fill"></i></span>
            <div>
                <h2>Luas Kawasan Hutan per Kecamatan</h2>
                <p>Total luas kawasan hutan (Ha) di setiap kecamatan</p>
            </div>
        </div>
        <span class="badge green">Hektare</span>
    </div>
    <div class="card-body">
        @if (count($labels))
            <div class="chart-box"><canvas id="{{ $chartId }}" aria-label="Grafik luas kawasan hutan per kecamatan" role="img"></canvas></div>
        @else
            <x-empty icon="bar-chart" title="Belum ada data kawasan hutan">Grafik akan muncul setelah data kawasan hutan ditambahkan.</x-empty>
        @endif
    </div>
</section>

@if (count($labels))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            SIKP.barChart(document.getElementById(@json($chartId)), {
                labels: @json(array_values(collect($labels)->all())),
                datasets: [{ label: 'Luas kawasan', data: @json(array_values(collect($values)->all())) }],
            });
        });
    </script>
    @endpush
@endif
