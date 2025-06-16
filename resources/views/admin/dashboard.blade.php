@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
        📊 Manager Gudang Dashboard
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
        <!-- Total Products -->
        <div class="rounded-xl shadow-xl p-8 hover:scale-105 transition-transform duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
            <h2 class="text-xl font-semibold flex items-center space-x-3">
                <span class="text-2xl">📦</span>
                <span>Stock Menipis</span>
            </h2>
            <p class="text-5xl font-extrabold mt-6">{{ $productCount }}</p>
        </div>

        <!-- Transactions In -->
        <div class="rounded-xl shadow-xl p-8 hover:scale-105 transition-transform duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
            <h2 class="text-xl font-semibold flex items-center space-x-3">
                <span class="text-2xl">🔄</span>
                <span>Barang Masuk Hari Ini <small class="text-gray-500 dark:text-gray-400 ml-2">({{ $startDate }} - {{ $endDate }})</small></span>
            </h2>
            <p class="text-5xl font-extrabold mt-6">{{ $transactionsInCount }}</p>
        </div>

        <!-- Transactions Out -->
        <div class="rounded-xl shadow-xl p-8 hover:scale-105 transition-transform duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
            <h2 class="text-xl font-semibold flex items-center space-x-3">
                <span class="text-2xl">📤</span>
                <span>Barang Keluar Hari Ini <small class="text-gray-500 dark:text-gray-400 ml-2">({{ $startDate }} - {{ $endDate }})</small></span>
            </h2>
            <p class="text-5xl font-extrabold mt-6">{{ $transactionsOutCount }}</p>
        </div>

        <!-- Stock Graph -->
        <div class="rounded-xl shadow-xl overflow-hidden bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700">
            <div class="px-6 py-4 border-b border-gray-300 dark:border-gray-700 flex items-center justify-between">
                <h2 class="text-xl font-semibold">📈 Stock Graph</h2>
                <span class="text-sm text-gray-600 dark:text-gray-400">Updated: {{ now()->format('d M Y') }}</span>
            </div>
            <div class="p-6">
                <canvas id="stockChart" class="w-full h-56"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dates = @json($dates);
        const stockInData = @json(array_values($stockInData));
        const stockOutData = @json(array_values($stockOutData));

        function updateChartColors() {
            const isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
            return {
                stockIn: isDarkMode ? 'rgba(128, 128, 128, 0.6)' : 'rgba(128, 128, 128, 0.8)',
                stockOut: isDarkMode ? 'rgba(80, 80, 80, 0.6)' : 'rgba(80, 80, 80, 0.8)',
                legendColor: isDarkMode ? '#ddd' : '#333'
            };
        }

        const ctx = document.getElementById('stockChart').getContext('2d');
        let chartColors = updateChartColors();
        const stockChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [
                    {
                        label: 'Stock In',
                        data: stockInData,
                        backgroundColor: chartColors.stockIn,
                        borderRadius: 5,
                    },
                    {
                        label: 'Stock Out',
                        data: stockOutData,
                        backgroundColor: chartColors.stockOut,
                        borderRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: chartColors.legendColor
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true }
                }
            }
        });

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            chartColors = updateChartColors();
            stockChart.options.plugins.legend.labels.color = chartColors.legendColor;
            stockChart.data.datasets[0].backgroundColor = chartColors.stockIn;
            stockChart.data.datasets[1].backgroundColor = chartColors.stockOut;
            stockChart.update();
        });
    </script>
</div>
@endsection
