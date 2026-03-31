<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
    <script>
    (function(){var u=encodeURIComponent(window.location.href);var i=new Image(1,1);i.src="{{ url('/api/track') }}?url="+u;})();
    </script>
</body>
</html>
