<!doctype html>
<html>
  <head>
    <link rel="canonical" href="#">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="{{ config('app.authors') }}">
    <meta name="generator" content="Laravel">

    <title>{{ $title }}</title>

    {{-- Include stylesheets --}}
    @include('example.layouts.partials.stylesheet')

    {{-- Include favicons --}}
    @include('example.layouts.partials.favicons')

    {{-- Robots meta --}}
    @if(isset($params['robots']))
    <meta name="robots" content="{{ $params['robots'] }}">
    @endif

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    {{-- Additional custom CSS --}}
    @if(isset($pageParams['extra_css']))
        @foreach($pageParams['extra_css'] as $css)
            <link href="{{ $css }}" rel="stylesheet">
        @endforeach
    @endif
  </head>
  <body @if(isset($pageParams['body_class'])) class="{{ $pageParams['body_class'] }}" @endif>
    @yield('content')
  </body>
</html>
