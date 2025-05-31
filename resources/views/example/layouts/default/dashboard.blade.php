@extends('example.layouts.default.baseof')
@section('main')
@vite(['resources/css/app.css','resources/js/app.js'])
    @include('example.layouts.partials.navbar-dashboard')
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

      @include('example.layouts.partials.sidebar')

      <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
        <main>
          @yield('content')
        </main>
            @include('example.layouts.partials.footer-dashboard')
      </div>
    </div>
@endsection
