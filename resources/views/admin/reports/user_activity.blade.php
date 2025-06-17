@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Laporan Aktivitas Pengguna</h1>

    <form method="GET" action="{{ route('admin.reports.user_activity') }}" class="mb-6 flex items-center space-x-4">
        <div>
            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by User:</label>
            <select id="user_id" name="user_id" class="mt-1 block rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                <option value="">All Users</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Status:</label>
            <select id="status" name="status" class="mt-1 block rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            </select>
        </div>
        <div class="pt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Filter</button>
        </div>
    </form>

    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b text-gray-900 dark:text-white">User</th>
                <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Product</th>
                <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Type</th>
                <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Quantity</th>
                <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Status</th>
                <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Confirmed By</th>
                <th class="py-2 px-4 border-b text-gray-900 dark:text-white">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
            <tr>
                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->user->name ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->product->name ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ ucfirst($activity->type) }}</td>
                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->quantity }}</td>
                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ ucfirst($activity->status) }}</td>
                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->confirmedBy->name ?? 'N/A' }}</td>
                <td class="py-2 px-4 border-b text-gray-700 dark:text-gray-300">{{ $activity->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
