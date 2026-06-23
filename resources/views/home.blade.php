@extends('front.layouts.app')

@section('title', 'Tanishq Tour & Travel | Best Travel Agency in Agra')
@section('meta_description', 'Plan domestic and international holiday packages with Tanishq Tour & Travel, a trusted travel agency in Agra for family trips, honeymoon tours and adventure holidays.')
@section('canonical', route('home'))

@section('content')

    @php
        $bannerSlides = $bannerSlides ?? collect();
        $bannerCount = $bannerSlides->count();
    @endphp

    @if ($bannerCount > 0)
        {{-- ============================================================
     BANNER SLIDER SECTION
============================================================ --}}

        <section class="tt-banner-slider" id="bannerSlider" aria-label="Tanishq Tours Featured Destinations">
            <div id="ttBannerCarousel" class="carousel slide carousel-fade tt-banner-carousel" data-bs-ride="carousel"
                data-bs-interval="5000">

                <div class="carousel-indicators tt-banner-indicators">
                    @foreach ($bannerSlides as $idx => $banner)
                        <button type="button" data-bs-target="#ttBannerCarousel" data-bs-slide-to="{{ $idx }}"
                            class="{{ $idx === 0 ? 'active' : '' }}" aria-current="{{ $idx === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $idx + 1 }}">
                        </button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @foreach ($bannerSlides as $idx => $banner)
                        <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" id="banner-slide-{{ $idx + 1 }}">
                            <div class="tt-banner-slide" style="background-image:url('{{ $banner['image'] }}')">
                                <div class="tt-banner-slide__overlay {{ $banner['overlay_class'] }}"></div>
                                <div class="container tt-banner-slide__content">
                                    @if (!empty($banner['subtitle']))
                                        <div class="tt-banner-tag">
                                            <i class="fa-solid fa-location-dot me-1"></i> {{ $banner['subtitle'] }}
                                        </div>
                                    @endif
                                    <h2 class="tt-banner-slide__title">{{ $banner['title'] }}</h2>
                                    @if (!empty($banner['description']))
                                        <p class="tt-banner-slide__sub">{{ $banner['description'] }}</p>
                                    @endif
                                    @if (!empty($banner['button_text']))
                                        <a href="{{ $banner['button_url'] ?: route('front.tours') }}"
                                            class="tt-banner-slide__btn" id="banner-cta-{{ $idx + 1 }}">
                                            <i class="fas fa-compass me-2"></i>Explore {{ $banner['button_text'] }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev tt-banner-ctrl" type="button" data-bs-target="#ttBannerCarousel"
                    data-bs-slide="prev" id="banner-prev" aria-label="Previous slide">
                    <span class="tt-banner-ctrl__icon" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </button>
                <button class="carousel-control-next tt-banner-ctrl" type="button" data-bs-target="#ttBannerCarousel"
                    data-bs-slide="next" id="banner-next" aria-label="Next slide">
                    <span class="tt-banner-ctrl__icon" aria-hidden="true">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </button>

                <div class="tt-banner-counter" aria-live="polite">
                    <span id="tt-current-slide">1</span> / <span>{{ $bannerCount }}</span>
                </div>
            </div>
        </section>
    @endif

    {{-- ============================================================
     BANNER SLIDER SECTION END
============================================================ --}}

    {{-- ============================================================
     HERO SECTION
============================================================ --}}
    <section class="tt-hero-v2" id="hero">

        {{-- Floating Decorations --}}
        <div class="tt-hero-v2__deco">
            {{-- Animated SVG Airplane on curved dashed path --}}
            <svg class="tt-svg-path" viewBox="0 0 700 220" fill="none" xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true">
                <path id="planePath" d="M 20 200 Q 200 20 400 120 T 680 30" stroke="#FFBE00" stroke-width="2"
                    stroke-dasharray="8 6" fill="none" opacity="0.55" />
                <g id="svgPlane">
                    <text y="0" font-size="22" fill="#FFBE00">✈</text>
                </g>
            </svg>

            {{-- Floating Cloud Elements --}}
            <div class="tt-cloud tt-cloud--1">☁</div>
            <div class="tt-cloud tt-cloud--2">☁</div>
            <div class="tt-cloud tt-cloud--3">☁</div>

            {{-- Floating Icons --}}
            <i class="fa-solid fa-location-dot tt-deco-icon tt-deco-icon--pin1"></i>
            <i class="fa-solid fa-location-dot tt-deco-icon tt-deco-icon--pin2"></i>
            <i class="fa-regular fa-compass tt-deco-icon tt-deco-icon--compass"></i>
            <i class="fa-solid fa-plane tt-deco-icon tt-deco-icon--plane2"></i>
        </div>

        <div class="container">
            <div class="tt-hero-v2__grid">

                {{-- LEFT: Hero Content --}}
                <div class="tt-hero-v2__content" id="hero-content">
                    <div class="tt-badge-pill" id="hero-badge">
                        <i class="fa-solid fa-star me-1"></i> #1 Trusted Travel Agency in India
                    </div>

                    <h1 class="tt-hero-v2__title" id="hero-title">
                        Discover Your <span class="tt-hero-v2__accent">Next Step</span><br>Destination
                    </h1>

                    <p class="tt-hero-v2__desc" id="hero-desc">
                        Premium domestic &amp; international packages crafted for families,
                        couples, and adventure lovers. Your dream journey starts here.
                    </p>

                    <div class="tt-hero-v2__ctas" id="hero-ctas">
                        <a href="{{ route('front.tours') }}" class="tt-btn-hero-primary">
                            <i class="fa-solid fa-compass me-2"></i>Explore Packages
                        </a>
                        <a href="{{ route('front.contact') }}" class="tt-btn-hero-outline">
                            <i class="fa-solid fa-phone me-2"></i>Plan My Trip
                        </a>
                    </div>
                </div>

                {{-- RIGHT: Swiper Coverflow Carousel --}}
                <div class="tt-hero-v2__carousel" id="hero-carousel">
                    <div class="tt-lets-go-badge">Let's<br>Go! ✈</div>

                    <div class="swiper tt-hero-swiper" id="heroSwiper">
                        <div class="swiper-wrapper">
                            @forelse ($destinationsData as $dest)
                                <div class="swiper-slide">
                                    <div class="tt-hero-slide"
                                        style="background-image:url('{{ asset('storage/destinations/' . $dest['featured_image']) }}')">
                                        <div class="tt-slide-label"><i class="fas fa-map-marker-alt me-1"></i> {{ $dest['city'] ?? '' }}, {{ $dest['country'] ?? 'India' }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center w-100" data-aos="fade-up">
                                    <p class="tt-section-sub mb-0">No featured destinations available right now.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="swiper-pagination tt-hero-pagination"></div>
                    </div>
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
     FEATURED TOUR PACKAGES (with filter tabs)
============================================================ --}}
    @include('base-tour-packages')


    {{-- ============================================================
     FEATURED TOUR PACKAGES (with filter tabs)
============================================================ --}}

    {{--    WHY CHOOSE US
============================================================ --}}
    <section class="tt-why position-relative overflow-hidden" id="why-us">

        {{-- LEFT decorative: Hot Air Balloon --}}
        <img src="{{ Vite::asset('resources/images/perasut-1-1.webp') }}" alt="" aria-hidden="true"
            class="tt-why__deco tt-why__deco--left d-none d-lg-block">

        {{-- RIGHT decorative: Cartoon Airplane --}}
        <img src="{{ Vite::asset('resources/images/plane.webp') }}" alt="" aria-hidden="true"
            class="tt-why__deco tt-why__deco--right d-none d-lg-block">

        <div class="container position-relative" style="z-index:2;">

            {{-- Section heading --}}
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="tt-kicker-v2">
                    <i class="fas fa-award me-1"></i> Our Promise
                </span>
                <h2 class="tt-section-title mt-2 mb-3">
                    Why Choose <span class="tt-accent">Tanishq Tours</span>
                </h2>
                <p class="tt-section-sub mx-auto">
                    We combine personalized planning with transparent pricing for unforgettable journeys.
                </p>
            </div>

            {{-- Feature cards grid --}}
            <div class="row g-4 justify-content-center">
                @foreach ([
            [
                'icon' => 'fa-solid fa-tag',
                'title' => 'Best Price Guarantee',
                'desc' => 'We match or beat any competitor price. Your dream trip, at the best value every single time.',
                'color' => '#022179',
                'bg' => 'rgba(2,33,121,0.08)',
                'delay' => 0,
            ],
            [
                'icon' => 'fa-solid fa-user-tie',
                'title' => 'Expert Guides',
                'desc' => 'Our certified travel experts bring decades of experience to craft your perfect itinerary.',
                'color' => '#FFBE00',
                'bg' => 'rgba(255,190,0,0.12)',
                'delay' => 100,
            ],
            [
                'icon' => 'fa-solid fa-headset',
                'title' => '24/7 Support',
                'desc' => 'Round-the-clock assistance at every step of your journey, wherever you are in the world.',
                'color' => '#022179',
                'bg' => 'rgba(2,33,121,0.08)',
                'delay' => 200,
            ],
            [
                'icon' => 'fa-solid fa-sliders',
                'title' => 'Customized Tours',
                'desc' => 'Tailor-made packages built around your preferences, timeline, and budget — 100% flexible.',
                'color' => '#FFBE00',
                'bg' => 'rgba(255,190,0,0.12)',
                'delay' => 300,
            ],
        ] as $feat)
                    <div class="col-12 col-sm-6 col-lg-3" data-aos="zoom-in" data-aos-delay="{{ $feat['delay'] }}">
                        <div class="tt-why-card h-100 text-center position-relative overflow-hidden">
                            {{-- Icon circle --}}
                            <div class="tt-why-card__icon mx-auto mb-4 d-flex align-items-center justify-content-center"
                                style="background:{{ $feat['bg'] }}; color:{{ $feat['color'] }};">
                                <i class="{{ $feat['icon'] }}"></i>
                            </div>
                            {{-- Title --}}
                            <h3 class="tt-why-card__title fw-bold mb-3">{{ $feat['title'] }}</h3>
                            {{-- Divider --}}
                            <div class="tt-why-card__divider mx-auto mb-3" style="background:{{ $feat['color'] }};">
                            </div>
                            {{-- Description --}}
                            <p class="tt-why-card__desc mb-0">{{ $feat['desc'] }}</p>
                            {{-- Hover bottom glow strip --}}
                            <div class="tt-why-card__glow" style="background:{{ $feat['color'] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ============================================================
     WHY CHOOSE US END
============================================================ --}}

    {{-- ============================================================
     STATISTICS COUNTER
============================================================ --}}
    <section class="tt-stats" id="stats">
        <div class="tt-stats__bg"></div>
        <div class="container">
            <div class="tt-stats__grid">
                @foreach ([['icon' => 'fa-solid fa-users', 'num' => 1500, 'suffix' => '+', 'label' => 'Happy Travelers'], ['icon' => 'fa-solid fa-globe', 'num' => 80, 'suffix' => '+', 'label' => 'Destinations'], ['icon' => 'fa-solid fa-suitcase-rolling', 'num' => 200, 'suffix' => '+', 'label' => 'Tour Packages'], ['icon' => 'fa-solid fa-trophy', 'num' => 15, 'suffix' => '+', 'label' => 'Years Experience']] as $i => $stat)
                    <div class="tt-stat-v2" data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}">
                        <div class="tt-stat-v2__icon"><i class="{{ $stat['icon'] }}"></i></div>
                        <div class="tt-stat-v2__num">
                            <span class="tt-counter" data-target="{{ $stat['num'] }}">0</span>{{ $stat['suffix'] }}
                        </div>
                        <div class="tt-stat-v2__label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
     TESTIMONIALS CAROUSEL
============================================================ --}}
    @if (!empty($clientReviews) && $clientReviews->isNotEmpty())
        <section class="tt-section tt-testimonials" id="testimonials">
            <div class="container">
                <div class="tt-section-head text-center" data-aos="fade-up">
                    <span class="tt-kicker-v2"><i class="fas fa-heart me-1"></i> Happy Travelers</span>
                    <h2 class="tt-section-title">What Our <span class="tt-accent">Clients Say</span></h2>
                    <p class="tt-section-sub">Real experiences from real travelers who trusted Tanishq Tours.</p>
                </div>
                <div class="tt-testi-toolbar d-flex justify-content-end mb-3" data-aos="fade-up">
                    <div class="tt-testi-toolbar__nav d-flex gap-2">
                        <button class="tt-testi-prev tt-dest-arrow-btn d-flex align-items-center justify-content-center"
                            aria-label="Previous testimonial">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="tt-testi-next tt-dest-arrow-btn d-flex align-items-center justify-content-center"
                            aria-label="Next testimonial">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="swiper tt-testi-swiper" id="testiSwiper" data-aos="fade-up">
                    <div class="swiper-wrapper">
                        @foreach ($clientReviews as $review)
                            @php
                                $reviewerName = $review->reviewer_name ?: 'Guest Traveler';
                                $nameParts = preg_split('/\s+/', trim($reviewerName));
                                $initials =
                                    collect($nameParts)
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                        ->implode('') ?:
                                    'GT';
                                $avatarColor = $loop->iteration % 2 === 0 ? '#FFBE00' : '#022179';
                                $reviewLocation =
                                    $review->tour?->destination?->name ?:
                                    $review->tour?->location ?:
                                    $review->tour?->title ?:
                                    'Tanishq Tours';
                                $rating = max(1, min(5, (int) $review->rating));
                            @endphp
                            <div class="swiper-slide">
                                <div class="tt-testi-card">
                                    <div class="tt-testi-card__stars">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <i class="{{ $s <= $rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <p class="tt-testi-card__text">"
                                        {{ \Illuminate\Support\Str::limit($review->review_body, 180) }} "</p>
                                    <div class="tt-testi-card__author">
                                        <div class="tt-testi-card__avatar" style="background: {{ $avatarColor }}">
                                            @if ($review->client_pic)
                                                <img src="{{ asset('storage/reviews/' . $review->client_pic) }}"
                                                    alt="{{ $reviewerName }}">
                                            @else
                                                {{ $initials }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="tt-testi-card__name ms-3 mb-1">{{ ucwords($reviewerName) }}</div>
                                            <div class="tt-testi-card__loc"><i
                                                    class="fas fa-map-marker-alt me-1"></i>{{ ucwords($reviewLocation) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination tt-testi-pagination"></div>
                </div>
            </div>
        </section>
    @endif

    {{-- ============================================================
     CTA BANNER
============================================================ --}}
    <section class="tt-cta-banner" id="cta">
        <div class="tt-cta-banner__bg" id="cta-bg"></div>
        <div class="tt-cta-banner__overlay"></div>
        <div class="container">
            <div class="tt-cta-banner__content" data-aos="zoom-in">
                <span class="tt-kicker-v2 tt-kicker-v2--light"><i class="fas fa-plane me-1"></i> Adventure Awaits</span>
                <h2 class="tt-cta-banner__title">Ready For Your<br><span>Next Adventure?</span></h2>
                <p class="tt-cta-banner__sub">Let our travel experts craft your perfect journey. Call us or book online
                    today!</p>
                <div class="tt-cta-banner__btns">
                    <a href="{{ route('front.tours') }}" class="tt-btn-cta-primary">
                        <i class="fas fa-compass me-2"></i>Book Now
                    </a>
                    <a href="{{ route('front.contact') }}" class="tt-btn-cta-outline">
                        <i class="fas fa-phone me-2"></i>Talk to Expert
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
     NEWSLETTER
============================================================ --}}
    <section class="tt-newsletter" id="newsletter">
        <div class="container">
            <div class="tt-newsletter__inner" data-aos="fade-up">
                <div class="tt-newsletter__icon"><i class="fas fa-paper-plane"></i></div>
                <h2>Get Exclusive <span class="tt-accent">Travel Deals</span></h2>
                <p>Subscribe to our newsletter and be the first to know about our best packages and limited-time offers.</p>
                <form class="tt-newsletter__form" id="newsletter-form">
                    @csrf
                    <div class="tt-newsletter__input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Enter your email address..." required id="nl-email">
                    </div>
                    <button type="submit" class="tt-newsletter__btn">
                        <i class="fas fa-paper-plane me-1"></i> Subscribe
                    </button>
                </form>
                <p class="tt-newsletter__note"><i class="fas fa-lock me-1"></i> We respect your privacy. No spam, ever.
                </p>
            </div>
        </div>
    </section>
@endsection
