@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Laporan Stok Produk</h1>

    @if($products->isEmpty())
        <p>Tidak ada produk untuk ditampilkan.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-1 px-3 border-b text-left">Nama Produk</th>
                    <th class="py-1 px-3 border-b text-left">Kategori</th>
                    <th class="py-1 px-3 border-b text-right">Sisa Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td class="py-1 px-3 border-b">{{ $product->name }}</td>
                        <td class="py-1 px-3 border-b">{{ $product->category->name ?? 'Tidak ada kategori' }}</td>
                        <td class="py-1 px-3 border-b text-right">{{ $product->remaining_stock }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
