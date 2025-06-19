@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
        📊 Manager Gudang Dashboard
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 mb-10">
        <!-- Total Products -->
        <div class="rounded-2xl shadow-2xl p-12 hover:scale-110 transition-transform duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
            <h2 class="text-2xl font-bold flex items-center space-x-4">
                <span class="text-3xl">📦</span>
                <span>Stock Menipis</span>
            </h2>
            <p class="text-7xl font-extrabold mt-8">{{ $productCount }}</p>
        </div>

        <!-- Transactions In -->
        <div class="rounded-2xl shadow-2xl p-12 hover:scale-110 transition-transform duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
            <h2 class="text-2xl font-bold flex items-center space-x-4">
                <span class="text-3xl">🔄</span>
                <span>Barang Masuk Hari Ini <small class="text-gray-500 dark:text-gray-400 ml-3">({{ $startDate }} - {{ $endDate }})</small></span>
            </h2>
            <p class="text-7xl font-extrabold mt-8">{{ $transactionsInCount }}</p>
        </div>

        <!-- Transactions Out -->
        <div class="rounded-2xl shadow-2xl p-12 hover:scale-110 transition-transform duration-300
                    bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
            <h2 class="text-2xl font-bold flex items-center space-x-4">
                <span class="text-3xl">📤</span>
                <span>Barang Keluar Hari Ini <small class="text-gray-500 dark:text-gray-400 ml-3">({{ $startDate }} - {{ $endDate }})</small></span>
            </h2>
            <p class="text-7xl font-extrabold mt-8">{{ $transactionsOutCount }}</p>
        </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-10 col-span-full">
        <div class="px-6 py-3 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300">Stock Graph</h2>
        </div>
        <div class="p-6">
            <canvas id="stockChart" class="w-full h-[50rem]"></canvas>
            <div class="mt-4 flex space-x-6 text-base font-semibold text-gray-600 dark:text-gray-300">
                <div class="flex items-center space-x-2">
                    <span class="block w-5 h-5 bg-green-500 rounded"></span>
                    <span>Stock In</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="block w-5 h-5 bg-red-500 rounded"></span>
                    <span>Stock Out</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dates = @json($dates);
            const stockInData = @json(array_values($stockInData));

            const ctx = document.getElementById('stockChart').getContext('2d');
            const stockChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Stock In',
                            data: stockInData,
                            backgroundColor: 'rgba(34, 197, 94, 0.7)',
                            borderColor: 'rgba(34, 197, 94, 1)',
                            borderWidth: 1,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            enabled: true,
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });
        });
    </script>
</div>
@endsection
