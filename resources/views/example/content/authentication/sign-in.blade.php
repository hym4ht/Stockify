@extends('example.layouts.default.main')
@section('content')
<div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
    <a href="{{ url('/')}}" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
        <img src="{{ asset('static/images/logo.svg') }}" class="mr-4 h-11" alt="FlowBite Logo">
        <span>Stockify</span>
    </a>
    <!-- Card -->
    <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Sign in to platform
        </h2>

        @if(session('error'))
            <div class="mb-4 text-sm font-medium text-red-600 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="name@company.com" required>
            </div>
            <div class="relative">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pr-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 h-full mt-1 translate-y-2 text-gray-500 dark:text-gray-400">
                    <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div class="ml-3 text-sm">
                    <label for="remember" class="font-medium text-gray-900 dark:text-white">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500">Lost Password?</a>
            </div>
            <button type="submit" class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login to your account</button>
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Not registered? <a href="{{ url('/register') }}" class="text-primary-700 hover:underline dark:text-primary-500">Create account</a>
            </div>
        </form>
    </div>
</div>
<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('svg');
        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.944-9.543-7a9.97 9.97 0 012.223-3.357m1.766-1.768A9.956 9.956 0 0112 5c4.478 0 8.269 2.944 9.543 7a10.06 10.06 0 01-4.132 5.411m-5.412 0a3 3 0 104.243-4.243" />';
        } else {
            input.type = "password";
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>
@endsection
