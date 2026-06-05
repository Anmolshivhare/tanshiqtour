{{-- ============================================================
     POPULAR DESTINATIONS
============================================================ --}}
<section class="tt-section tt-destinations position-relative overflow-hidden" id="destinations">

    {{-- Animated background decorations --}}
    <div class="tt-destinations__bg" aria-hidden="true">
        <svg class="tt-flight-path tt-flight-path--one" viewBox="0 0 720 240" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15 210C140 112 256 34 418 70C565 102 655 168 705 28" />
        </svg>
        <svg class="tt-flight-path tt-flight-path--two" viewBox="0 0 760 260" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 45C120 120 230 150 320 210C460 300 610 220 748 100" />
        </svg>
        <i class="fa-solid fa-plane tt-floating-plane tt-floating-plane--one"></i>
        <i class="fa-solid fa-plane tt-floating-plane tt-floating-plane--two"></i>
        <i class="fa-solid fa-plane tt-floating-plane tt-floating-plane--three"></i>
    </div>

    <div class="container">

        {{-- Section heading --}}
        <div class="text-center mb-4" data-aos="fade-up">
            <span class="tt-kicker-v2">
                <i class="fas fa-globe me-1"></i> Popular Destination
            </span>
            <h2 class="tt-section-title mt-2 mb-2">
                Popular <span class="tt-accent">Destinations</span>
            </h2>
            <p class="tt-section-sub mx-auto">
                Explore iconic escapes with luxury-crafted itineraries designed for unforgettable journeys good.
            </p>
        </div>

        {{-- Slider wrap --}}
        <div data-aos="fade-up" data-aos-delay="100">

            {{-- Header row: subtitle left + arrow buttons right --}}
            <div class="tt-destinations__topbar d-flex justify-content-between flex-wrap gap-2 mb-3">
                <p class="fw-bold fs-6 text-dark mb-0">Top Destination For Your Next Vacation</p>
                <div class="tt-destinations__nav d-flex gap-2">
                    <button type="button" class="tt-destinations-prev tt-dest-arrow-btn d-flex align-items-center justify-content-center"
                            aria-label="Previous destination">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="tt-destinations-next tt-dest-arrow-btn d-flex align-items-center justify-content-center"
                            aria-label="Next destination">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            {{-- Swiper --}}
            <div class="swiper tt-destinations-swiper" id="destSwiper">
                <div class="swiper-wrapper">

                    @foreach ($destinationsData as $dest)
                    <div class="swiper-slide">
                        <div class="tt-dest-card position-relative overflow-hidden rounded-4 w-100">
                         <a href="{{ route('front.destination-details', $dest['slug']) }}">

                            {{-- Image fills entire card --}}
                            <img src="{{ asset('storage/destinations/' . $dest['featured_image']) }}"
                                 alt="{{ $dest['city'] }}, {{ $dest['country'] }}"
                                 loading="lazy"
                                 class="tt-dest-card__img position-absolute top-0 start-0 w-100 h-100 object-fit-cover">

                            {{-- Gradient overlay --}}
                            <div class="tt-dest-card__overlay position-absolute top-0 start-0 w-100 h-100"></div>

                            {{-- City label — bottom-left --}}
                            <div class="tt-dest-card__label position-absolute bottom-0 start-0 w-100 text-white fw-bold">
                                {{ $dest['city'] }}
                            </div>
                         </a>
                        </div>
                    </div>
                    @endforeach

                </div>
                {{-- Swiper pagination dots --}}
                <div class="swiper-pagination tt-destinations-pagination"></div>
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('front.destinations') }}" class="tt-btn-hero-primary">
                <i class="fas fa-th-large me-2"></i>   See All Destination
            </a>
        </div>

        </div>{{-- /slider wrap --}}
    </div>{{-- /container --}}
</section>

 {{-- ============================================================
     POPULAR DESTINATIONS END
============================================================ --}}
