@extends('example.layouts.default.main')

@section('body_override')
<body class="d-flex flex-column min-vh-100">
@endsection

@section('main')
  <main class="p-5 my-auto" id="content">
    @yield('content')
  </main>
@endsection
