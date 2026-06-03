@extends('front.layouts.app')

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
            <form action="{{ route('front.destinations') }}" method="GET" class="tt-destination-search" role="search">
                <div class="tt-destination-search__input-wrap">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        name="q"
                        value="{{ $search ?? '' }}"
                        class="tt-destination-search__input"
                        placeholder="Search destination name..."
                        aria-label="Search destination name"
                    >
                </div>
                <button type="submit" class="tt-destination-search__btn">Search</button>
                @if(!empty($search))
                    <a href="{{ route('front.destinations') }}" class="tt-destination-search__reset">Clear</a>
                @endif
            </form>
        </div>

        <div class="tt-pkg-grid" id="tt-pkg-grid">
            @forelse ($destinations as $i => $destination)
                @php
                    $image = $destination->featured_image
                        ? asset('storage/destinations/' . $destination->featured_image)
                        : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=80';
                    $location = trim(implode(', ', array_filter([$destination->city, $destination->state, $destination->country])));
                @endphp

                <div class="tt-pkg-card" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}">
                    <a href="{{ route('front.destination-details', $destination->slug) }}">
                        <div class="tt-pkg-card__img">
                            <img src="{{ $image }}" alt="{{ $destination->name }}" loading="lazy">
                            <span class="tt-pkg-card__cat">Destination</span>
                        </div>

                        <div class="tt-pkg-card__body">
                            <div class="tt-pkg-card__loc">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $location ?: 'Beautiful Location' }}
                            </div>
                            <h3 class="tt-pkg-card__title">{{ $destination->name }}</h3>
                            <div class="tt-pkg-card__meta">
                                <span><i class="fas fa-compass me-1"></i>Explore</span>
                                <span class="tt-pkg-card__rating"><i class="fas fa-star me-1"></i>Featured</span>
                            </div>
                            <div class="tt-pkg-card__footer">
                                <div>
                                    <span class="tt-pkg-card__label">Plan Your Trip</span>
                                    <span class="tt-pkg-card__price">Custom</span>
                                </div>
                                <a href="{{ route('front.tours') }}" class="tt-pkg-card__book">Book Now</a>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="tt-destination-empty text-center">
                        <h3>No destinations found</h3>
                        <p>Try a different name in search.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($destinations->hasPages())
            <div class="tt-theme-pagination-wrap mt-5" data-aos="fade-up">
                {{ $destinations->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

@endsection
