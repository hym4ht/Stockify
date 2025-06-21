@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Info Stok</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 border border-green-300 dark:border-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3">Stok</th>
                        <th class="px-6 py-3 text-center">Stock Minimum</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ $product->minimum_stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
