@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Import Products</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label for="file" class="block font-medium mb-1">CSV File</label>
            <input type="file" name="file" id="file" accept=".csv,text/csv" required class="border rounded p-2 w-full">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Import</button>
    </form>

    <div class="mt-6">
        <a href="{{ route('admin.products.export') }}" class="text-blue-600 hover:underline">Export Products as CSV</a>
    </div>
</div>
@endsection
