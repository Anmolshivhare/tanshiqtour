@extends('front.layouts.app')

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
                    <a href="{{ route('front.home') }}"><i class="fas fa-home me-1"></i>Home</a>
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
 
@endsection
