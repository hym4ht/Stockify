@extends('layouts.dashboard')

@section('content')
<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
    <div class="w-full mb-1">
        <div class="mb-4">
            <nav class="flex mb-5" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                </ol>
            </nav>
            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Add New User</h1>
        </div>
    </div>
</div>
<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow-lg rounded-lg p-6 bg-white dark:bg-gray-800">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block font-medium mb-1 text-black dark:text-white">Name <span class="text-red-600 dark:text-red-400">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
                    </div>

                    <div>
                        <label for="email" class="block font-medium mb-1 text-black dark:text-white">Email <span class="text-red-600 dark:text-red-400">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
                    </div>

                       <div>
                              <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                         <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    <option value="">Select role</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Staff Gudang" {{ old('role') == 'Staff Gudang' ? 'selected' : '' }}>Staff Gudang</option>
                    <option value="Manajer Gudang" {{ old('role') == 'Manajer Gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                      </select>
                    </div>

                    <div>
                        <label for="password" class="block font-medium mb-1 text-black dark:text-white">Password <span class="text-red-600 dark:text-red-400">*</span></label>
                        <input type="password" name="password" id="password" autocomplete="new-password" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block font-medium mb-1 text-black dark:text-white">Confirm Password <span class="text-red-600 dark:text-red-400">*</span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" required class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-800 text-black dark:text-white">
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600 dark:text-gray-300 hover:underline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
