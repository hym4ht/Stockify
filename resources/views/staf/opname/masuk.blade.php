@extends('layouts.dashboard')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Opname Masuk</h1>
    @if($opnameMasukRecords->isEmpty())
    <p>Tidak ada opname masuk yang perlu dikonfirmasi.</p>
    @else
    <form method="POST" action="{{ route('stock.opname.bulkConfirm') }}">
        @csrf
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2">Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Sistem</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Fisik</th>
                    {{-- <th class="border border-gray-300 px-4 py-2">Selisih</th> --}}
                    <th class="border border-gray-300 px-4 py-2">Barang Hilang/Rusak</th>
                    <th class="border border-gray-300 px-4 py-2">Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($opnameMasukRecords as $opname)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $opname->created_at->format('Y-m-d H:i') }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $opname->product->name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $opname->quantity }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        <input type="number" name="physical_count[{{ $opname->id }}]" value="{{ old('physical_count.' . $opname->id, $opname->physical_count) }}" class="w-full border border-gray-300 rounded px-2 py-1" />
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        <input type="number" name="damaged_lost_goods[{{ $opname->id }}]" value="{{ old('damaged_lost_goods.' . $opname->id, $opname->damaged_lost_goods) }}" class="w-full border border-gray-300 rounded px-2 py-1" />
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <input type="checkbox" name="confirm[{{ $opname->id }}]" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Konfirmasi Terpilih</button>
    </form>
    @endif
</div>
@endsection
