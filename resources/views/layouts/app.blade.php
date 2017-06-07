<!DOCTYPE html>
<html lang="en">
<head>
  {{--<base href="https://sneekr.herokuapp.com">--}}
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Sneekr') }}</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/plfkjhocdlikiendflhcgpbndefindap">

  <script>
    window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
    ]); ?>
  </script>

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-97204083-1', 'auto');
    ga('send', 'pageview');
  </script>
</head>
<body>
<div id="app" class="container-fluid Wrapper">
  @include('layouts.header')
  <div class="col-xs-12 text-center InstallExtensionButtonContainer">
    <button class="btn btn-primary InstallExtensionButton" id="js-install-extension-button" type="button">
      Install Extension
    </button>
  </div>
  <div class="Wrapper__Row {{ Auth::check() ? 'row' : '' }}">
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
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({});
</script>
@stack('scripts')

</body>
</html>