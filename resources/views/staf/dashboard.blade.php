@extends('layouts.dashboard')

@section('content')
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Dashboard Staf Gudang</h1>
        <p>Selamat datang di dashboard Staf Gudang. Di sini Anda dapat melihat dan mengelola transaksi stok Anda.</p>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Tugas yang harus diselesaikan</h2>

            <h3 class="text-lg font-semibold mb-1">Barang Masuk yang Perlu Diperiksa</h3>
           

            <h3 class="text-lg font-semibold mb-1">Barang Keluar yang Perlu Disiapkan</h3>
          

            <h3 class="text-lg font-semibold mb-1">Opname Gudang yang Perlu Dikonfirmasi</h3>
            @if($pendingOpname->isEmpty())
                <p>Tidak ada opname gudang yang perlu dikonfirmasi.</p>
            @else
                <ul class="list-disc list-inside">
                    @foreach ($pendingOpname as $opname)
                        <li>
                            {{ $opname->created_at->format('Y-m-d H:i') }} - Produk: {{ $opname->product->name ?? 'N/A' }} - Jumlah: {{ $opname->quantity }} - Keterangan: {{ $opname->description ?? '-' }}
                            <form method="POST" action="{{ route('stock.opname.confirm', $opname->id) }}" class="inline-block ml-2">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:underline">Konfirmasi Opname</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
