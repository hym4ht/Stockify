@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Pengaturan Stock Minimum</h1>
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('admin.stock.settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Nama Produk</th>
                        <th class="py-2 px-4 border-b">Stock Minimum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                            <td class="py-2 px-4 border-b">
                                <input type="number" name="minimum_stock[{{ $product->id }}]"
                                    value="{{ old('minimum_stock.' . $product->id, $product->minimum_stock) }}" min="0"
                                    class="w-full border rounded px-2 py-1" required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan
                    Pengaturan</button>
            </div>
        </form>
    </div>
@endsection