@extends('example.layouts.partials.header')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Settings</h1>

        @php
            $role = $user->role ?? '';
        @endphp

        @if ($role === 'Admin')
            <div class="mb-6 p-4 border rounded shadow bg-white">
                <h2 class="text-xl font-semibold mb-2">Admin Settings</h2>
                <p>Settings specific to Admin role.</p>
                <!-- Add Admin specific settings form or content here -->
            </div>
        @elseif ($role === 'Staff Gudang')
            <div class="mb-6 p-4 border rounded shadow bg-white">
                <h2 class="text-xl font-semibold mb-2">Staff Gudang Settings</h2>
                <p>Settings specific to Staff Gudang role.</p>
                <!-- Add Staff Gudang specific settings form or content here -->
            </div>
        @elseif ($role === 'Manajer Gudang')
            <div class="mb-6 p-4 border rounded shadow bg-white">
                <h2 class="text-xl font-semibold mb-2">Manajer Gudang Settings</h2>
                <p>Settings specific to Manajer Gudang role.</p>
                <!-- Add Manajer Gudang specific settings form or content here -->
            </div>
        @else
            <div class="mb-6 p-4 border rounded shadow bg-white">
                <p>No specific settings available for your role.</p>
            </div>
        @endif
    </div>
@endsection