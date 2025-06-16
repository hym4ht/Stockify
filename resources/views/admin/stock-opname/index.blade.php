@extends('layouts.dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">📋 Daftar Stock Opname</h1>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700 text-left text-gray-600 dark:text-gray-300 text-sm uppercase font-medium">
                    <tr>
                        <th class="px-6 py-3">Produk</th>
                        <th class="px-6 py-3">Qty Sistem</th>
                        <th class="px-6 py-3">Qty Aktual</th>
                        <th class="px-6 py-3">Catatan</th>
                        <th class="px-6 py-3">Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                    @forelse($stockOpnames as $opname)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="px-6 py-4 font-medium">{{ $opname->product->name }}</td>
                            <td class="px-6 py-4">{{ $opname->qty_system }}</td>
                            <td class="px-6 py-4">{{ $opname->qty_actual }}</td>
                            <td class="px-6 py-4">{{ $opname->notes ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $opname->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada data stock opname.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
    