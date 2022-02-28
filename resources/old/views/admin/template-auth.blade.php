@include('admin.partials.head')
<body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        @yield('content')
    </div>
    @include('admin.partials.footer')
</div>
@include('admin.partials.scripts')
