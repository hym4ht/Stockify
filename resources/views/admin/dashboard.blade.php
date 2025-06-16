@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Admin Dashboard</h1>
        <p>Selamat datang di dashboard Admin. Di sini Anda dapat mengelola produk, stok, pengguna, dan laporan.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300">Total Products</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $productCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300">Transactions In ({{ $startDate }} - {{ $endDate }})</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $transactionsInCount }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300">Transactions Out ({{ $startDate }} - {{ $endDate }})</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $transactionsOutCount }}</p>
            </div>
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

        <div class="mb-6">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap gap-4 items-center">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                </div>
                <div class="pt-6">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Filter</button>
                </div>
            </form>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Recent User Activities</h2>
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-gray-900 dark:text-white">User</th>
                        <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Product</th>
                        <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Type</th>
                        <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Quantity</th>
                        <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentActivities as $activity)
                    <tr>
                        <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->user->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->product->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ ucfirst($activity->type) }}</td>
                        <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->quantity }}</td>
                        <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                                borderColor: 'rgba(34, 197, 94, 1)', // green
                                backgroundColor: 'rgba(34, 197, 94, 0.2)',
                                fill: true,
                                tension: 0.3,
                                pointRadius: 3,
                                pointHoverRadius: 6,
                            },
                            {
                                label: 'Stock Out',
                                data: stockOutData,
                                borderColor: 'rgba(239, 68, 68, 1)', // red
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
