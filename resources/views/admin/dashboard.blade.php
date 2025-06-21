@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Admin Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div
                class="rounded-xl shadow-xl p-8 flex flex-col justify-center hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-3">
                    <span class="text-2xl">📦</span>
                    <span>Total Products</span>
                </h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-auto">{{ $productCount }}</p>
            </div>
            <div
                class="rounded-xl shadow-xl p-8 flex flex-col justify-center hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-3">
                    <span class="text-2xl">🔄</span>
                    <span>Transactions In ({{ $startDate }} - {{ $endDate }})</span>
                </h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-auto">{{ $transactionsInCount }}</p>
            </div>
            <div
                class="rounded-xl shadow-xl p-8 flex flex-col justify-center hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-3">
                    <span class="text-2xl">📤</span>
                    <span>Transactions Out ({{ $startDate }} - {{ $endDate }})</span>
                </h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-auto">{{ $transactionsOutCount }}</p>
            </div>
        </div>

        <div class="mb-6">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap gap-4 items-center">
                <div class="w-full sm:w-auto">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                        Date:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                </div>
                <div class="w-full sm:w-auto">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End
                        Date:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                </div>
                <div class="w-full sm:w-auto">
                    <label for="product_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product
                        Name:</label>
                    <select id="product_name" name="product_name"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                        <option value="">All Products</option>
                        @foreach ($productNames as $productName)
                            <option value="{{ $productName }}" @if ($productName === $productNameFilter) selected @endif>
                                {{ $productName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Filter</button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-6">
            <div class="flex flex-col md:flex-row gap-6 items-stretch">
                <!-- Stock Graph -->
                <div class="flex-1 flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300">Stock Graph</h2>
                    </div>
                    <div class="p-4 flex-grow flex flex-col justify-end">
                        <canvas id="stockChart" class="w-full h-[30rem] min-h-[30rem]"></canvas>
                        <div class="mt-2 flex space-x-4 text-sm font-medium text-gray-600 dark:text-gray-300">
                            <div class="flex items-center space-x-1">
                                <span class="block w-4 h-4 bg-blue-500 rounded"></span>
                                <span>Stock In</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <span class="block w-4 h-4 bg-red-500 rounded"></span>
                                <span>Stock Out</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="flex-1 flex flex-col bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300">Stock Info</h2>
                    </div>
                    <div class="p-4 flex-grow flex flex-col justify-center">
                        <canvas id="stockInfoPieChart"
                            class="w-full h-[20rem] min-h-[20rem] sm:h-[25rem] sm:min-h-[25rem] md:h-[30rem] md:min-h-[30rem]"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div>
            <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Recent User Activities</h2>
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow text-center align-middle">
                    <thead>
                        <tr>
                            <th class="py-2 px-2 border-b text-gray-900 dark:text-white text-center">Confirmed By</th>
                            <th class="py-2 px-4 border-b text-gray-900 dark:text-white text-center">Product</th>
                            <th class="py-2 px-4 border-b text-gray-900 dark:text-white text-center">Type</th>
                            <th class="py-2 px-2 border-b text-gray-900 dark:text-white text-center">Date</th>
                            <th class="py-2 px-4 border-b text-gray-900 dark:text-white text-center">Barang Fisik</th>
                            <th class="py-2 px-4 border-b text-gray-900 dark:text-white text-center">Barang Rusak/Hilang
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentActivities as $activity)
                            <tr>
                                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300 text-center align-middle">
                                    {{ $activity->confirmedBy->name ?? 'N/A' }}
                                </td>
                                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300 text-center align-middle">
                                    {{ $activity->product->name ?? 'N/A' }}
                                </td>
                                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300 text-center align-middle">
                                    {{ ucfirst($activity->type) }}
                                </td>
                                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300 text-center align-middle">
                                    {{ $activity->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300 text-center align-middle">
                                    {{ $activity->physical_count }}
                                </td>
                                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300 text-center align-middle">
                                    {{ $activity->damaged_lost_goods }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $recentActivities->links('pagination::tailwind') }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dates = JSON.parse('{!! addslashes(json_encode($dates)) !!}');
                const stockInData = JSON.parse('{!! addslashes(json_encode(array_values($stockInData))) !!}');
                const stockOutData = JSON.parse('{!! addslashes(json_encode(array_values($stockOutData))) !!}');

                const ctx = document.getElementById('stockChart').getContext('2d');

                // Create gradient fills for the datasets
                const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
                gradientBlue.addColorStop(0, 'rgba(0, 123, 255, 0.9)');
                gradientBlue.addColorStop(0.5, 'rgba(0, 123, 255, 0.4)');
                gradientBlue.addColorStop(1, 'rgba(0, 123, 255, 0)');

                const gradientRed = ctx.createLinearGradient(0, 0, 0, 400);
                gradientRed.addColorStop(0, 'rgba(220, 38, 38, 0.9)');
                gradientRed.addColorStop(0.5, 'rgba(220, 38, 38, 0.5)');
                gradientRed.addColorStop(1, 'rgba(220, 38, 38, 0)');

                const stockChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [
                            {
                                label: 'Stock In',
                                data: stockInData,
                                borderColor: 'rgb(0, 192, 246)',
                                backgroundColor: gradientBlue,
                                fill: true,
                                tension: 0,
                                pointRadius: 3,
                                pointHoverRadius: 6,
                                borderWidth: 2
                            },
                            {
                                label: 'Stock Out',
                                data: stockOutData,
                                borderColor: 'rgba(239, 68, 68, 1)',
                                backgroundColor: gradientRed,
                                fill: true,
                                tension: 0,
                                pointRadius: 3,
                                pointHoverRadius: 6,
                                borderWidth: 2
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
                                    stepSize: 1,
                                    font: {
                                        size: 7
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                    font: {
                                        size: 8
                                    }
                                }
                            }
                        }
                    }

                });

                // Pie chart data
                const pieCtx = document.getElementById('stockInfoPieChart').getContext('2d');
                const pieDataRaw = JSON.parse('{!! addslashes(json_encode($pieChartData)) !!}');

                // Aggregate totals for physical count and damaged lost goods
                let totalPhysicalCount = 0;
                let totalDamagedLostGoods = 0;

                pieDataRaw.forEach(item => {
                    totalPhysicalCount += item.physical_count;
                    totalDamagedLostGoods += item.damaged_lost_goods;
                });

                const pieChart = new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: ['Physical Count', 'Damaged/Lost'],
                        datasets: [{
                            data: [totalPhysicalCount, totalDamagedLostGoods],
                            backgroundColor: ['#0FFF50', '#FF5733'],
                            hoverOffset: 40
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                align: 'center', 
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'rect', 
                                    boxWidth: 12,
                                    boxHeight: 12,
                                    padding: 16,
                                    color: '#4B5563', 
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    label: function (context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        return `${label}: ${value.toLocaleString()}`;
                                    }
                                }
                            }
                        }
                    }
                });
                setTimeout(() => {
                    stockChart.resize();
                    pieChart.resize();
                }, 100);

            });
        </script>
    </div>
@endsection