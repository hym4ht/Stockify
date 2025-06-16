@extends('layouts.dashboard') {{-- Ganti dengan layout yang kamu gunakan --}}

@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Laporan Barang Masuk dan Keluar</h1>

        @if($transactions->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">Tidak ada Barang Masuk Atau Keluar ditemukan.</p>
        @else
            <div class="overflow-x-auto rounded-lg shadow-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white text-lg">
                        <tr>
                            <th class="px-4 py-3 border border-gray-300 dark:border-gray-700">Tanggal</th>
                            <th class="px-4 py-3 border border-gray-300 dark:border-gray-700">Nama Produk</th>
                            <th class="px-4 py-3 border border-gray-300 dark:border-gray-700">Jumlah</th>
                            <th class="px-4 py-3 border border-gray-300 dark:border-gray-700">Tipe Transaksi</th>
                            <th class="px-4 py-3 border border-gray-300 dark:border-gray-700">Dilakukan Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                                <td class="px-4 py-3 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white font-medium">{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                                <td class="px-4 py-3 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $trx->product->name ?? '-' }}</td>
                                <td class="px-4 py-3 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $trx->quantity }}</td>
                                <td class="px-4 py-3 border border-gray-300 dark:border-gray-700">
                                    @if($trx->type === 'in')
                                        <span class="text-green-600 dark:text-green-400 font-semibold">Masuk</span>
                                    @elseif($trx->type === 'out')
                                        <span class="text-red-600 dark:text-red-400 font-semibold">Keluar</span>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">{{ $trx->user->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
