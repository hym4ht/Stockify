@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4 text-black dark:text-white">Suppliers</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-400 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-black dark:text-white">Name</th>
                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-black dark:text-white">Contact Name</th>
                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-black dark:text-white">Phone</th>
                <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-black dark:text-white">Products Supplied</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $supplier)
                <tr class="text-black dark:text-white">
                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $supplier->name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $supplier->contact_name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $supplier->phone }}</td>
                    <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                        @foreach($supplier->products as $product)
                            <div>{{ $product->name }}</div>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-500 dark:text-gray-400">No suppliers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
