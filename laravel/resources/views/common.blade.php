<!DOCTYPE html>
<html>
  <head>
    <title>{{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/ads.css') }}">
    <!-- heroku上では　asset　を　mix　に変更 -->
  </head>

  <body>
    <header>
      @yield('header')
    </header>
      @yield('content')
    <footer>
      @yield('footer')
    </footer>
  </body>
</html>