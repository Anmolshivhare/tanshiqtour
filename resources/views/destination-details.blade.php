@extends('front.layouts.app')

@section('content')
@php
    $bannerImage = $destination->banner_image
        ? asset('storage/destinations/' . $destination->banner_image)
        : ($destination->featured_image
            ? asset('storage/destinations/' . $destination->featured_image)
            : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=1600&q=80');

    $featuredImage = $destination->featured_image
        ? asset('storage/destinations/' . $destination->featured_image)
        : $bannerImage;

    $location = trim(implode(', ', array_filter([$destination->city, $destination->state, $destination->country])));
@endphp

<section class="tt-contact-hero" id="destination-details-hero">
    <div class="tt-contact-hero__bg" style="background-image: url('{{ $bannerImage }}');"></div>
    <div class="tt-contact-hero__overlay"></div>
    <div class="container tt-contact-hero__content" data-aos="fade-up">
        <nav aria-label="breadcrumb" class="tt-contact-hero__breadcrumb">
            <ol class="breadcrumb justify-content-center mb-3">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('front.destinations') }}">Destinations</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $destination->name }}</li>
            </ol>
        </nav>
        <h1 class="tt-contact-hero__title">{{ $destination->name }}</h1>
        <p class="tt-contact-hero__sub">
            {{ $location ?: 'Discover this amazing destination with us.' }}
        </p>
    </div>

    <div class="tt-contact-hero__wave">
        <svg viewBox="0 0 1440 80" fill="none" preserveAspectRatio="none">
            <path d="M0 40 C360 80 1080 0 1440 40 L1440 80 L0 80 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<section class="tt-section tt-destination-details mb-5">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="tt-destination-details__media">
                    <img src="{{ $featuredImage }}" alt="{{ $destination->name }}" class="img-fluid">
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left">
                <div class="tt-destination-details__content">
                    <span class="tt-kicker-v2"><i class="fas fa-map-marked-alt me-1"></i> Destination</span>
                    <h2 class="tt-section-title mb-3">{{ $destination->name }}</h2>

                    <div class="tt-destination-details__short mb-4">
                        <h3>Short Description</h3>
                        <p>
                            {{ $destination->short_description ?: 'Short description is not available for this destination yet.' }}
                        </p>
                    </div>

                    <div class="tt-destination-details__long">
                        <h3>Long Description</h3>
                        <div class="tt-destination-details__long-text">
                            {!! $destination->description ?: '<p>Long description is not available for this destination yet.</p>' !!}
                        </div>
                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <a href="{{ route('front.tours') }}" class="tt-btn-hero-primary">
                            <i class="fas fa-compass me-1"></i> Explore Packages
                        </a>
                        <a href="{{ route('front.destinations') }}" class="tt-btn-about-outline">
                            <i class="fas fa-arrow-left me-1"></i> Back to Destinations
                        </a>
                    </div>
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
@endsection
