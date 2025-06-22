@extends('layouts.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Laporan Stok Produk (Manager)</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('manager.reports.stock') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        @php
            $inputClasses = 'mt-1 block w-full border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm';
            $labelClasses = 'block text-sm font-medium text-gray-700 dark:text-gray-300';
        @endphp

        <div>
            <label for="start_date" class="{{ $labelClasses }}">Start Date</label>
            <input type="date" name="start_date" id="start_date"
                   value="{{ request('start_date', date('Y-m-d')) }}"
                   class="{{ $inputClasses }}">
        </div>

        <div>
            <label for="end_date" class="{{ $labelClasses }}">End Date</label>
            <input type="date" name="end_date" id="end_date"
                   value="{{ request('end_date', date('Y-m-d')) }}"
                   class="{{ $inputClasses }}">
        </div>

        <div>
            <label for="category_id" class="{{ $labelClasses }}">Category</label>
            <select name="category_id" id="category_id" class="{{ $inputClasses }}">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="attribute_name" class="{{ $labelClasses }}">Attribute Name</label>
            <select name="attribute_name" id="attribute_name" class="{{ $inputClasses }}">
                <option value="">Select Attribute</option>
                @foreach($attributeNames as $name)
                    <option value="{{ $name }}" {{ request('attribute_name') == $name ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="attribute_value" class="{{ $labelClasses }}">Attribute Value</label>
            <select name="attribute_value" id="attribute_value" class="{{ $inputClasses }}">
                <option value="">Select Value</option>
                @foreach($attributeValues as $value)
                    <option value="{{ $value }}" {{ request('attribute_value') == $value ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Filter
            </button>
        </div>
    </form>

    <script>
        document.getElementById('attribute_name').addEventListener('change', function () {
            const selectedName = this.value;
            const url = new URL(window.location.href);
            if (selectedName) {
                url.searchParams.set('attribute_name', selectedName);
            } else {
                url.searchParams.delete('attribute_name');
                url.searchParams.delete('attribute_value');
            }
            url.searchParams.delete('attribute_value');
            window.location.href = url.toString();
        });
    </script>

    @if($products->isEmpty())
        <p class="text-gray-700 dark:text-gray-300">Tidak ada produk untuk ditampilkan.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-left text-gray-900 dark:text-gray-100">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Nama Produk</th>
                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">Kategori</th>
                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-right">Sisa Stok</th>
                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-right">Total Masuk</th>
                        <th class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-right">Total Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        @php
                            $stockSum = $stockSums->get($product->id);
                            $totalIn = $stockSum ? ($stockSum->where('type', 'in')->first()->total_quantity ?? 0) : 0;
                            $totalOut = $stockSum ? ($stockSum->where('type', 'out')->first()->total_quantity ?? 0) : 0;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">{{ $product->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700">
                                {{ $product->category->name ?? 'Tidak ada kategori' }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-right">{{ $product->stock }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-right">{{ $totalIn }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 dark:border-gray-700 text-right">{{ $totalOut }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
