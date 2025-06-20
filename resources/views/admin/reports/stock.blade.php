@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Laporan Stok Produk</h1>

    <!-- Filter Form -->
    <form method="GET" action="/admin/reports/stock" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date', date('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="attribute_name" class="block text-sm font-medium text-gray-700">Attribute Name</label>
            <select name="attribute_name" id="attribute_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Select Attribute</option>
                @foreach($attributeNames as $name)
                <option value="{{ $name }}" {{ request('attribute_name') == $name ? 'selected' : '' }}>
                    {{ $name }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="attribute_value" class="block text-sm font-medium text-gray-700">Attribute Value</label>
            <select name="attribute_value" id="attribute_value" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Select Value</option>
                @foreach($attributeValues as $value)
                <option value="{{ $value }}" {{ request('attribute_value') == $value ? 'selected' : '' }}>
                    {{ $value }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Filter
            </button>
        </div>
    </form>

    <script>
        document.getElementById('attribute_name').addEventListener('change', function() {
            const selectedName = this.value;
            const url = new URL(window.location.href);
            if (selectedName) {
                url.searchParams.set('attribute_name', selectedName);
            } else {
                url.searchParams.delete('attribute_name');
                url.searchParams.delete('attribute_value');
            }
            // Reset attribute_value when attribute_name changes
            url.searchParams.delete('attribute_value');
            window.location.href = url.toString();
        });
    </script>

    @if($products->isEmpty())
        <p>Tidak ada produk untuk ditampilkan.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-1 px-3 border-b text-left">Nama Produk</th>
                    <th class="py-1 px-3 border-b text-left">Kategori</th>
                    <th class="py-1 px-3 border-b text-right">Sisa Stok</th>
                    <th class="py-1 px-3 border-b text-right">Total Masuk</th>
                    <th class="py-1 px-3 border-b text-right">Total Keluar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    @php
                        $stockSum = $stockSums->get($product->id);
                        $totalIn = $stockSum ? ($stockSum->where('type', 'in')->first()->total_quantity ?? 0) : 0;
                        $totalOut = $stockSum ? ($stockSum->where('type', 'out')->first()->total_quantity ?? 0) : 0;
                    @endphp
                    <tr>
                        <td class="py-1 px-3 border-b">{{ $product->name }}</td>
                        <td class="py-1 px-3 border-b">{{ $product->category->name ?? 'Tidak ada kategori' }}</td>
                        <td class="py-1 px-3 border-b text-right">{{ $product->stock }}</td>
                        <td class="py-1 px-3 border-b text-right">{{ $totalIn }}</td>
                        <td class="py-1 px-3 border-b text-right">{{ $totalOut }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
