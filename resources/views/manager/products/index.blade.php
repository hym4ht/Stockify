@extends('layouts.dashboard')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>
        <table class="min-w-full text-left text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600">ID</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600">Nama Produk</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600">Harga</th>
                    <th class="py-3 px-4 border-b border-gray-200 dark:border-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="py-2 px-4">{{ $product->id }}</td>
                        <td class="py-2 px-4">{{ $product->name }}</td>
                        <td class="py-2 px-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('manager.products.show', $product->id) }}"
                                class="text-blue-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection