@extends('layouts.dashboard')

@section('content')
<div class="p-4 space-y-4">

    {{-- Notifikasi Success --}}
    @if(session('success'))
    <div class="flex items-center p-4 rounded-lg bg-green-100 text-green-800 shadow-md animate-fade-in-down">
        <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    {{-- Notifikasi Error --}}
    @if(session('error'))
    <div class="flex items-center p-4 rounded-lg bg-red-100 text-red-800 shadow-md animate-fade-in-down">
        <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- Notifikasi Opname Masuk --}}
    @if(!$opnameMasukRecords->isEmpty())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded shadow-md animate-fade-in-down">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20.5c4.694 0 8.5-3.806 8.5-8.5S16.694 3.5 12 3.5 3.5 7.306 3.5 12 7.306 20.5 12 20.5z" />
            </svg>
            <h2 class="font-semibold">Opname Masuk yang perlu dicek</h2>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($opnameMasukRecords as $opname)
            <li>
                {{ $opname->created_at->format('Y-m-d H:i') }} - Produk: {{ $opname->product->name ?? 'N/A' }} - Jumlah: {{ $opname->quantity }}
                <a href="{{ route('stock.opname.masuk') }}" class="text-blue-600 hover:underline ml-2">Lihat detail</a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Notifikasi Opname Keluar --}}
    @if(!$opnameKeluarRecords->isEmpty())
    <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded shadow-md animate-fade-in-down">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M12 20.5c4.694 0 8.5-3.806 8.5-8.5S16.694 3.5 12 3.5 3.5 7.306 3.5 12 7.306 20.5 12 20.5z" />
            </svg>
            <h2 class="font-semibold">Opname Keluar yang perlu dicek</h2>
        </div>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($opnameKeluarRecords as $opname)
            <li>
                {{ $opname->created_at->format('Y-m-d H:i') }} - Produk: {{ $opname->product->name ?? 'N/A' }} - Jumlah: {{ $opname->quantity }}
                <a href="{{ route('stock.opname.keluar') }}" class="text-blue-600 hover:underline ml-2">Lihat detail</a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
