<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'M4DN') }}</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <script>
    window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
    ]); ?>
  </script>
</head>
<body>
<div id="app" class="container-fluid Wrapper">
  @include('layouts.header')
  <div class="row Wrapper__Row">
    @if (Auth::check())
      <div class="col-sm-3 col-md-2">
        @include('layouts.sidebar')
      </div>
      <div class="col-xs-12 col-sm-9 col-md-10 Content">
        @yield('content')
      </div>
    @else
      <div class="Auth">
        @yield('content')
      </div>
    @endif
  </div>

  @include('layouts.modal')
</div>


<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')

</body>
</html>