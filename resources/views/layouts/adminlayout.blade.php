<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin - Era Services')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/supervisor-nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataclient.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo-era.png') }}" type="image/png">


    @stack('styles')
       
</head>
<body>
    <div class="container">
        @include('app.sidebar-admin')

        <div class="main-content">
            @include('app.navbar')
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/dashboard-admin.js') }}"></script>
    <script src="{{ asset('js/dataclient.js') }}"></script>
    <script src="{{ asset('js/app-super.js') }}"></script>
    @stack('scripts')
</body>
</html>
