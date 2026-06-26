@extends('front.layouts.app')

@section('title', 'Travel Destinations | Best Places to Visit')
@section('meta_description', 'Discover handpicked travel destinations for your next holiday with Tanishq Tour & Travel, from scenic Indian escapes to international vacation spots.')
@section('canonical', route('front.destinations'))

@section('content')

{{-- ============================================================
     Destinations HERO BANNER
============================================================ --}}
<section class="tt-contact-hero" id="contact-hero">
    <div class="tt-contact-hero__bg"></div>
    <div class="tt-contact-hero__overlay"></div>
    <div class="container tt-contact-hero__content" data-aos="fade-up">
        <nav aria-label="breadcrumb" class="tt-contact-hero__breadcrumb">
            <ol class="breadcrumb justify-content-center mb-3">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Destinations</li>
            </ol>
        </nav>
        <h1 class="tt-contact-hero__title">Destinations</h1>
        <p class="tt-contact-hero__sub">
            Explore handpicked destinations for your next unforgettable journey.
        </p>
    </div>

    <div class="tt-contact-hero__wave">
        <svg viewBox="0 0 1440 80" fill="none" preserveAspectRatio="none">
            <path d="M0 40 C360 80 1080 0 1440 40 L1440 80 L0 80 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<section class="tt-section position-relative overflow-hidden" id="packages">
    <img src="{{ Vite::asset('resources/images/how-lagges.webp') }}"
         alt=""
         aria-hidden="true"
         class="tt-pkg-deco tt-pkg-deco--tl d-none d-lg-block">

    <img src="{{ Vite::asset('resources/images/testi-1-2.webp') }}"
         alt=""
         aria-hidden="true"
         class="tt-pkg-deco tt-pkg-deco--br d-none d-lg-block">

    <div class="container position-relative" style="z-index:2;">
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-suitcase-rolling me-1"></i> Best Deals</span>
            <h2 class="tt-section-title"><span class="tt-accent">Destinations</span></h2>
            <p class="tt-section-sub">Search destination by name and explore curated places.</p>
        </div>

        <div class="tt-destination-search-wrap" data-aos="fade-up">
            <form action="{{ route('front.destinations') }}" method="GET" class="tt-destination-search" role="search" id="destination-search-form">
                <div class="tt-destination-search__input-wrap">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ $search ?? '' }}"
                        class="tt-destination-search__input"
                        id="destination-search-input"
                        placeholder="Search destination name..."
                        aria-label="Search destination name"
                    >
                </div>
                <button type="submit" class="tt-destination-search__btn">Search</button>
                <button
                    type="button"
                    class="tt-destination-search__reset{{ !empty($search) ? '' : ' d-none' }}"
                    id="destination-clear-btn"
                >
                    Clear
                </button>
            </form>
        </div>

        <div id="destination-results">
            @include('front.destinations.results', ['destinations' => $destinations, 'search' => $search])
        </div>
    </div>
</section>

@endsection
