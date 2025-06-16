@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Add Stock Transaction</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.stock.store') }}" method="POST" class="bg-white dark:bg-gray-700 p-6 rounded shadow-md max-w-lg">
        @csrf

        <div class="mb-4">
            <label for="product_id" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Product</label>
            <select name="product_id" id="product_id" class="w-full p-2 border border-gray-300 rounded dark:bg-gray-800 dark:text-gray-200" required>
                <option value="">Select a product</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="type" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Type</label>
            <select name="type" id="type" class="w-full p-2 border border-gray-300 rounded dark:bg-gray-800 dark:text-gray-200" required>
                <option value="">Select type</option>
                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>In</option>
                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Out</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="quantity" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity') }}" class="w-full p-2 border border-gray-300 rounded dark:bg-gray-800 dark:text-gray-200" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Description (optional)</label>
            <textarea name="description" id="description" rows="3" class="w-full p-2 border border-gray-300 rounded dark:bg-gray-800 dark:text-gray-200">{{ old('description') }}</textarea>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Add Stock Transaction
            </button>
        </div>
    </form>
</div>
@endsection
