{{--
    Grafik batang lahan kritis per kecamatan.
    Parameter: $labels (daftar kecamatan), $sangat, $kritis, $agak (luas Ha per kecamatan)
--}}
@php($chartId = 'lk-' . uniqid())
<section class="card">
    <div class="card-head">
        <div class="card-title">
            <span class="ico"><i class="bi bi-bar-chart-fill"></i></span>
            <div>
                <h2>Lahan Kritis per Kecamatan</h2>
                <p>Luas lahan (Ha) berdasarkan tingkat kekritisan, dalam + luar kawasan hutan</p>
            </div>
        </div>
        <div class="legend">
            <span style="--c:#e5484d">Sangat Kritis</span>
            <span style="--c:#f5a524">Kritis</span>
            <span style="--c:#7cb82f">Agak Kritis</span>
        </div>
    </div>
    <div class="card-body">
        @if (count($labels))
            <div class="chart-box"><canvas id="{{ $chartId }}" aria-label="Grafik lahan kritis per kecamatan" role="img"></canvas></div>
        @else
            <x-empty icon="bar-chart" title="Belum ada data lahan kritis">Grafik akan muncul setelah data lahan kritis ditambahkan.</x-empty>
        @endif
    </div>
</section>

@if (count($labels))
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const W = SIKP.WARNA;
            SIKP.barChart(document.getElementById(@json($chartId)), {
                labels: @json(array_values(collect($labels)->all())),
                datasets: [
                    { label: 'Sangat Kritis', data: @json(array_values(collect($sangat)->all())), backgroundColor: W.sangatKritis },
                    { label: 'Kritis',        data: @json(array_values(collect($kritis)->all())), backgroundColor: W.kritis },
                    { label: 'Agak Kritis',   data: @json(array_values(collect($agak)->all())),   backgroundColor: W.agakKritis },
                ],
            });
        });
    </script>
    @endpush
@endif
