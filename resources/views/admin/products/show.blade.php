@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Product Details</h1>

        <div class="mb-4">
            <strong>Name:</strong> {{ $product->name }}
        </div>
        <div class="mb-4">
            <strong>Category ID:</strong> {{ $product->category_id }}
        </div>
        <div class="mb-4">
            <strong>Supplier ID:</strong> {{ $product->supplier_id }}
        </div>
        <div class="mb-4">
            <strong>SKU:</strong> {{ $product->sku }}
        </div>
        <div class="mb-4">
            <strong>Description:</strong> {{ $product->description }}
        </div>
        <div class="mb-4">
            <strong>Price:</strong> {{ $product->price }}
        </div>
        <div class="mb-4">
            <strong>Stock:</strong> {{ $product->stock }}
        </div>

        <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">Back to Products</a>
    </div>
@endsection