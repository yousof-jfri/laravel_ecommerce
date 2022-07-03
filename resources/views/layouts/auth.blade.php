<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">

    <!-- fontawsome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.css') }}">

    <!-- font vazir -->
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
</head>
<body>
    <div class="auth-card">
        <div class="auth-card-header">
            <h2>@yield('title')</h2>
        </div>
        <div class="auth-card-body">
            @yield('content')
        </div>
    </div>
</body>
</html>