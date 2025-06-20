@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
            📊 Manager Gudang Dashboard
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div
                class="rounded-xl shadow-xl p-8 flex flex-col justify-center hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-3">
                    <span class="text-2xl">📦</span>
                    <span>Stock Menipis</span>
                </h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-auto">{{ $productCount }}</p>
                @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                    <ul class="mt-4 list-disc list-inside text-sm text-gray-700 dark:text-gray-300 max-h-48 overflow-y-auto">
                        @foreach($lowStockProducts as $product)
                            <li>{{ $product->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Tidak ada produk dengan stock menipis.</p>
                @endif
            </div>

            <div
                class="rounded-xl shadow-xl p-8 flex flex-col justify-center hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-3">
                    <span class="text-2xl">🔄</span>
                    <span>Barang Masuk Hari Ini <small class="text-gray-500 dark:text-gray-400 ml-3">({{ $startDate }} -
                            {{ $endDate }})</small></span>
                </h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-auto">{{ $transactionsInCount }}</p>
            </div>

            <div
                class="rounded-xl shadow-xl p-8 flex flex-col justify-center hover:scale-105 transition-transform duration-300 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-300 flex items-center space-x-3">
                    <span class="text-2xl">📤</span>
                    <span>Barang Keluar Hari Ini <small class="text-gray-500 dark:text-gray-400 ml-3">({{ $startDate }} -
                            {{ $endDate }})</small></span>
                </h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-auto">{{ $transactionsOutCount }}</p>
            </div>

        </div>
@endsection