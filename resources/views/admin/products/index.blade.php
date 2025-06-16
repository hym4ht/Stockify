@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
        📦 Product List
    </h1>

    @if(session('success'))
        <div class="px-4 py-3 rounded mb-4 bg-green-100 dark:bg-green-800 text-green-900 dark:text-green-100">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="px-4 py-3 rounded mb-4 bg-red-100 dark:bg-red-800 text-red-900 dark:text-red-100">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    

    <div class="overflow-x-auto rounded-lg shadow-lg">
        <table class="min-w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-lg">
            <thead>
                <tr class="bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white text-lg">
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">#</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Name</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Stock</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Price</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white">{{ $product->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white">{{ $product->stock }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-green-600 dark:text-green-400 font-semibold">{{ number_format($product->price, 2) }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4">
                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                               class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">✏️ Edit</a> |
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:underline font-semibold">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
