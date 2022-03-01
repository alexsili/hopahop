<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="token" content="{{ csrf_token() }}"/>

    <link rel="icon" href="{{ asset("/images/favicon.ico") }}"/>

    <link href="{{ asset("/css/bootstrap.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("/css/select2.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("/css/fontawesome.all.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("/css/app.css") }}" rel="stylesheet"/>
    <link href="{{ asset("/css/style.css") }}" rel="stylesheet"/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="//db.onlinewebfonts.com/c/9da41c570d5a221cb2486d78769a076d?family=Neue+Helvetica" rel="stylesheet"
          type="text/css"/>

    @yield('topcss')

    @section('topjs')
    @endsection

    @yield('topjs')
</head>

<body>
<div class="wrapper">

    @include('layouts.partials.header')

    <div class="content-wrapper">

        @yield('content')
    </div>
    @include('layouts.partials.footer')
</div>

<script type="text/javascript" src="{{ url('/js/propper.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/fontawesome.all.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ url('/js/select2.min.js') }}"></script>


@yield('endjs')

</body>
</html>
