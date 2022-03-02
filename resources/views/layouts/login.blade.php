<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset("/css/bootstrap.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("/css/fontawesome.all.min.css") }}" rel="stylesheet"/>

    <title>{{ config('app.name', 'HopaHop') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <link href="{{ asset("/css/select2.min.css") }}" rel="stylesheet"/>
</head>
<body>
<div id="app">
    <main class="py-4">
        @yield('content')
    </main>
</div>
<script type="text/javascript" src="{{ url('/js/propper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/fontawesome.all.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/select2.min.js') }}"></script>

@yield('endjs')
</body>
</html>
