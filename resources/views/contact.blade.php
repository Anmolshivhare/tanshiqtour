@extends('front.layouts.app')

@section('content')
    @php
        $phone = $settingData->contact_phone ?? '';
        $email = $settingData->contact_email ?? '';
        $address = $settingData->address ?? '';
    @endphp

{{-- ============================================================
     CONTACT HERO BANNER
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
                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ol>
        </nav>
        <h1 class="tt-contact-hero__title">Contact <span>Us</span></h1>
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
     CONTACT INFO CARDS
============================================================ --}}
<section class="tt-contact-info py-5" id="contact-info">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Address --}}
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                <div class="tt-contact-card" id="contact-card-address">
                    <div class="tt-contact-card__icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="tt-contact-card__title">Our Address</h3>
                    <p class="tt-contact-card__text">{{ $address }}</p>
                </div>
            </div>

            {{-- Email --}}
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="tt-contact-card" id="contact-card-email">
                    <div class="tt-contact-card__icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h3 class="tt-contact-card__title">{{ $email }}</h3>
                    <p class="tt-contact-card__text">Email us anytime for any kind of query.</p>
                </div>
            </div>

            {{-- Phone --}}
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="tt-contact-card" id="contact-card-phone">
                    <div class="tt-contact-card__icon">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                    <h3 class="tt-contact-card__title">Hot: {{ $phone }}</h3>
                    <p class="tt-contact-card__text">Call us any kind support we will wait for it.</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ============================================================
     MAP + CONTACT FORM
============================================================ --}}
<section class="tt-contact-main py-5" id="contact-form-section">
    <div class="container">
        <div class="row g-5 align-items-start">

            {{-- LEFT: Embedded Map --}}
            <div class="col-lg-5" data-aos="fade-right">
                <div class="tt-contact-map">
                
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d887.4185215112226!2d78.03612516962596!3d27.166542791689533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397471c46e6ba04d%3A0xdaa3691a1a34b453!2sTanishq%20Tour%20%26%20Travels%20%7C%20best%20travel%20agency%20in%20agra!5e0!3m2!1sen!2sin!4v1781940985266!5m2!1sen!2sin" width="600" height="520" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            {{-- RIGHT: Contact Form --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div class="tt-contact-form-wrap">
                    <span class="tt-kicker-v2 mb-3">
                        <i class="fas fa-paper-plane me-1"></i> Get In Touch
                    </span>
                    <h2 class="tt-section-title mt-2 mb-2">
                        Ready to Get <span class="tt-accent">Started?</span>
                    </h2>
                
                    @if (session('contact_success'))
                        <div class="tt-contact-alert tt-contact-alert--success alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('contact_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="tt-contact-form" id="contact-form" action="{{ route('front.contact.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <div class="tt-contact-form__group">
                                    <label for="contact-name" class="tt-contact-form__label">
                                        Your Name<span class="text-danger">*</span>
                                    </label>
                                    <div class="tt-contact-form__input-wrap">
                                        <input
                                            type="text"
                                            id="contact-name"
                                            name="name"
                                            class="tt-contact-form__input @error('name') is-invalid @enderror"
                                            placeholder="Your Name"
                                            value="{{ old('name') }}"
                                            >
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="tt-contact-form__group">
                                    <label for="contact-email" class="tt-contact-form__label">
                                        Your Email<span class="text-danger">*</span>
                                    </label>
                                    <div class="tt-contact-form__input-wrap">
                                        <input
                                            type="email"
                                            id="contact-email"
                                            name="email"
                                            class="tt-contact-form__input @error('email') is-invalid @enderror"
                                            placeholder="Your Email"
                                            value="{{ old('email') }}"
                                            >
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="tt-contact-form__group">
                                    <label for="contact-phone" class="tt-contact-form__label">
                                        Your Phone<span class="text-danger">*</span>
                                    </label>
                                    <div class="tt-contact-form__input-wrap">
                                        <input
                                            type="tel"
                                            id="contact-phone"
                                            name="phone"
                                            class="tt-contact-form__input @error('phone') is-invalid @enderror"
                                            placeholder="Your phone"
                                            value="{{ old('phone') }}"
                                            >
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="tt-contact-form__group">
                                    <label for="contact-subject" class="tt-contact-form__label">
                                        Subject
                                    </label>
                                    <div class="tt-contact-form__input-wrap">
                                        <input
                                            type="text"
                                            id="contact-subject"
                                            name="subject"
                                            class="tt-contact-form__input @error('subject') is-invalid @enderror"
                                            placeholder="Subject"
                                            value="{{ old('subject') }}">
                                    </div>
                                    @error('subject')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Message --}}
                            <div class="col-12">
                                <div class="tt-contact-form__group">
                                    <label for="contact-message" class="tt-contact-form__label">
                                        Message<span class="text-danger">*</span>
                                    </label>
                                    <div class="tt-contact-form__input-wrap tt-contact-form__input-wrap--textarea">
                                        <textarea
                                            id="contact-message"
                                            name="message"
                                            class="tt-contact-form__input tt-contact-form__textarea @error('message') is-invalid @enderror"
                                            placeholder="Write Message..."
                                            rows="6"
                                            >{{ old('message') }}</textarea>
                                    </div>
                                    @error('message')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="col-12">
                                <button type="submit" class="tt-banner-slide__btn border-0" id="contact-submit-btn">
                                    Send Message <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
