@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
        🏢 Supplier List
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

    
        <!-- Search Bar -->
        <input type="text" id="searchSupplier" placeholder="🔍 Search suppliers..." 
            class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
            bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white">
    </div>

    <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white text-lg">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">#</th>
                    <th class="px-6 py-3 text-left font-semibold">Supplier Name</th>
                    <th class="px-6 py-3 text-left font-semibold">Contact Person</th>
                    <th class="px-6 py-3 text-left font-semibold">Phone</th>
                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                    <th class="px-6 py-3 text-left font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody id="supplierTable" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($suppliers as $supplier)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $supplier->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $supplier->contact_person }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $supplier->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $supplier->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" 
                               class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">✏️ Edit</a> |
                            <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" style="display: inline;">
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

<script>
    document.getElementById('searchSupplier').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#supplierTable tr');

        rows.forEach(row => {
            let name = row.cells[1].innerText.toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
