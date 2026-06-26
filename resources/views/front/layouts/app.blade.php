<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $siteName = $settingData->company_name ?? 'Tanishq Tour & Travel';
        $seoTitle = trim($__env->yieldContent('title'));
        $seoDescription = trim($__env->yieldContent('meta_description'));
        $seoImage = trim($__env->yieldContent('og_image'));
        $seoType = trim($__env->yieldContent('og_type')) ?: 'website';
        $canonicalUrl = trim($__env->yieldContent('canonical')) ?: url()->current();
        $defaultDescription = 'Tanishq Tour & Travel is your trusted tour and travel agency for domestic and international holiday packages, honeymoon trips, family vacations, adventure tours, hotel and flight booking at great prices.';
        $title = $seoTitle !== '' ? $seoTitle : $siteName . ' | Best Tour & Travel Agency | Holiday & Honeymoon Packages';
        $description = $seoDescription !== '' ? $seoDescription : $defaultDescription;
        $image = $seoImage !== '' ? $seoImage : \App\Helpers\SiteSettingHelper::imageUrl('favicon', config('constants.company_logo_favicon'));
    @endphp

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $description }}">
    <meta name="keywords"
        content="Tanishq Tour & Travel, travel agency, tour operator, holiday packages, honeymoon tour packages, domestic tours, international tours, budget trips, luxury tours, flight booking, hotel booking, adventure tours, family vacation packages, best travel agency in India">
    <meta name="author" content="{{ $siteName }}">
    <meta name="robots" content="index, follow">

    <!-- OG Tags -->
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type" content="{{ $seoType }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $image }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $image }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png"
        href="{{ \App\Helpers\SiteSettingHelper::imageUrl('favicon', config('constants.company_logo_favicon')) }}"
        >
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2602ZWYZ6D"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-2602ZWYZ6D');
    </script>

    <!-- Organization Schema -->
    <script type="application/ld+json">
    {!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'TravelAgency',
    'name' => $siteName,
    'url' => url('/'),
    'logo' => \App\Helpers\SiteSettingHelper::imageUrl('favicon', config('constants.company_logo_favicon')),
    'image' => $image,
    'telephone' => $settingData->contact_phone ?? null,
    'email' => $settingData->contact_email ?? null,
    'address' => $settingData->address ?? null
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Website Schema -->
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $siteName,
        'url' => url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => route('front.tours') . '?q={search_term_string}',
            'query-input' => 'required name=search_term_string',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Scripts -->
    @vite(['resources/scss/front/front.scss', 'resources/js/front/custom.js'])
</head>

<body>
    <div id="app">
        <main>
            <div id="layoutSidenav_content" class="main-content">
                @include('front.layouts.partials.header')
                <div class="tt-page-wrapper">
                    <div class="main-inner-content">
                        <div class="">
                            <div class="row me-0">
                                <div class="col-12 pe-0">
                                    @yield('content')
                                    @stack('schema')
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('front.layouts.partials.footer')
                </div>
            </div>
        </main>
        <button type="button" class="tt-scroll-progress" id="ttScrollProgress" aria-label="Scroll to top">
            <span class="tt-scroll-progress__value" id="ttScrollProgressValue">0%</span>
            <i class="fas fa-arrow-up tt-scroll-progress__icon" aria-hidden="true"></i>
        </button>
        <div class="tt-cursor-follower" id="ttCursorFollower" aria-hidden="true"></div>
        @stack('scripts')
    </div>
</body>

</html>
