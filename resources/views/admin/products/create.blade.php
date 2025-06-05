@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Create New Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('name') border-red-500 @enderror" />
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
                <option value="">Select Category</option>
                @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="supplier_id" class="block text-gray-700 font-bold mb-2">Supplier</label>
            <select name="supplier_id" id="supplier_id" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('supplier_id') border-red-500 @enderror">
                <option value="">Select Supplier</option>
                @foreach(\App\Models\Supplier::all() as $supplier)
                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
                @endforeach
            </select>
            @error('supplier_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="sku" class="block text-gray-700 font-bold mb-2">SKU</label>
            <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 @error('sku') border-red-500 @enderror" />
            @error('sku')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" id="description"
                class="w-full border border-gray-300 rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-bold mb-2">Price</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('price') border-red-500 @enderror" />
            @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-700 font-bold mb-2">Stock</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" min="0" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('stock') border-red-500 @enderror" />
            @error('stock')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Product</button>
    </form>
</div>
@endsection
