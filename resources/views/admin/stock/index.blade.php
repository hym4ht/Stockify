@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
        📥 Transactions - Incoming Stock
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

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('admin.stock.create') }}" class="px-4 py-2 rounded-lg shadow-lg 
            bg-blue-600 dark:bg-blue-800 text-white hover:bg-blue-700 dark:hover:bg-blue-900 transition duration-300">
            ➕ Add New Transaction
        </a>
    </div>

    <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
        <table class="min-w-full">
            <thead class="bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white text-lg">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">#</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Product Name</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Supplier</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Quantity Received</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Date Received</th>
                    <th class="border border-gray-300 dark:border-gray-700 px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white font-medium">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white">{{ $transaction->product->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-900 dark:text-white">{{ $transaction->supplier->name }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-green-600 dark:text-green-400 font-semibold">{{ $transaction->quantity }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4 text-gray-600 dark:text-gray-300">{{ $transaction->date_received->format('d M Y') }}</td>
                        <td class="border border-gray-300 dark:border-gray-700 px-6 py-4">
                            <a href="{{ route('admin.stock.edit', $transaction->id) }}" 
                               class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">✏️ Edit</a> |
                            <form action="{{ route('admin.stock.destroy', $transaction->id) }}" method="POST" style="display: inline;">
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
