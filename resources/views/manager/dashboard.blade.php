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

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300">Stock Graph</h2>
        </div>
        <div class="p-4">
            <canvas id="stockChart" class="w-full h-96"></canvas>
            <div class="mt-2 flex space-x-4 text-sm font-medium text-gray-600 dark:text-gray-300">
                <div class="flex items-center space-x-1">
                    <span class="block w-4 h-4 bg-green-500 rounded"></span>
                    <span>Stock In</span>
                </div>
                <div class="flex items-center space-x-1">
                    <span class="block w-4 h-4 bg-red-500 rounded"></span>
                    <span>Stock Out</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dates = @json($dates);
            const stockInData = @json(array_values($stockInData));
            const stockOutData = @json(array_values($stockOutData));

            const ctx = document.getElementById('stockChart').getContext('2d');
            const stockChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Stock In',
                            data: stockInData,
                            borderColor: 'rgba(34, 197, 94, 1)',
                            backgroundColor: 'rgba(34, 197, 94, 0.2)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3,
                            pointHoverRadius: 6,
                        },
                        {
                            label: 'Stock Out',
                            data: stockOutData,
                            borderColor: 'rgba(239, 68, 68, 1)',
                            backgroundColor: 'rgba(239, 68, 68, 0.2)',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3,
                            pointHoverRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'nearest',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
</div>
@endsection