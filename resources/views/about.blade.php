@extends('front.layouts.app')

@section('title', 'About Tanishq Tour & Travel | Trusted Travel Agency')
@section('meta_description', 'Learn about Tanishq Tour & Travel, a trusted travel agency helping families, couples and groups plan memorable domestic and international holidays.')
@section('canonical', route('front.about'))

@section('content')

{{-- ============================================================
     ABOUT HERO BANNER
============================================================ --}}
<section class="tt-about-hero" id="about-hero">
    <div class="tt-about-hero__bg"></div>
    <div class="tt-about-hero__overlay"></div>
    <div class="container tt-about-hero__content" data-aos="fade-up">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="tt-about-hero__breadcrumb">
            <ol class="breadcrumb justify-content-center mb-3">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">About Us</li>
            </ol>
        </nav>
        <h1 class="tt-about-hero__title">About <span>Us</span></h1>
        <p class="tt-about-hero__sub">
            Your trusted travel partner for unforgettable journeys across India &amp; the world.
        </p>
    </div>

    {{-- Wave divider --}}
    <div class="tt-about-hero__wave">
        <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 40 C360 80 1080 0 1440 40 L1440 80 L0 80 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

{{-- ============================================================
     WHO WE ARE
============================================================ --}}
<section class="tt-about-who py-5" id="who-we-are">
    <div class="container">
        <div class="row align-items-center g-5">

            {{-- LEFT: Image collage --}}
            <div class="col-lg-6" data-aos="fade-right">
                <div class="tt-about-collage">
                    {{-- Main large image --}}
                    <div class="tt-about-collage__main">
                        <img src="/images/about_collage.png" alt="Tanishq Tours destinations" loading="lazy">
                    </div>
                    {{-- Floating family card --}}
                    <div class="tt-about-collage__card" data-aos="zoom-in" data-aos-delay="200">
                        <img src="/images/about_family.png" alt="Happy travelers" loading="lazy">
                        <div class="tt-about-collage__card-label">
                            <i class="fas fa-heart me-1 text-danger"></i>
                            Happy Families
                        </div>
                    </div>
                    {{-- Experience badge --}}
                    <div class="tt-about-exp-badge" data-aos="zoom-in" data-aos-delay="300">
                        <span class="tt-about-exp-badge__num">15+</span>
                        <span class="tt-about-exp-badge__text">Years<br>Experience</span>
                    </div>
                    {{-- Dotted deco --}}
                    <div class="tt-about-collage__dots" aria-hidden="true"></div>
                </div>
            </div>

            {{-- RIGHT: Content --}}
            <div class="col-lg-6" data-aos="fade-left">
                <span class="tt-kicker-v2 mb-3">
                    <i class="fas fa-info-circle me-1"></i> Who We Are
                </span>
                <h2 class="tt-section-title mt-2 mb-3">
                    We Make Your Travel <span class="tt-accent">Dream Reality</span>
                </h2>
                <p class="tt-about-desc">
                    At <strong>Tanishq Tours &amp; Travels</strong>, we believe travel is more than just visiting new places —
                    it's where you learn about different cultures, connect with nature's beauty, and create memories that
                    last a lifetime. Our mission is to connect people with the world and make every journey meaningful.
                </p>
                <p class="tt-about-desc">
                    Wherever you dream of going, <strong class="text-brand-accent">we'll take you there</strong>.
                    Let's create your next travel story together — we'll handle the things, you enjoy the adventure.
                </p>

                {{-- USP list --}}
                <ul class="tt-about-usp list-unstyled mt-4 mb-4">
                    @foreach([
                        ['icon' => 'fa-shield-alt',      'text' => '100% Trusted &amp; Verified Tours'],
                        ['icon' => 'fa-dollar-sign',     'text' => 'Best Price Guarantee — No Hidden Fees'],
                        ['icon' => 'fa-headset',         'text' => '24/7 Customer Support Worldwide'],
                        ['icon' => 'fa-sliders-h',       'text' => 'Fully Customised Itineraries'],
                    ] as $usp)
                    <li class="tt-about-usp__item d-flex align-items-start gap-3">
                        <span class="tt-about-usp__icon flex-shrink-0">
                            <i class="fas {{ $usp['icon'] }}"></i>
                        </span>
                        <span>{!! $usp['text'] !!}</span>
                    </li>
                    @endforeach
                </ul>

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('front.tours') }}" class="tt-btn-hero-primary">
                        <i class="fas fa-compass me-2"></i>Explore Packages
                    </a>
                    <a href="{{ route('front.contact') }}" class="tt-btn-about-outline">
                        <i class="fas fa-phone me-2"></i>Contact Us
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     DISCOUNT / OFFER BANNER
============================================================ --}}
{{-- <section class="tt-about-offer" id="about-offer">
    <div class="tt-about-offer__bg"></div>
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center g-4">

             <div class="col-lg-4 text-center" data-aos="fade-right">
                <div class="tt-about-offer__traveler">
                    <i class="fas fa-user-tie tt-about-offer__icon-person"></i>
                    <div class="tt-about-offer__icon-bag">
                        <i class="fas fa-suitcase-rolling"></i>
                    </div>
                    <div class="tt-about-offer__tag">
                        <i class="fas fa-tag me-1"></i> GET!
                    </div>
                </div>
            </div>

             <div class="col-lg-5" data-aos="fade-up">
                <span class="tt-kicker-v2 tt-kicker-v2--light mb-3">
                    <i class="fas fa-bolt me-1"></i> Limited Time Offer
                </span>
                <h2 class="tt-about-offer__title">
                    Get <span>20% Discount</span><br>on Every Tour Package!
                </h2>
                <p class="tt-about-offer__sub">
                    Book any package today and enjoy an instant 20% off. Valid on all domestic &amp;
                    international packages. Don't miss this exclusive deal!
                </p>
                 <div class="tt-about-offer__stats d-flex flex-wrap gap-3 my-4">
                    @foreach([
                        ['num' => '1500+', 'label' => 'Happy Travelers'],
                        ['num' => '80+',   'label' => 'Destinations'],
                        ['num' => '200+',  'label' => 'Tour Packages'],
                    ] as $s)
                    <div class="tt-about-offer__stat">
                        <div class="tt-about-offer__stat-num">{{ $s['num'] }}</div>
                        <div class="tt-about-offer__stat-label">{{ $s['label'] }}</div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('front.tours') }}" class="tt-about-offer__btn">
                    <i class="fas fa-arrow-right me-2"></i>Grab This Deal
                </a>
            </div>

             <div class="col-lg-3 d-none d-lg-flex justify-content-center align-items-center" data-aos="fade-left">
                <div class="tt-about-offer__landmarks">
                    <i class="fas fa-landmark tt-lm tt-lm--1"></i>
                    <i class="fas fa-mosque tt-lm tt-lm--2"></i>
                    <i class="fas fa-gopuram tt-lm tt-lm--3"></i>
                    <i class="fas fa-torii-gate tt-lm tt-lm--4"></i>
                </div>
            </div>

        </div>
    </div>
</section> --}}

{{-- ============================================================
     HOW IT WORKS — STEP BY STEP
============================================================ --}}
<section class="tt-about-how py-5" id="how-it-works">
    <div class="container">

        <div class="text-center mb-5" data-aos="fade-up">
            <span class="tt-kicker-v2">
                <i class="fas fa-route me-1"></i> Simple Process
            </span>
            <h2 class="tt-section-title mt-2 mb-2">
                How It Works <span class="tt-accent">Step by Step</span>
            </h2>
            <p class="tt-section-sub mx-auto">
                Planning your perfect trip with Tanishq Tours is simple, fast, and stress-free.
            </p>
        </div>

        <div class="tt-how-steps position-relative">
              {{-- ── Top-Left decorative: Suitcase ── --}}
            <img src="{{ Vite::asset('resources/images/how-lagges.webp') }}"
                alt=""
                aria-hidden="true"
                class="tt-pkg-deco tt-pkg-deco--tl d-none d-lg-block">
            
            <div class="tt-how-steps__line d-none d-lg-block" aria-hidden="true"></div>
            <div class="tt-how-steps__plane d-none d-lg-block" aria-hidden="true">
                <i class="far fa-paper-plane"></i>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach([
                    [
                        'step'  => '1',
                        'icon'  => 'fa-hand-point-up',
                        'title' => 'Select Destination',
                        'desc'  => 'In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best.',
                        'delay' => 0,
                    ],
                    [
                        'step'  => '2',
                        'icon'  => 'fa-people-group',
                        'title' => 'Make An Appointments',
                        'desc'  => 'Integer feugiat tortor non there are many other nullam in a free hour, when our power of choice is untrammelled.',
                        'delay' => 120,
                    ],
                    [
                        'step'  => '3',
                        'icon'  => 'fa-thumbs-up',
                        'title' => 'Enjoy Our Tour',
                        'desc'  => 'In a free hour, when our power of choice is untrammelled and when nothing prevents non there.',
                        'delay' => 240,
                    ],
                ] as $step)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $step['delay'] }}">
                    <article class="tt-how-step text-center {{ $step['class'] ?? '' }}">
                        <div class="tt-how-step__icon-wrap mx-auto">
                            <span class="tt-how-step__count">{{ $step['step'] }}</span>
                            <span class="tt-how-step__icon">
                                <i class="fas {{ $step['icon'] }}"></i>
                            </span>
                        </div>
                        <h3 class="tt-how-step__title">{{ $step['title'] }}</h3>
                        <p class="tt-how-step__desc">{{ $step['desc'] }}</p>
                    </article>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ============================================================
     POPULAR DESTINATIONS
============================================================ --}}
@include('base-destination')

{{-- ============================================================
     POPULAR DESTINATIONS End
============================================================ --}}

{{-- ============================================================
     FAMILY / TRAVEL CARD CTA
============================================================ --}}
@include('base-family-travel')

{{-- ============================================================ --}}



@endsection
