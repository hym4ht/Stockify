@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Create New Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 @error('name') border-red-500 @enderror" />
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Category</label>
            <select name="category_id" id="category_id" required
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 @error('category_id') border-red-500 @enderror">
                <option value="" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">Select Category</option>
                @foreach(\App\Models\Category::all() as $category)
                <option value="{{ $category->id }}" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="supplier_id" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Supplier</label>
            <select name="supplier_id" id="supplier_id" required
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 @error('supplier_id') border-red-500 @enderror">
                <option value="" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">Select Supplier</option>
                @foreach(\App\Models\Supplier::all() as $supplier)
                <option value="{{ $supplier->id }}" class="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
                @endforeach
            </select>
            @error('supplier_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="sku" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">SKU</label>
            <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 @error('sku') border-red-500 @enderror" />
            @error('sku')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Description</label>
            <textarea name="description" id="description"
                class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Price</label>
            <div class="flex">
                <span class="inline-flex items-center px-3 rounded-l border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm">Rp</span>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-r px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 @error('price') border-red-500 @enderror" />
            </div>
            @error('price')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="harga_jual" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Harga Jual</label>
            <div class="flex">
                <span class="inline-flex items-center px-3 rounded-l border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm">Rp</span>
                <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" step="0.01" min="0" required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-r px-3 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 @error('harga_jual') border-red-500 @enderror" />
            </div>
            @error('harga_jual')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-blue-600 dark:bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-700 dark:hover:bg-blue-800">Create Product</button>
    </form>
</div>

<script>
    let attributeIndex = 1;

    function addAttributeRow() {
        const container = document.getElementById('attributes-container');
        const newRow = document.createElement('div');
        newRow.classList.add('flex', 'mb-2', 'attribute-row');
        newRow.innerHTML = `
            <input type="text" name="attributes[\${attributeIndex}][name]" placeholder="Attribute Name" class="border border-gray-300 rounded px-3 py-2 mr-2 w-1/2" />
            <input type="text" name="attributes[\${attributeIndex}][value]" placeholder="Attribute Value" class="border border-gray-300 rounded px-3 py-2 w-1/2" />
            <button type="button" onclick="removeAttributeRow(this)" class="ml-2 text-red-600 hover:text-red-800 font-bold">Remove</button>
        `;
        container.appendChild(newRow);
        attributeIndex++;
    }

    function removeAttributeRow(button) {
        const row = button.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
@endsection