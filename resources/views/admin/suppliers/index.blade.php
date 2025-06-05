@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Suppliers</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.suppliers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Supplier
        </a>
    </div>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Contact Name</th>
                <th class="py-2 px-4 border-b">Phone</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Address</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $supplier->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $supplier->contact_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $supplier->phone }}</td>
                    <td class="py-2 px-4 border-b">{{ $supplier->email }}</td>
                    <td class="py-2 px-4 border-b">{{ $supplier->address }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-4 px-4 text-center text-gray-500">No suppliers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
