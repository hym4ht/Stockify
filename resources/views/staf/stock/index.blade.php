
@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Info Stok Barang</h1>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-200 text-left">Nama Barang</th>
                <th class="py-2 px-4 border-b border-gray-200 text-right">Stok</th>
                <th class="py-2 px-4 border-b border-gray-200 text-right">Barang Rusak</th>
                <th class="py-2 px-4 border-b border-gray-200 text-right">Barang Hilang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productStockInfo as $product)
            <tr>
                <td class="py-2 px-4 border-b border-gray-200">{{ $product['name'] }}</td>
                <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $product['stock'] }}</td>
                <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $product['damaged_goods'] }}</td>
                <td class="py-2 px-4 border-b border-gray-200 text-right">{{ $product['lost_goods'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
