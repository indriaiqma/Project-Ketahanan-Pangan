
/* =====================================================
   DASHBOARD VIEWER - CHART.JS
===================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('grafikLahanKritis');
    const emptyMessage = document.getElementById('grafikKosong');

    if (!canvas) {
        return;
    }

    const chartData = window.dashboardViewerData || {};

    const labels = Array.isArray(chartData.labels)
        ? chartData.labels
        : [];

    const values = Array.isArray(chartData.values)
        ? chartData.values
        : [];

    function showEmptyMessage(message) {
        canvas.hidden = true;

        if (emptyMessage) {
            emptyMessage.textContent = message;
            emptyMessage.hidden = false;
        }
    }

    function showChart() {
        canvas.hidden = false;

        if (emptyMessage) {
            emptyMessage.hidden = true;
        }
    }

    // Pastikan data label dan nilai tersedia.
    if (labels.length === 0 || values.length === 0) {
        showEmptyMessage(
            'Belum ada data lahan kritis untuk ditampilkan.'
        );
        return;
    }

    // Panjang label dan nilai harus sesuai.
    if (labels.length !== values.length) {
        showEmptyMessage(
            'Data grafik belum sesuai. Periksa data dari database.'
        );
        console.error(
            'Jumlah label dan nilai grafik tidak sama.',
            { labels, values }
        );
        return;
    }

    // Pastikan Chart.js sudah tersedia.
    if (typeof Chart === 'undefined') {
        showEmptyMessage(
            'Grafik gagal dimuat. Periksa koneksi internet dan Chart.js.'
        );
        console.error('Chart.js tidak ditemukan.');
        return;
    }

    const numericValues = values.map(function (value) {
        return Number(value);
    });

    // Jangan menggambar grafik jika nilainya tidak valid.
    if (numericValues.some(function (value) {
        return !Number.isFinite(value);
    })) {
        showEmptyMessage(
            'Nilai data grafik tidak valid. Periksa data dari database.'
        );
        return;
    }

    showChart();

    // Hindari membuat grafik ganda.
    const existingChart = Chart.getChart(canvas);

    if (existingChart) {
        existingChart.destroy();
    }

    new Chart(canvas, {
        type: 'bar',

        data: {
            labels: labels,

            datasets: [{
                label: 'Luas Lahan Kritis (Ha)',
                data: numericValues,

                backgroundColor: 'rgba(62, 139, 94, 0.78)',
                hoverBackgroundColor: '#245B47',
                borderColor: '#3E8B5E',
                borderWidth: 1,

                borderRadius: 6,
                borderSkipped: false,
                maxBarThickness: 46,
                categoryPercentage: 0.72,
                barPercentage: 0.82
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            interaction: {
                intersect: false,
                mode: 'index'
            },

            animation: {
                duration: 650
            },

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    backgroundColor: '#173F31',
                    titleColor: '#FFFFFF',
                    bodyColor: '#FFFFFF',
                    padding: 12,
                    displayColors: false,

                    callbacks: {
                        label: function (context) {
                            const value = Number(context.raw || 0);

                            return 'Luas: ' +
                                value.toLocaleString('id-ID') +
                                ' Ha';
                        }
                    }
                }
            },

            scales: {
                y: {
                    beginAtZero: true,

                    grid: {
                        color: '#E8EFEA'
                    },

                    border: {
                        display: false
                    },

                    ticks: {
                        color: '#748278',
                        padding: 10,

                        callback: function (value) {
                            return Number(value).toLocaleString('id-ID');
                        },

                        font: {
                            size: 11
                        }
                    }
                },

                x: {
                    grid: {
                        display: false
                    },

                    border: {
                        display: false
                    },

                    ticks: {
                        color: '#748278',
                        maxRotation: 35,
                        minRotation: 0,
                        autoSkip: true,

                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
});
