<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Primos Travellers | Best Tour & Travel Agency | Holiday & Honeymoon Packages</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Primos Travellers is your trusted tour & travel agency offering domestic & international holiday packages, honeymoon trips, family vacations, adventure tours, hotel & flight booking at best prices. Explore the world with Primos Travellers!">

    <meta name="keywords" content="Primos Travellers, travel agency, tour operator, holiday packages, honeymoon tour packages, domestic tours, international tours, budget trips, luxury tours, flight booking, hotel booking, adventure tours, family vacation packages, best travel agency in India">

    <meta name="author" content="Primos Travellers">
    <meta name="robots" content="index, follow">

    <!-- OG Tags (Social Media Sharing) -->
    <meta property="og:title" content="Primos Travellers | Best Tour & Travel Agency">
    <meta property="og:description" content="Book holiday packages, international tours, honeymoon trips & adventure tours with Primos Travellers. Best price guaranteed.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ Vite::asset('resources/images/logo.svg') }}">
    {{-- <link rel="icon" type="image/webp" href="{{ Vite::asset('resources/images/fav-icon.webp') }}" alt="fav-icon"> --}}
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Scripts -->
    @vite(['resources/scss/front/front.scss', 'resources/js/front/front.js'])

</head>

<body>
    <div id="app">
        <main>
            <div id="layoutSidenav_content"class="main-content">
                @include('front.layouts.partials.header')
                <div class="main-inner-content">
                    <div class="">
                        <div class="row me-0 ">
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
