@extends('example.layouts.default.main')
@section('main')
  <header class="py-5 border-bottom">
    <div class="container pt-md-1 pb-md-4">
      <h1 class="mt-0 bd-title">{{ $title }}</h1>
      <p class="bd-lead"></p>
      @if ($title == 'Examples')
          <div class="d-flex flex-column flex-sm-row">
              <a href="{{ config('app.download_dist_examples') }}" class="btn btn-lg btn-bd-primary" onclick="ga('send', 'event', 'Examples', 'Hero', 'Download Examples');">
                  Download examples
              </a>
          </div>
      @endif
  </div>
  </header>

  <main class="order-1 py-5 bd-content" id="content">
    <div class="container">
      @yield('content')
    </div>
  </main>
@endsection
