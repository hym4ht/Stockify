@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-lg">
    <h1 class="text-2xl font-semibold mb-4 text-black dark:text-white">Add New Supplier</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 dark:bg-red-900 dark:border-red-700 dark:text-red-400 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.suppliers.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium mb-1 text-black dark:text-white">Name <span class="text-red-600 dark:text-red-400">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
        </div>

        <div>
            <label for="contact_name" class="block font-medium mb-1 text-black dark:text-white">Contact Name</label>
            <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name') }}" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
        </div>

        <div>
            <label for="phone" class="block font-medium mb-1 text-black dark:text-white">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
        </div>

        <div>
            <label for="email" class="block font-medium mb-1 text-black dark:text-white">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
        </div>

        <div>
            <label for="address" class="block font-medium mb-1 text-black dark:text-white">Address</label>
            <textarea name="address" id="address" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">{{ old('address') }}</textarea>
        </div>

        <div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Save Supplier
            </button>
            <a href="{{ route('admin.suppliers.index') }}" class="ml-4 text-gray-600 dark:text-gray-300 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
