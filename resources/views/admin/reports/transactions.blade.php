@extends('layouts.dashboard')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Laporan Transaksi</h1>

    <form method="GET" action="{{ route('admin.reports.transactions') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
            <input type="date" name="date" id="date" value="{{ request('date', date('Y-m-d')) }}" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm p-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
        </div>
        <div>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Filter
            </button>
        </div>
    </form>

    <div>
        <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">Transaksi</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Tanggal</th>
                        <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Produk</th>
                        <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Jumlah</th>
                        <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Tipe</th>
                        <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Pengguna</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr>
                        <td class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">{{ $transaction->product->name ?? '-' }}</td>
                        <td class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">{{ $transaction->quantity }}</td>
                        <td class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                            @if($transaction->type === 'in')
                                Masuk
                            @elseif($transaction->type === 'out')
                                Keluar
                            @else
                                {{ $transaction->type }}
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">{{ $transaction->confirmedBy->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">Tidak ada transaksi pada tanggal ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
