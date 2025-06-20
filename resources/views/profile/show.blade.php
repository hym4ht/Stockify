@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto p-10 bg-white dark:bg-gray-800 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-10 border-b border-gray-300 dark:border-gray-700 pb-4">
            My Profile
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Name -->
            <div>
                <label class="block text-sm text-gray-500 dark:text-gray-400 mb-1">Name</label>
                <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm text-gray-500 dark:text-gray-400 mb-1">Email</label>
                <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->email }}</p>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm text-gray-500 dark:text-gray-400 mb-1">Role</label>
                <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->role }}</p>
            </div>

            <!-- Created At -->
            <div>
                <label class="block text-sm text-gray-500 dark:text-gray-400 mb-1">Account Created At</label>
                <p class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $user->created_at ? $user->created_at->format('d M Y H:i') : 'N/A' }}
                </p>
            </div>
        </div>
    </div>
@endsection
