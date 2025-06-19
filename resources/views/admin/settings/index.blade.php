@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Admin Settings</h1>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6" id="settingsForm" novalidate>
        @csrf
        @method('PUT')

        <!-- Password error message container -->
        <p id="passwordErrorMsg" class="hidden text-sm text-red-600 dark:text-red-500 mb-2">
            Password incorrect or password fields cannot be empty.
        </p>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email address</label>
            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('email') border-red-500 @enderror">
            @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="old_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Old Password</label>
            <input type="password" name="old_password" id="old_password" autocomplete="current-password"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('old_password') border-red-500 @enderror">
            @error('old_password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
            <input type="password" name="password" id="password" autocomplete="new-password"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('password') border-red-500 @enderror">
            @error('password')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50 @error('password_confirmation') border-red-500 @enderror">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Update Settings
        </button>
    </form>
</div>

<script>
    document.getElementById('settingsForm').addEventListener('submit', function(event) {
        const oldPasswordEl = document.getElementById('old_password');
        const newPasswordEl = document.getElementById('password');
        const confirmPasswordEl = document.getElementById('password_confirmation');
        const nameEl = document.getElementById('name');
        const emailEl = document.getElementById('email');
        const passwordErrorMsg = document.getElementById('passwordErrorMsg');

        const oldPassword = oldPasswordEl.value.trim();
        const newPassword = newPasswordEl.value.trim();
        const confirmPassword = confirmPasswordEl.value.trim();

        // Reset error states
        [oldPasswordEl, newPasswordEl, confirmPasswordEl, nameEl, emailEl].forEach(el => {
            el.classList.remove('border-red-500');
        });
        passwordErrorMsg.classList.add('hidden');
        
        // Check if all three password fields are empty
        if (oldPassword === '' && newPassword === '' && confirmPassword === '') {
            // Show error message
            passwordErrorMsg.textContent = 'Password incorrect or password fields cannot be empty.';
            passwordErrorMsg.classList.remove('hidden');

            // Highlight all three password inputs
            oldPasswordEl.classList.add('border-red-500');
            newPasswordEl.classList.add('border-red-500');
            confirmPasswordEl.classList.add('border-red-500');

            event.preventDefault();
            return;
        }

        // If old password is filled, then new password and confirm password must be filled
        if (oldPassword !== '') {
            let invalid = false;

            if (newPassword === '' || confirmPassword === '') {
                invalid = true;
            }

            // Highlight empty fields
            if (newPassword === '') newPasswordEl.classList.add('border-red-500');
            if (confirmPassword === '') confirmPasswordEl.classList.add('border-red-500');

            if (invalid) {
                passwordErrorMsg.textContent = 'Please fill new password and confirm password fields.';
                passwordErrorMsg.classList.remove('hidden');
                event.preventDefault();
                return;
            }

            // Check if new password and confirmation match
            if (newPassword !== confirmPassword) {
                passwordErrorMsg.textContent = 'New Password and Confirm New Password do not match.';
                passwordErrorMsg.classList.remove('hidden');
                newPasswordEl.classList.add('border-red-500');
                confirmPasswordEl.classList.add('border-red-500');
                event.preventDefault();
                return;
            }
        }
    });
</script>
@endsection

