@extends('layouts.dashboard')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Detail Produk</h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded p-6">
            <table class="min-w-full text-left text-gray-900 dark:text-gray-100">
                <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="py-3 px-4 font-semibold w-48">ID</th>
                        <td class="py-3 px-4">{{ $product->id }}</td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="py-3 px-4 font-semibold">Nama Produk</th>
                        <td class="py-3 px-4">{{ $product->name }}</td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="py-3 px-4 font-semibold">Harga</th>
                        <td class="py-3 px-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="py-3 px-4 font-semibold">SKU</th>
                        <td class="py-3 px-4">{{ $product->sku ?? '-' }}</td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="py-3 px-4 font-semibold">Sisa Stock</th>
                        <td class="py-3 px-4">{{ $product->stock ?? 0 }}</td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="py-3 px-4 font-semibold">Atribut Produk</th>
                        <td class="py-3 px-4">
                            @if($product->attributes && $product->attributes->count() > 0)
                                <ul class="list-disc list-inside">
                                    @foreach($product->attributes as $attribute)
                                        <li>{{ $attribute->name }}: {{ $attribute->value }}</li>
                                    @endforeach
                                </ul>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <!-- Add more product fields as needed -->
                </tbody>
            </table>
        </div>
        <a href="{{ route('manager.products.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Kembali ke
            Daftar Produk</a>
    </div>
@endsection