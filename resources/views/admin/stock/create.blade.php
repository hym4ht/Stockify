@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
        📤 Transactions - Outgoing Stock
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

    <div class="rounded-lg shadow-lg p-6 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
        <form action="{{ route('admin.stock.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Selection -->
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Name</label>
                    <select name="product_id" id="product_id" class="mt-1 block w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity Out</label>
                    <input type="number" name="quantity" id="quantity" min="1" required 
                        class="mt-1 block w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2">
                </div>

                <!-- Destination -->
                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Destination</label>
                    <input type="text" name="destination" id="destination" required 
                        class="mt-1 block w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2">
                </div>

                <!-- Date -->
                <div>
                    <label for="date_out" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Transaction Date</label>
                    <input type="date" name="date_out" id="date_out" required 
                        class="mt-1 block w-full bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-4 py-2 rounded-lg shadow 
                    bg-red-600 dark:bg-red-800 text-white hover:bg-red-700 dark:hover:bg-red-900 transition duration-300">
                    📤 Save Transaction
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
