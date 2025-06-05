@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Edit Stock Transaction</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.stock.update', $transaction->id) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="product_id" class="block font-semibold mb-1">Product</label>
            <select name="product_id" id="product_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Select a product</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}" {{ (old('product_id', $transaction->product_id) == $product->id) ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="type" class="block font-semibold mb-1">Type</label>
            <select name="type" id="type" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Select type</option>
                <option value="in" {{ (old('type', $transaction->type) == 'in') ? 'selected' : '' }}>In</option>
                <option value="out" {{ (old('type', $transaction->type) == 'out') ? 'selected' : '' }}>Out</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="quantity" class="block font-semibold mb-1">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', $transaction->quantity) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block font-semibold mb-1">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $transaction->description) }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Transaction</button>
        <a href="{{ route('admin.stock.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection