@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Produk</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-400">
            </div>

            <div class="mb-5">
                <label for="stock" class="block text-gray-700 font-semibold mb-2">Stok Awal</label>
                <input type="number" name="stock" id="stock" required min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-400">
            </div>

            <div class="mb-5">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-400"
                    placeholder="Tulis deskripsi produk..."></textarea>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('products.index') }}"
                    class="mr-3 text-gray-600 hover:text-blue-600 transition duration-200">Batal</a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition duration-200">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
