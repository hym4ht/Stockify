@extends('layouts.dashboard')
@section('content')
    @php
    @endphp
    <div
        class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                    </ol>
                </nav>
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All users</h1>
            </div>
            <div class="sm:flex">
                <div class="flex pl-0 mt-3 space-x-1 sm:pl-2 sm:mt-0">
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#"
                        class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                            </path>
                        </svg>
                    </a>
                </div>
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Add user
                    </a>
                    <div class="relative inline-block text-left">
                        <button type="button"
                            class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                            id="export-menu-button" aria-expanded="true" aria-haspopup="true">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Export
                            <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="origin-top-right absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden"
                            role="menu" aria-orientation="vertical" aria-labelledby="export-menu-button" tabindex="-1"
                            id="export-menu">
                            <div class="py-1" role="none">
                                <a href="{{ route('admin.users.export.csv') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="export-csv">Export CSV</a>
                                <a href="{{ route('admin.users.export.excel') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="export-excel">Export Excel</a>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.getElementById('export-menu-button').addEventListener('click', function () {
                            var menu = document.getElementById('export-menu');
                            if (menu.classList.contains('hidden')) {
                                menu.classList.remove('hidden');
                            } else {
                                menu.classList.add('hidden');
                            }
                        });
                        document.addEventListener('click', function (event) {
                            var menu = document.getElementById('export-menu');
                            var button = document.getElementById('export-menu-button');
                            if (!button.contains(event.target) && !menu.contains(event.target)) {
                                menu.classList.add('hidden');
                            }
                        });
                    </script>
                </div>
                <div class="flex items-center ml-4 space-x-2 sm:space-x-3">
                    <!-- Export buttons removed as per user feedback -->
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-2">
                                    <div class="flex items-center">
                                        <input id="checkbox-all" aria-describedby="checkbox-1" type="checkbox"
                                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col"
                                    class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Name
                                </th>
                                <th scope="col"
                                    class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Status
                                </th>
                                <th scope="col"
                                    class="p-2 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="w-4 p-2">
                                        <div class="flex items-center">
                                            <input id="checkbox-{{ $user->id }}" aria-describedby="checkbox-{{ $user->id }}"
                                                type="checkbox"
                                                class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox-{{ $user->id }}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="flex items-center p-2 space-x-4 whitespace-nowrap">
                                        <img class="w-10 h-10 rounded-full"
                                            src="{{ asset('static/images/users/' . ($user->avatar ?? 'default.png')) }}"
                                            alt="avatar">
                                        <div class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                            <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $user->name }}
                                            </div>
                                            <div class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $user->email }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            @if($user->role === 'unconfirmed')
                                                <div class="h-2.5 w-2.5 rounded-full bg-yellow-400 mr-2"></div>
                                                Menunggu Konfirmasi
                                            @elseif($user->role === 'Admin')
                                                <div class="h-2.5 w-2.5 rounded-full bg-blue-400 mr-2"></div>
                                                Admin
                                            @elseif($user->role === 'Staff Gudang')
                                                <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div>
                                                Staff Gudang
                                            @elseif($user->role === 'Manajer Gudang')
                                                <div class="h-2.5 w-2.5 rounded-full bg-purple-400 mr-2"></div>
                                                Manajer Gudang
                                            @else
                                                <div class="h-2.5 w-2.5 rounded-full bg-gray-400 mr-2"></div>
                                                Tidak Diketahui
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-2 space-x-2 whitespace-nowrap">
                                        @if($user->role === 'unconfirmed')
                                            <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
                                                @csrf
                                                <select name="role"
                                                    class="rounded border border-gray-300 text-sm p-1 dark:bg-gray-700 dark:text-white">
                                                    <option value="">Pilih Role</option>
                                                    <option value="Staff Gudang">Staff Gudang</option>
                                                    <option value="Manajer Gudang">Manajer Gudang</option>
                                                </select>
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" data-modal-target="edit-user-modal"
                                                data-modal-toggle="edit-user-modal" data-user="{{ json_encode($user) }}"
                                                class="edit-user-btn inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Edit user
                                            </button>
                                            <button type="button" data-modal-target="delete-user-modal"
                                                data-modal-toggle="delete-user-modal" data-user-id="{{ $user->id }}"
                                                class="delete-user-btn inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Delete user
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="edit-user-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-2xl md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-hide="edit-user-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <form id="edit-user-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Edit User</h3>
                        <div class="mb-4">
                            <label for="edit-name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                            <input type="text" name="name" id="edit-name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="edit-email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="edit-email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="role"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                            <select name="role" id="role"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                required>
                                <option value="">Select role</option>
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Staff Gudang" {{ old('role') == 'Staff Gudang' ? 'selected' : '' }}>Staff
                                    Gudang</option>
                                <option value="Manajer Gudang" {{ old('role') == 'Manajer Gudang' ? 'selected' : '' }}>Manajer
                                    Gudang</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="edit-password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password (leave
                                blank to keep current)</label>
                            <input type="password" name="password" id="edit-password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div id="delete-user-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-hide="delete-user-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <form id="delete-user-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to
                            delete this user?</h3>
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Yes, delete
                        </button>
                        <button data-modal-hide="delete-user-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Edit user modal
            const editUserModal = document.getElementById('edit-user-modal');
            const editUserForm = document.getElementById('edit-user-form');
            const editNameInput = document.getElementById('edit-name');
            const editEmailInput = document.getElementById('edit-email');
            const editPasswordInput = document.getElementById('edit-password');

            document.querySelectorAll('.edit-user-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const user = JSON.parse(button.getAttribute('data-user'));
                    editNameInput.value = user.name;
                    editEmailInput.value = user.email;
                    editPasswordInput.value = '';
                    editUserForm.action = `/admin/users/${user.id}`;
                    editUserModal.classList.remove('hidden');
                });
            });

            // Delete user modal
            const deleteUserModal = document.getElementById('delete-user-modal');
            const deleteUserForm = document.getElementById('delete-user-form');

            document.querySelectorAll('.delete-user-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const userId = button.getAttribute('data-user-id');
                    deleteUserForm.action = `/admin/users/${userId}`;
                    deleteUserModal.classList.remove('hidden');
                });
            });

            // Close modals on clicking close buttons or cancel buttons
            document.querySelectorAll('[data-modal-hide]').forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.getAttribute('data-modal-hide');
                    document.getElementById(modalId).classList.add('hidden');
                });
            });
        });
    </script>
@endsection