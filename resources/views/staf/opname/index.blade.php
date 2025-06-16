@extends('layouts.dashboard')

@section('content')
<div class="p-4">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif
    <h1 class="text-2xl font-bold mb-4">Opname Gudang</h1>
    <p>Proses opname gudang biasanya melibatkan:</p>
    <ul class="list-disc list-inside mb-4">
        <li>Pengecekan fisik barang satu per satu</li>
        <li>Pencocokan data antara stok nyata dan laporan inventaris</li>
        <li>Identifikasi selisih jika ada kekurangan atau kelebihan stok</li>
        <li>Penyesuaian data dalam sistem agar lebih akurat</li>
    </ul>

    @if($opnameRecords->isEmpty())
    <p>Tidak ada opname gudang yang perlu dikonfirmasi.</p>
    @else
    <form method="POST" action="{{ route('stock.opname.bulkConfirm') }}">
        @csrf
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr>
                    @if(auth()->user()->role !== 'Staff Gudang')
                    <th class="border border-gray-300 px-4 py-2">Pilih</th>
                    @endif
                    <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2">Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Sistem</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Fisik</th>
                    <th class="border border-gray-300 px-4 py-2">Barang Hilang/Rusak</th>
                    <th class="border border-gray-300 px-4 py-2">Selisih</th>
                    @if(auth()->user()->role !== 'Staff Gudang')
                    <th class="border border-gray-300 px-4 py-2">Konfirmasi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($opnameRecords as $opname)
                <tr>
                    @if(auth()->user()->role !== 'Staff Gudang')
                    <td class="border border-gray-300 px-4 py-2">
                        <input type="checkbox" name="confirm[]" value="{{ $opname->id }}" class="form-checkbox" />
                    </td>
                    @endif
                    <td class="border border-gray-300 px-4 py-2">{{ $opname->created_at->format('Y-m-d H:i') }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $opname->product->name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $opname->quantity }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        @if(auth()->user()->role !== 'Staff Gudang')
                        <input type="number" name="physical_count[{{ $opname->id }}]" value="{{ old('physical_count.' . $opname->id, $opname->physical_count) }}" class="w-full border border-gray-300 rounded px-2 py-1" />
                        @else
                        {{ $opname->physical_count ?? '-' }}
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        @if(auth()->user()->role !== 'Staff Gudang')
                        <input type="number" name="damaged_lost_goods[{{ $opname->id }}]" value="{{ old('damaged_lost_goods.' . $opname->id, $opname->damaged_lost_goods) }}" class="w-full border border-gray-300 rounded px-2 py-1" />
                        @else
                        {{ $opname->damaged_lost_goods ?? '-' }}
                        @endif
                    <td class="border border-gray-300 px-4 py-2">
                        @php
                        $discrepancy = $opname->physical_count !== null ? $opname->physical_count - $opname->quantity - ($opname->damaged_lost_goods ?? 0)  : '-';
                        @endphp
                        {{ $discrepancy }}
                    </td>
                    <td class="border border-gray-300 px-4 py-2">
                        @if(auth()->user()->role !== 'Staff Gudang')
                        <input type="text" name="adjustment_note[{{ $opname->id }}]" value="{{ old('adjustment_note.' . $opname->id, $opname->adjustment_note) }}" class="w-full border border-gray-300 rounded px-2 py-1" />
                        @else
                        {{ $opname->adjustment_note ?? '-' }}
                        @endif
                    </td>
                    @if(auth()->user()->role !== 'Staff Gudang')
                    <td class="border border-gray-300 px-4 py-2 text-center">
                        <button type="button" onclick="event.preventDefault(); document.getElementById('confirm-form-{{ $opname->id }}').submit();" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">Konfirmasi</button>
                        <form id="confirm-form-{{ $opname->id }}" action="{{ route('stock.opname.confirm', $opname->id) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(auth()->user()->role !== 'Staff Gudang')
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Konfirmasi Terpilih</button>
        @endif
    </form>
    @endif
</div>
@endsection