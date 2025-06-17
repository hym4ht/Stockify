@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Product Attributes</h1>

    <a href="{{ route('admin.product_attributes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
        Create New Attribute
    </a>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 dark:bg-gray-800 dark:text-gray-400">
        <thead>
            <tr>
                <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">ID</th>
                <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Product</th>
                <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Attribute Name</th>
                <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Attribute Value</th>
                <th class="px-6 py-4 font-medium text-gray-900 dark:text-white">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attributes as $attribute)
            <tr>
                <td class="py-2 px-4 border-b">{{ $attribute->id }}</td>
                <td class="py-2 px-4 border-b">{{ $attribute->product->name ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b">{{ $attribute->name }}</td>
                <td class="py-2 px-4 border-b">{{ $attribute->value }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.product_attributes.edit', $attribute) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                    <form action="{{ route('admin.product_attributes.destroy', $attribute) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this attribute?');">
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
        {{ $attributes->links() }}
    </div>
</div>
@endsection