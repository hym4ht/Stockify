@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Stock Transactions</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="py-3 px-4 border-b text-left">Product</th>
                    <th class="py-3 px-4 border-b text-left">Type</th>
                    <th class="py-3 px-4 border-b text-left">Quantity</th>
                    <th class="py-3 px-4 border-b text-left">User</th>
                    <th class="py-3 px-4 border-b text-left">Status</th>
                    <th class="py-3 px-4 border-b text-left">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="py-2 px-4 border-b">{{ $transaction->product->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b capitalize">{{ $transaction->type }}</td>
                        <td class="py-2 px-4 border-b">{{ $transaction->quantity }}</td>
                        <td class="py-2 px-4 border-b">{{ $transaction->user->name ?? 'N/A' }}</td>
                        <td class="py-2 px-4 border-b capitalize">{{ $transaction->status ?? 'pending' }}</td>
                        <td class="py-2 px-4 border-b">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
