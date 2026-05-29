@extends('front.layouts.app')

@section('content')

{{-- ============================================================
     HERO SECTION
============================================================ --}}
<section class="tt-hero-v2" id="hero">

    {{-- Floating Decorations --}}
    <div class="tt-hero-v2__deco">
        {{-- Animated SVG Airplane on curved dashed path --}}
        <svg class="tt-svg-path" viewBox="0 0 700 220" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path id="planePath" d="M 20 200 Q 200 20 400 120 T 680 30" stroke="#FFBE00" stroke-width="2" stroke-dasharray="8 6" fill="none" opacity="0.55"/>
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

                {{-- Glassmorphism Search Box --}}
                <div class="tt-search-glass" id="hero-search">
                    <form class="tt-search-glass__form">
                        <div class="tt-search-glass__field">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <label>Destination</label>
                                <select>
                                    <option value="">Anywhere</option>
                                    <option>Bali, Indonesia</option>
                                    <option>Paris, France</option>
                                    <option>Tokyo, Japan</option>
                                    <option>Dubai, UAE</option>
                                    <option>Maldives</option>
                                    <option>Switzerland</option>
                                    <option>Kashmir, India</option>
                                </select>
                            </div>
                        </div>
                        <div class="tt-search-glass__divider"></div>
                        <div class="tt-search-glass__field">
                            <i class="fas fa-layer-group"></i>
                            <div>
                                <label>Tour Type</label>
                                <select>
                                    <option value="">All Types</option>
                                    <option>Adventure</option>
                                    <option>Beach</option>
                                    <option>Cultural</option>
                                    <option>Wildlife</option>
                                    <option>Honeymoon</option>
                                </select>
                            </div>
                        </div>
                        <div class="tt-search-glass__divider"></div>
                        <div class="tt-search-glass__field">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <label>Travel Date</label>
                                <input type="date" placeholder="Select Date">
                            </div>
                        </div>
                        <div class="tt-search-glass__divider"></div>
                        <div class="tt-search-glass__field">
                            <i class="fas fa-users"></i>
                            <div>
                                <label>Travelers</label>
                                <select>
                                    <option>1 Person</option>
                                    <option>2 Adults</option>
                                    <option>Family (4)</option>
                                    <option>Group (10+)</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="tt-search-glass__btn">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                    </form>
                </div>
            </div>

            {{-- RIGHT: Swiper Coverflow Carousel --}}
            <div class="tt-hero-v2__carousel" id="hero-carousel">
                <div class="tt-lets-go-badge">Let's<br>Go! ✈</div>

                <div class="swiper tt-hero-swiper" id="heroSwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tt-hero-slide" style="background-image:url('https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80')">
                                <div class="tt-slide-label"><i class="fas fa-map-marker-alt me-1"></i> Bali, Indonesia</div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tt-hero-slide" style="background-image:url('https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=600&q=80')">
                                <div class="tt-slide-label"><i class="fas fa-map-marker-alt me-1"></i> Paris, France</div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tt-hero-slide" style="background-image:url('https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=600&q=80')">
                                <div class="tt-slide-label"><i class="fas fa-map-marker-alt me-1"></i> Tokyo, Japan</div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tt-hero-slide" style="background-image:url('https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80')">
                                <div class="tt-slide-label"><i class="fas fa-map-marker-alt me-1"></i> Dubai, UAE</div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tt-hero-slide" style="background-image:url('https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80')">
                                <div class="tt-slide-label"><i class="fas fa-map-marker-alt me-1"></i> Maldives</div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tt-hero-slide" style="background-image:url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80')">
                                <div class="tt-slide-label"><i class="fas fa-map-marker-alt me-1"></i> Switzerland</div>
                            </div>
                        </div>
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
<section class="tt-section tt-destinations" id="destinations">
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
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-globe me-1"></i> Popular Destination</span>
            <h2 class="tt-section-title">Popular <span class="tt-accent">Destinations</span></h2>
            <p class="tt-section-sub">Explore iconic escapes with luxury-crafted itineraries designed for unforgettable journeys.</p>
        </div>

        {{-- Filter tabs (optional, hidden by default – keep for JS hook) --}}
        {{-- Destination Swiper --}}
        <div class="tt-dest-slider-wrap" data-aos="fade-up" data-aos-delay="100">

            {{-- Header row: sub-title left + arrows right --}}
            <div class="tt-dest-slider-header">
                <p class="tt-dest-slider-subtitle">Top Destination For Your Next Vacation</p>
                <div class="tt-dest-arrows">
                    <button class="tt-destinations-prev tt-dest-arrow-btn" aria-label="Previous destination">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="tt-destinations-next tt-dest-arrow-btn" aria-label="Next destination">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            {{-- Swiper wrapper --}}
            <div class="swiper tt-destinations-swiper" id="destSwiper">
                <div class="swiper-wrapper">

                    @foreach ([
                        ['city'=>'Tokyo',     'country'=>'Japan',        'region'=>'asia',    'img'=>'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=600&q=80'],
                        ['city'=>'Bali',      'country'=>'Indonesia',    'region'=>'asia',    'img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80'],
                        ['city'=>'Bangkok',   'country'=>'Thailand',     'region'=>'asia',    'img'=>'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=600&q=80'],
                        ['city'=>'Cancun',    'country'=>'Mexico',       'region'=>'americas','img'=>'https://images.unsplash.com/photo-1510097467424-192d713fd8b2?w=600&q=80'],
                        ['city'=>'Paris',     'country'=>'France',       'region'=>'europe',  'img'=>'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=600&q=80'],
                        ['city'=>'Dubai',     'country'=>'UAE',          'region'=>'middle',  'img'=>'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80'],
                        ['city'=>'Maldives',  'country'=>'Maldives',     'region'=>'asia',    'img'=>'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80'],
                        ['city'=>'Switzerland','country'=>'Switzerland', 'region'=>'europe',  'img'=>'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80'],
                        ['city'=>'Kashmir',   'country'=>'India',        'region'=>'asia',    'img'=>'https://images.unsplash.com/photo-1566837945700-30057527ade0?w=600&q=80'],
                        ['city'=>'Kenya',     'country'=>'Africa',       'region'=>'africa',  'img'=>'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&q=80'],
                    ] as $dest)
                    <div class="swiper-slide" data-region="{{ $dest['region'] }}">
                        <div class="tt-dest-card">
                            <div class="tt-dest-card__img">
                                <img src="{{ $dest['img'] }}" alt="{{ $dest['city'] }}, {{ $dest['country'] }}" loading="lazy">
                                <div class="tt-dest-card__overlay"></div>
                            </div>
                            <div class="tt-dest-card__label">
                                {{ $dest['city'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="swiper-pagination tt-destinations-pagination"></div>
            </div>

            {{-- See All CTA --}}
            <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('front.tours') }}" class="tt-dest-see-all">
                    See All Destination
                </a>
            </div>
        </div>
    </div>
</section>


{{-- <section class="tt-section tt-destinations" id="destinations">
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
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-globe me-1"></i> Popular Destination</span>
            <h2 class="tt-section-title">Popular <span class="tt-accent">Destinations</span></h2>
            <p class="tt-section-sub">Explore iconic escapes with luxury-crafted itineraries designed for unforgettable journeys.</p>
        </div>

        
    </div>
</section> --}}

{{-- ============================================================
     WHY CHOOSE US
============================================================ --}}
<section class="tt-section tt-why" id="why-us">
    <div class="container">
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-award me-1"></i> Our Promise</span>
            <h2 class="tt-section-title">Why Choose <span class="tt-accent">Tanishq Tours</span></h2>
            <p class="tt-section-sub">We combine personalized planning with transparent pricing for unforgettable journeys.</p>
        </div>
        <div class="tt-why-grid">
            @foreach ([
                ['icon'=>'fa-solid fa-tag','title'=>'Best Price Guarantee','desc'=>'We match or beat any competitor price. Your dream trip, at the best value every single time.','color'=>'#022179'],
                ['icon'=>'fa-solid fa-user-tie','title'=>'Expert Guides','desc'=>'Our certified travel experts bring decades of experience to craft your perfect itinerary.','color'=>'#FFBE00'],
                ['icon'=>'fa-solid fa-headset','title'=>'24/7 Support','desc'=>'Round-the-clock assistance at every step of your journey, wherever you are in the world.','color'=>'#022179'],
                ['icon'=>'fa-solid fa-sliders','title'=>'Customized Tours','desc'=>'Tailor-made packages built around your preferences, timeline, and budget — 100% flexible.','color'=>'#FFBE00'],
            ] as $i => $feat)
            <div class="tt-why-card" data-aos="zoom-in" data-aos-delay="{{ $i * 100 }}">
                <div class="tt-why-card__icon" style="--c: {{ $feat['color'] }}">
                    <i class="{{ $feat['icon'] }}"></i>
                </div>
                <h3>{{ $feat['title'] }}</h3>
                <p>{{ $feat['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     FEATURED TOUR PACKAGES (with filter tabs)
============================================================ --}}
<section class="tt-section tt-packages" id="packages">
    <div class="container">
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-suitcase-rolling me-1"></i> Best Deals</span>
            <h2 class="tt-section-title">Featured <span class="tt-accent">Tour Packages</span></h2>
            <p class="tt-section-sub">Handpicked adventures, beaches, cultures, and wildlife experiences.</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="tt-filter-tabs" data-aos="fade-up">
            <button class="tt-filter-tab active" data-filter="all">All</button>
            <button class="tt-filter-tab" data-filter="adventure">Adventure</button>
            <button class="tt-filter-tab" data-filter="beach">Beach</button>
            <button class="tt-filter-tab" data-filter="cultural">Cultural</button>
            <button class="tt-filter-tab" data-filter="wildlife">Wildlife</button>
        </div>

        <div class="tt-pkg-grid" id="tt-pkg-grid">
            @foreach ([
                ['title'=>'Himalayan Trek','loc'=>'Kashmir','days'=>'7D/6N','rating'=>'4.9','price'=>'₹24,999','cat'=>'adventure','img'=>'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80'],
                ['title'=>'Bali Beach Escape','loc'=>'Indonesia','days'=>'6D/5N','rating'=>'4.8','price'=>'₹38,499','cat'=>'beach','img'=>'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80'],
                ['title'=>'Tokyo Cultural Tour','loc'=>'Japan','days'=>'8D/7N','rating'=>'4.7','price'=>'₹72,000','cat'=>'cultural','img'=>'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=600&q=80'],
                ['title'=>'African Safari','loc'=>'Kenya','days'=>'10D/9N','rating'=>'5.0','price'=>'₹1,45,000','cat'=>'wildlife','img'=>'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&q=80'],
                ['title'=>'Maldives Paradise','loc'=>'Maldives','days'=>'5D/4N','rating'=>'5.0','price'=>'₹55,000','cat'=>'beach','img'=>'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=600&q=80'],
                ['title'=>'Paris City Highlights','loc'=>'France','days'=>'7D/6N','rating'=>'4.8','price'=>'₹89,999','cat'=>'cultural','img'=>'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=600&q=80'],
                ['title'=>'Dubai City Highlights','loc'=>'UAE','days'=>'5D/4N','rating'=>'4.8','price'=>'₹32,999','cat'=>'adventure','img'=>'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=600&q=80'],
                ['title'=>'Swiss Alps Tour','loc'=>'Switzerland','days'=>'9D/8N','rating'=>'4.9','price'=>'₹1,10,000','cat'=>'adventure','img'=>'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&q=80'],
                ['title'=>'Jim Corbett Safari','loc'=>'Uttarakhand','days'=>'4D/3N','rating'=>'4.6','price'=>'₹18,999','cat'=>'wildlife','img'=>'https://images.unsplash.com/photo-1561731216-c3a4d99437d5?w=600&q=80'],
            ] as $i => $pkg)
            <div class="tt-pkg-card" data-cat="{{ $pkg['cat'] }}" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}">
                <div class="tt-pkg-card__img">
                    <img src="{{ $pkg['img'] }}" alt="{{ $pkg['title'] }}" loading="lazy">
                    <span class="tt-pkg-card__cat">{{ ucfirst($pkg['cat']) }}</span>
                </div>
                <div class="tt-pkg-card__body">
                    <div class="tt-pkg-card__loc"><i class="fas fa-map-marker-alt me-1"></i>{{ $pkg['loc'] }}</div>
                    <h3 class="tt-pkg-card__title">{{ $pkg['title'] }}</h3>
                    <div class="tt-pkg-card__meta">
                        <span><i class="fas fa-clock me-1"></i>{{ $pkg['days'] }}</span>
                        <span class="tt-pkg-card__rating"><i class="fas fa-star me-1"></i>{{ $pkg['rating'] }}</span>
                    </div>
                    <div class="tt-pkg-card__footer">
                        <div>
                            <span class="tt-pkg-card__label">From</span>
                            <span class="tt-pkg-card__price">{{ $pkg['price'] }}</span>
                        </div>
                        <a href="{{ route('front.tours') }}" class="tt-pkg-card__book">Book Now</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('front.tours') }}" class="tt-btn-hero-primary">
                <i class="fas fa-th-large me-2"></i> View All Packages
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     STATISTICS COUNTER
============================================================ --}}
<section class="tt-stats" id="stats">
    <div class="tt-stats__bg"></div>
    <div class="container">
        <div class="tt-stats__grid">
            @foreach ([
                ['icon'=>'fa-solid fa-users','num'=>1500,'suffix'=>'+','label'=>'Happy Travelers'],
                ['icon'=>'fa-solid fa-globe','num'=>80,'suffix'=>'+','label'=>'Destinations'],
                ['icon'=>'fa-solid fa-suitcase-rolling','num'=>200,'suffix'=>'+','label'=>'Tour Packages'],
                ['icon'=>'fa-solid fa-trophy','num'=>15,'suffix'=>'+','label'=>'Years Experience'],
            ] as $i => $stat)
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
<section class="tt-section tt-testimonials" id="testimonials">
    <div class="container">
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-heart me-1"></i> Happy Travelers</span>
            <h2 class="tt-section-title">What Our <span class="tt-accent">Clients Say</span></h2>
            <p class="tt-section-sub">Real experiences from real travelers who trusted Tanishq Tours.</p>
        </div>

        <div class="swiper tt-testi-swiper" id="testiSwiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                @foreach ([
                    ['name'=>'Rohit Sharma','loc'=>'Delhi, India','review'=>'The Kashmir trip was absolutely breathtaking! Hotels, transport, and guidance — everything was perfect. Will book again for sure!','rating'=>5,'avatar'=>'RS','color'=>'#022179'],
                    ['name'=>'Priya Mehta','loc'=>'Mumbai, India','review'=>'Our Bali honeymoon package was beyond expectations. Every detail was planned perfectly. Tanishq Tours made our dream come true!','rating'=>5,'avatar'=>'PM','color'=>'#FFBE00'],
                    ['name'=>'Arjun Singh','loc'=>'Pune, India','review'=>'Dubai tour was amazing — value for money, great hotel, and a fantastic guide. The team was so responsive and helpful.','rating'=>5,'avatar'=>'AS','color'=>'#022179'],
                    ['name'=>'Sneha Patel','loc'=>'Ahmedabad, India','review'=>'Booked the Maldives package as a surprise anniversary trip. My wife was overjoyed! Flawless experience from start to finish.','rating'=>5,'avatar'=>'SP','color'=>'#FFBE00'],
                    ['name'=>'Vikram Nair','loc'=>'Bengaluru, India','review'=>'The Swiss Alps tour was a dream come true. Tanishq made the entire process smooth, from visa assistance to hotel bookings.','rating'=>5,'avatar'=>'VN','color'=>'#022179'],
                    ['name'=>'Ananya Roy','loc'=>'Kolkata, India','review'=>'Tokyo cultural tour exceeded all my expectations. The guide was knowledgeable and the itinerary was perfectly balanced. 10/10!','rating'=>5,'avatar'=>'AR','color'=>'#FFBE00'],
                ] as $review)
                <div class="swiper-slide">
                    <div class="tt-testi-card">
                        <div class="tt-testi-card__stars">
                            @for ($s = 0; $s < $review['rating']; $s++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </div>
                        <p class="tt-testi-card__text">"{{ $review['review'] }}"</p>
                        <div class="tt-testi-card__author">
                            <div class="tt-testi-card__avatar" style="background: {{ $review['color'] }}">{{ $review['avatar'] }}</div>
                            <div>
                                <div class="tt-testi-card__name">{{ $review['name'] }}</div>
                                <div class="tt-testi-card__loc"><i class="fas fa-map-marker-alt me-1"></i>{{ $review['loc'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination tt-testi-pagination"></div>
            <div class="swiper-button-prev tt-testi-prev"><i class="fas fa-chevron-left"></i></div>
            <div class="swiper-button-next tt-testi-next"><i class="fas fa-chevron-right"></i></div>
        </div>
    </div>
</section>

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
            <p class="tt-cta-banner__sub">Let our travel experts craft your perfect journey. Call us or book online today!</p>
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
            <p class="tt-newsletter__note"><i class="fas fa-lock me-1"></i> We respect your privacy. No spam, ever.</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Page-specific init handled by front.js
    document.dispatchEvent(new Event('tt:home:ready'));
</script>
@endpush
