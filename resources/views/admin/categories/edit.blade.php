@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit Kategori</h1>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 @error('name') border-red-500 @enderror" />
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
            <textarea name="description" id="description"
                class="w-full border border-gray-300 rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Kategori</button>
    </form>
</div>
@endsection
