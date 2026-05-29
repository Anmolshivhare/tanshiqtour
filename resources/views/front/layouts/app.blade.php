<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tanishq Tour & Travel | Best Tour & Travel Agency | Holiday & Honeymoon Packages</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Tanishq Tour & Travel is your trusted tour and travel agency for domestic and international holiday packages, honeymoon trips, family vacations, adventure tours, hotel and flight booking at great prices.">
    <meta name="keywords" content="Tanishq Tour & Travel, travel agency, tour operator, holiday packages, honeymoon tour packages, domestic tours, international tours, budget trips, luxury tours, flight booking, hotel booking, adventure tours, family vacation packages, best travel agency in India">
    <meta name="author" content="Tanishq Tour & Travel">
    <meta name="robots" content="index, follow">

    <!-- OG Tags -->
    <meta property="og:title" content="Tanishq Tour & Travel | Best Tour & Travel Agency">
    <meta property="og:description" content="Book holiday packages, international tours, honeymoon trips and adventure tours with Tanishq Tour & Travel.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ Vite::asset(config('constants.company_logo_favicon')) }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ Vite::asset(config('constants.company_logo_favicon')) }}" alt="fav-icon">
    <link rel="dns-prefetch" href="//fonts.bunny.net">

    <!-- Scripts -->
    @vite(['resources/scss/front/front.scss', 'resources/js/front/front.js'])
</head>

<body>
    <div id="app">
        <main>
            <div id="layoutSidenav_content" class="main-content">
                @include('front.layouts.partials.header')
                <div class="main-inner-content">
                    <div class="">
                        <div class="row me-0">
                            <div class="col-12 pe-0">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
                @include('front.layouts.partials.footer')
            </div>
        </main>
        @stack('scripts')
    </div>
</body>
</html>
