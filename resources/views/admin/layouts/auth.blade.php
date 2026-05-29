<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ Vite::asset(config('constants.company_logo_favicon')) }}" alt="fav-icon"> 

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/scss/admin/admin.scss', 'resources/js/admin/admin.js'])
</head>

<body>
    <div id="app">
        <main class="py-0">
            @yield('content')
            @yield('scripts')
        </main>
    </div>
</body>

</html>
