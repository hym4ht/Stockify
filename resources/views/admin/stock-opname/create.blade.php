@extends('layouts.dashboard')

@section('content')
    <h1 class="text-xl font-bold mb-4">Tambah Stock Opname</h1>

    <form action="{{ route('admin.stock-opname.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="product_id">Produk</label>
            <select name="product_id" id="product_id" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="qty_actual">Qty Aktual</label>
            <input type="number" name="qty_actual" id="qty_actual" required min="0">
        </div>
        <div>
            <label for="notes">Catatan (opsional)</label>
            <textarea name="notes" id="notes" rows="3"></textarea>
        </div>
        <button type="submit">Simpan</button>
    </form>
@endsection
