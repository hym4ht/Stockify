@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Products</h1>
    <div class="mb-4">
        <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create New Product</a>
    </div>
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 dark:bg-gray-800 dark:text-gray-400">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-white">Name</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-white">Price</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-white">Category</th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-white text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100 dark:divide-gray-700 dark:border-gray-700">
                @forelse ($products as $product)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">{{ $product->name }}</td>
                    <td class="px-6 py-4">Rp {{ number_format($product->price, 2) }}</td>
                    <td class="px-6 py-4">{{ $product->category->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:underline mr-4">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection