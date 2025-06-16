@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
        📊 Stock Report
    </h1>

    @if(session('success'))
        <div class="px-4 py-3 rounded mb-4 bg-green-100 dark:bg-green-800 text-green-900 dark:text-green-100">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Form -->
    <div class="rounded-lg shadow-lg p-6 mb-6 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
        <form action="{{ route('admin.reports.stock') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Date Range -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                        class="mt-1 block w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                        class="mt-1 block w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 rounded-lg shadow 
                    bg-blue-600 dark:bg-blue-800 text-white hover:bg-blue-700 dark:hover:bg-blue-900 transition duration-300">
                    🔍 Filter Report
                </button>
            </div>
        </form>
    </div>

    <!-- Stock Report Table -->
    <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
        <table class="min-w-full">
            <thead class="bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white text-lg">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">#</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Product Name</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Stock In</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Stock Out</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Remaining Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stockData as $stock)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white">{{ $stock->product->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-green-600 dark:text-green-400 font-semibold">{{ $stock->stock_in }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-red-600 dark:text-red-400 font-semibold">{{ $stock->stock_out }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white font-semibold">{{ $stock->remaining_stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
