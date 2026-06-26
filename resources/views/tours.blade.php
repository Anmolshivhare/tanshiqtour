@extends('front.layouts.app')

@section('title', 'Tour Packages | Domestic & International Holiday Packages')
@section('meta_description', 'Explore domestic and international tour packages from Tanishq Tour & Travel, including honeymoon packages, family holidays, adventure trips and custom travel plans.')
@section('canonical', route('front.tours'))

@section('content')

{{-- ============================================================
     Destinations HERO BANNER
============================================================ --}}
<section class="tt-contact-hero" id="contact-hero">
    <div class="tt-contact-hero__bg"></div>
    <div class="tt-contact-hero__overlay"></div>
    <div class="container tt-contact-hero__content" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="tt-contact-hero__breadcrumb">
            <ol class="breadcrumb justify-content-center mb-3">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Tour Packages</li>
            </ol>
        </nav>
        <h1 class="tt-contact-hero__title">Tour Packages</h1>
        <p class="tt-contact-hero__sub">
            We'd love to hear from you. Reach out and let us plan your perfect journey.
        </p>
    </div>

    {{-- Wave divider --}}
    <div class="tt-contact-hero__wave">
        <svg viewBox="0 0 1440 80" fill="none"  preserveAspectRatio="none">
            <path d="M0 40 C360 80 1080 0 1440 40 L1440 80 L0 80 Z" fill="#ffffff"/>
        </svg>
    </div>  
</section>



{{-- ============================================================
     TOUR PACKAGES
============================================================ --}}
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
            <h2 class="tt-section-title"><span class="tt-accent">Tour Packages</span></h2>
            <p class="tt-section-sub">Search tour packages by name, location, destination, or duration.</p>
        </div>

        <div class="tt-destination-search-wrap" data-aos="fade-up">
            <form action="{{ route('front.tours') }}" method="GET" class="tt-destination-search" role="search" id="tour-search-form">
                <div class="tt-destination-search__input-wrap">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ $search ?? '' }}"
                        class="tt-destination-search__input"
                        id="tour-search-input"
                        placeholder="Search tour packages..."
                        aria-label="Search tour packages"
                    >
                </div>
                <button type="submit" class="tt-destination-search__btn">Search</button>
                <button
                    type="button"
                    class="tt-destination-search__reset{{ !empty($search) ? '' : ' d-none' }}"
                    id="tour-clear-btn"
                >
                    Clear
                </button>
            </form>
        </div>

        <div id="tour-results">
            @include('front.tours.results', ['tours' => $tours, 'search' => $search])
        </div>
    </div>
</section>


{{-- ============================================================
     TOUR PACKAGES
============================================================ --}}




{{-- ============================================================
     FAMILY / TRAVEL CARD CTA
============================================================ --}}
@include('base-family-travel')

{{-- ============================================================
     FAMILY / TRAVEL CARD CTA End --}}
 
@endsection
