<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Absentra')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/supervisor-nav.css') }}">
    <link rel="icon" href="{{ asset('images/logo-era.png') }}" type="image/png">

    @yield('style')
</head>
<body style="background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; min-height: 100vh;">

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="w-100" style="max-width: 600px;">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/app-super.js') }}"></script>
</body>
</html>
