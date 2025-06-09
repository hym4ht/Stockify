@extends('layouts.dashboard')

@section('content')
<div class="p-4 max-w-lg mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Opname Keluar</h1>
    <form method="POST" action="{{ route('stock.opname.keluar.store') }}">
        @csrf
        <div class="mb-4">
            <label for="product_id" class="block font-semibold mb-1">Produk</label>
            <select name="product_id" id="product_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Pilih produk</option>
                @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
                @endforeach
            </select>
            @error('product_id')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="quantity" class="block font-semibold mb-1">Jumlah</label>
            <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity') }}" class="w-full border border-gray-300 rounded px-3 py-2" />
            @error('quantity')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">Keterangan (opsional)</label>
            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>
@endsection