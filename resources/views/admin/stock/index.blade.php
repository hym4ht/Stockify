@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Stock Transactions</h1>

    @if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('admin.stock.create') }}" class="bg-blue-600 text-white font-bold py-2 px-4 rounded mb-4 inline-block hover:bg-blue-800 focus:bg-blue-800 transition duration-300 ease-in-out bg-opacity-100">Add Transaction</a>

    <table class="min-w-full border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Product</th>
                <th class="py-2 px-4 border-b">Type</th>
                <th class="py-2 px-4 border-b">Quantity</th>
                <th class="py-2 px-4 border-b">Description</th>
                <th class="py-2 px-4 border-b">User</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Created At</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td class="py-2 px-4 border-b">{{ $transaction->id }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->product->name ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b capitalize">{{ $transaction->type }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->quantity }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->description }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->user->name ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b capitalize">{{ $transaction->status ?? 'pending' }}</td>
                <td class="py-2 px-4 border-b">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.stock.edit', $transaction->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('admin.stock.destroy', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection