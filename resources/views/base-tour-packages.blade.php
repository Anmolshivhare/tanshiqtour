{{-- ============================================================
     FEATURED TOUR PACKAGES (with filter tabs)
============================================================ --}}
<section class="tt-section tt-packages position-relative overflow-hidden" id="packages">

    {{-- ── Top-Left decorative: Suitcase ── --}}
    <img src="{{ Vite::asset('resources/images/how-lagges.webp') }}" alt="" aria-hidden="true"
        class="tt-pkg-deco tt-pkg-deco--tl d-none d-lg-block">

    {{-- ── Bottom-Right decorative: Beach Palm ── --}}
    <img src="{{ Vite::asset('resources/images/testi-1-2.webp') }}" alt="" aria-hidden="true"
        class="tt-pkg-deco tt-pkg-deco--br d-none d-lg-block">

    <div class="container position-relative" style="z-index:2;">
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-suitcase-rolling me-1"></i> Best Deals</span>
            <h2 class="tt-section-title">Featured <span class="tt-accent">Tour Packages</span></h2>
            <p class="tt-section-sub">Handpicked adventures, beaches, cultures, and wildlife experiences.</p>
        </div>
        <div class="tt-pkg-grid" id="tt-pkg-grid">
            @forelse ($featuredTours as $i => $tour)
                @php
                    $tourImage = $tour->featured_image
                        ? asset('storage/tours/' . $tour->featured_image)
                        : Vite::asset('resources/images/banner1.webp');
                    $tourLocation = $tour->location ?: optional($tour->destination)->name;
                    $tourCategory = optional($tour->destination)->name ?: 'Featured';
                @endphp
                <div class="tt-pkg-card" data-cat="featured" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}">
                    <a href="{{ route('front.tour-details', $tour->slug) }}">

                        <div class="tt-pkg-card__img">
                            <img src="{{ $tourImage }}" alt="{{ $tour->title }}" loading="lazy">
                            <span class="tt-pkg-card__cat">{{ $tourCategory }}</span>
                        </div>
                        <div class="tt-pkg-card__body">
                            <div class="tt-pkg-card__loc"><i
                                    class="fas fa-map-marker-alt me-1"></i>{{ $tourLocation ?: 'Tour Package' }}</div>
                            <h3 class="tt-pkg-card__title">{{ ucwords($tour->title) }}</h3>
                            <div class="tt-pkg-card__meta">
                                @if ($tour->duration)
                                    <span><i class="fas fa-clock me-1"></i>{{ $tour->duration }}</span>
                                @endif
                                @if ($tour->max_persons)
                                    <span class="tt-pkg-card__rating"><i
                                            class="fas fa-users me-1"></i>{{ $tour->max_persons }}</span>
                                @endif
                            </div>
                            <div class="tt-pkg-card__footer">
                                <div>
                                    <span class="tt-pkg-card__label">From</span>
                                    <span class="tt-pkg-card__price">
                                        {!! $tour->price_per_person ? '&#8377;' . number_format($tour->price_per_person, 0) : 'On Request' !!}
                                    </span>
                                </div>
                                <a href="{{ route('front.tours') }}" class="tt-pkg-card__book">Book Now</a>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="text-center w-100" data-aos="fade-up">
                    <p class="tt-section-sub mb-0">No featured tour packages available right now.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('front.tours') }}" class="tt-btn-hero-primary">
                <i class="fas fa-th-large me-2"></i> View All Packages
            </a>
        </div>
    </div>
</section>


{{-- ============================================================
     FEATURED TOUR PACKAGES (with filter tabs)
============================================================ --}}
