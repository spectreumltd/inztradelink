<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Scripts -->
</head>
<body>
    <h1>Backend Header</h1>
    {{ Auth::user()->name }}
    <a href="{{ route('logout') }}">Logout</a>
    @include('backend_layouts.alert')
        @yield('content')
    <h1>Backend Footer</h1>
    
    @yield('scripts')
</body>
</html>
