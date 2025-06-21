@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Pengaturan Stock Minimum</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.stock.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-left text-gray-900 dark:text-gray-100">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Nama Produk</th>
                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Stock Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                {{ $product->name }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                <input
                                    type="number"
                                    name="minimum_stock[{{ $product->id }}]"
                                    value="{{ old('minimum_stock.' . $product->id, $product->minimum_stock) }}"
                                    min="0"
                                    required
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded px-2 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                >
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
