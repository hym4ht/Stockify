@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Product Attribute</h1>

    <form action="{{ route('admin.product_attributes.update', $productAttribute) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="product_id" class="block text-gray-700 font-bold mb-2">Product</label>
            <select name="product_id" id="product_id" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('product_id') border-red-500 @enderror">
                <option value="">Select Product</option>
                @foreach(\App\Models\Product::all() as $product)
                <option value="{{ $product->id }}" {{ old('product_id', $productAttribute->product_id) == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
                @endforeach
            </select>
            @error('product_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Attribute Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $productAttribute->name) }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('name') border-red-500 @enderror" />
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="value" class="block text-gray-700 font-bold mb-2">Attribute Value</label>
            <input type="text" name="value" id="value" value="{{ old('value', $productAttribute->value) }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('value') border-red-500 @enderror" />
            @error('value')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Attribute</button>
    </form>
</div>
@endsection