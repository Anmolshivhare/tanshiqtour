@extends('front.layouts.app')

@section('content')

    @php
        $featuredImage = $tour->featured_image
            ? asset('storage/tours/' . $tour->featured_image)
            : asset(config('constants.destination_default_image'));

        $tourImages = $tour->images ?? collect();
        $location = $tour->location ?: $tour->destination?->name ?? 'Unknown Location';
        $avgRating = $tour->reviews->avg('rating') ?? 0;
        $reviewCount = $tour->reviews->count();
        $destination = $tour->destination;

        $highlights = collect($tour->highlights ?? [])
            ->map(fn($highlight) => trim((string) $highlight))
            ->filter()
            ->values()
            ->all();

        $amenities = collect($tour->amenities ?? [])
            ->map(function ($amenity) {
                $label = trim((string) ($amenity['label'] ?? ''));

                if ($label === '') {
                    return null;
                }

                return [
                    'label' => $label,
                    'available' => (bool) ($amenity['available'] ?? false),
                ];
            })
            ->filter()
            ->values()
            ->all();
    @endphp


    <section class="tt-contact-hero" id="destination-details-hero">
        <div class="tt-contact-hero__bg" style="background-image: url('{{ $featuredImage }}');"></div>
        <div class="tt-contact-hero__overlay"></div>
        <div class="container tt-contact-hero__content" data-aos="fade-up">
            <nav aria-label="breadcrumb" class="tt-contact-hero__breadcrumb">
                <ol class="breadcrumb justify-content-center mb-3">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('front.tours') }}">tours</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $tour->title }}</li>
                </ol>
            </nav>
            <h1 class="tt-contact-hero__title">{{ $tour->title }}</h1>
            <p class="tt-contact-hero__sub">
                <i class="fas fa-map-marker-alt me-1"></i> {{ $location ?: 'Discover this amazing destination with us.' }}
            </p>
        </div>

        <div class="tt-contact-hero__wave">
            <svg viewBox="0 0 1440 80" fill="none" preserveAspectRatio="none">
                <path d="M0 40 C360 80 1080 0 1440 40 L1440 80 L0 80 Z" fill="#ffffff" />
            </svg>
        </div>
    </section>

    {{-- ===================== BREADCRUMB + TITLE BAR ===================== --}}
    <section class="td-title-bar py-3 border-bottom bg-white"
        style="position:sticky; top:96px; z-index:99; background:#fff;">
        <div class="container">
            <div class="row align-items-center g-2">
                <div class="col-lg-8">
                    <h1 class="td-title mb-1">{{ $tour->title }}</h1>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        {{-- Stars --}}
                        <div class="td-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($avgRating))
                                    <i class="fas fa-star text-warning"></i>
                                @elseif ($i - $avgRating < 1)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="td-review-count ms-1">({{ $reviewCount }} Reviews)</span>
                        </div>
                        {{-- Location --}}
                        <span class="td-location-badge">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $location }}
                        </span>
                        {{-- Destination --}}
                        @if ($destination)
                            <span class="td-location-badge td-location-badge--dest">
                                <i class="fas fa-globe me-1"></i>{{ $destination->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== STATS BAR ===================== --}}
    <section class="td-stats-bar border-bottom">
        <div class="container">
            <div class="td-stats-bar__row">
                <div class="td-stats-bar__item">
                    <div class="td-stats-bar__icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="td-stats-bar__label">Location</div>
                        <div class="td-stats-bar__value">{{ $location }}</div>
                    </div>
                </div>
                <div class="td-stats-bar__divider"></div>
                <div class="td-stats-bar__item">
                    <div class="td-stats-bar__icon td-stats-bar__icon--accent">
                        <i class="fas fa-hiking"></i>
                    </div>
                    <div>
                        <div class="td-stats-bar__label">Activities Type</div>
                        <div class="td-stats-bar__value">Adventure</div>
                    </div>
                </div>
                <div class="td-stats-bar__divider"></div>
                <div class="td-stats-bar__item">
                    <div class="td-stats-bar__icon td-stats-bar__icon--teal">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <div class="td-stats-bar__label">Activate Day</div>
                        <div class="td-stats-bar__value">{{ $tour->duration ?? 'Flexible' }}</div>
                    </div>
                </div>
                <div class="td-stats-bar__divider"></div>
                <div class="td-stats-bar__item">
                    <div class="td-stats-bar__icon td-stats-bar__icon--gold">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <div class="td-stats-bar__label">Traveler</div>
                        <div class="td-stats-bar__value">
                            {{ $tour->max_persons ? 'Max ' . $tour->max_persons : 'Unlimited' }}</div>
                    </div>
                </div>
                {{-- @if ($tour->price_per_person)
            <div class="td-stats-bar__divider"></div>
            <div class="td-stats-bar__item td-stats-bar__item--price">
                <span class="td-price-badge">
                    ₹{{ number_format($tour->price_per_person) }}<small>/Person</small>
                </span>
            </div>
            @endif --}}
            </div>
        </div>
    </section>

    {{-- ===================== MAIN CONTENT + SIDEBAR ===================== --}}
    <section class="td-body py-5">
        <div class="container">
            <div class="row g-4 align-items-start">

                {{-- ---- LEFT: Main Content ---- --}}
                <div class="col-lg-8">

                    {{-- Overview --}}
                    <div class="td-section mb-4">
                        <h2 class="td-section__heading">Overview</h2>
                        <div class="td-section__text">
                            @if ($tour->description)
                                {!! $tour->description !!}
                            @else
                                <p>Experience the journey of a lifetime on this carefully curated tour package. Discover
                                    breathtaking landscapes, immerse in rich local culture, and create memories that will
                                    last forever. Our expert guides ensure every moment of your trip is exceptional.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Highlight List --}}
                    @if (!empty($highlights))
                        <div class="td-section mb-4">
                            <h2 class="td-section__heading">Highlight List</h2>
                            <div class="row g-1">
                                @foreach (array_chunk($highlights, 5) as $col)
                                    <div class="col-md-6">
                                        <ul class="td-highlight-list list-unstyled mb-0">
                                            @foreach ($col as $item)
                                                <li class="td-highlight-list__item">
                                                    <i
                                                        class="fas fa-check-circle text-success me-2"></i>{{ $item }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Tour Amenities --}}
                    @if (!empty($amenities))
                        <div class="td-section mb-4">
                            <h2 class="td-section__heading">Tour Amenities</h2>
                            <div class="row g-2">
                                @foreach (array_chunk($amenities, 4) as $col)
                                    <div class="col-md-6">
                                        @foreach ($col as $amenity)
                                            <div
                                                class="td-amenity-item {{ $amenity['available'] ? 'td-amenity-item--yes' : 'td-amenity-item--no' }}">
                                                @if ($amenity['available'])
                                                    <i class="fas fa-check text-success me-2"></i>
                                                @else
                                                    <i class="fas fa-times text-warning me-2"></i>
                                                @endif
                                                {{ $amenity['label'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Tour Gallery --}}
                    @php
                        $galleryImages =
                            $tourImages->count() > 0
                                ? $tourImages
                                    ->map(fn($img) => asset('storage/tours/gallery/' . $img->image_path))
                                    ->values()
                                : collect([asset(config('constants.destination_default_image'))]);
                    @endphp
                    @if ($tourImages->count() > 0)
                        <div class="td-section mb-4">
                            <h2 class="td-section__heading">Tour Gallery</h2>
                            <div class="td-gallery-grid" id="tourGalleryGrid">
                                @foreach ($galleryImages as $index => $imgUrl)
                                    <div class="td-gallery-grid__item td-gallery-grid__item--clickable"
                                        data-gallery-index="{{ $index }}" data-bs-toggle="modal"
                                        data-bs-target="#galleryLightboxModal" role="button" tabindex="0"
                                        aria-label="View image {{ $index + 1 }}">
                                        <img src="{{ $imgUrl }}" alt="Tour gallery image {{ $index + 1 }}"
                                            class="td-gallery-grid__img" loading="lazy">
                                        <div class="td-gallery-grid__overlay">
                                            <i class="fas fa-expand-alt"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- ===== GALLERY LIGHTBOX MODAL ===== --}}
                    <div class="modal fade" id="galleryLightboxModal" tabindex="-1" aria-label="Gallery Lightbox"
                        aria-modal="true" role="dialog">
                        <div class="modal-dialog modal-fullscreen gallery-lightbox-dialog">
                            <div class="modal-content gallery-lightbox-content">

                                {{-- Top Bar --}}
                                <div class="gallery-lightbox-topbar">
                                    <span class="gallery-lightbox-counter" id="galleryCounter">1 /
                                        {{ $galleryImages->count() }}</span>
                                    <button type="button" class="gallery-lightbox-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                {{-- Image Area --}}
                                <div class="gallery-lightbox-body" id="galleryLightboxBody">

                                    {{-- Prev Arrow --}}
                                    <button class="gallery-lightbox-arrow gallery-lightbox-arrow--prev" id="galleryPrev"
                                        aria-label="Previous image">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>

                                    {{-- Main Image --}}
                                    <div class="gallery-lightbox-img-wrap" id="galleryImgWrap">
                                        <img src="" alt="Gallery full view" class="gallery-lightbox-img"
                                            id="galleryLightboxImg">
                                    </div>

                                    {{-- Next Arrow --}}
                                    <button class="gallery-lightbox-arrow gallery-lightbox-arrow--next" id="galleryNext"
                                        aria-label="Next image">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>

                                {{-- Thumbnail Strip --}}
                                <div class="gallery-lightbox-thumbstrip" id="galleryThumbStrip">
                                    @foreach ($galleryImages as $index => $imgUrl)
                                        <div class="gallery-lightbox-thumb {{ $index === 0 ? 'active' : '' }}"
                                            data-index="{{ $index }}" data-src="{{ $imgUrl }}"
                                            role="button" tabindex="0" aria-label="Thumbnail {{ $index + 1 }}">
                                            <img src="{{ $imgUrl }}" alt="Thumb {{ $index + 1 }}"
                                                loading="lazy">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- ===== END LIGHTBOX MODAL ===== --}}

                    {{-- Tour Plan / Itinerary --}}
                    @if ($tour->itineraryDays->count() > 0)
                        <div class="td-section mb-4">
                            <h2 class="td-section__heading">Tour Plan</h2>
                            <div class="accordion td-accordion" id="itineraryAccordion">
                                @foreach ($tour->itineraryDays as $day)
                                    <div class="accordion-item td-accordion__item">
                                        <h2 class="accordion-header" id="day{{ $day->id }}Heading">
                                            <button
                                                class="accordion-button td-accordion__btn {{ !$loop->first ? 'collapsed' : '' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#day{{ $day->id }}Body"
                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                aria-controls="day{{ $day->id }}Body">
                                                <span class="td-accordion__day-badge">Day{{ $day->day_number }}</span>
                                                <span class="ms-2">{{ $day->title }}</span>
                                            </button>
                                        </h2>
                                        <div id="day{{ $day->id }}Body"
                                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                            aria-labelledby="day{{ $day->id }}Heading"
                                            data-bs-parent="#itineraryAccordion">
                                            <div class="accordion-body td-accordion__body">
                                                @if ($day->description)
                                                    <p>{{ $day->description }}</p>
                                                @endif
                                                @if ($day->accommodation)
                                                    <p><strong><i
                                                                class="fas fa-bed me-1 text-primary"></i>Accommodation:</strong>
                                                        {{ $day->accommodation }}</p>
                                                @endif
                                                @if ($day->meals_included)
                                                    <p><strong><i
                                                                class="fas fa-utensils me-1 text-success"></i>Meals:</strong>
                                                        {{ $day->meals_included }}</p>
                                                @endif
                                                @if ($day->activities)
                                                    <p><strong><i
                                                                class="fas fa-hiking me-1 text-warning"></i>Activities:</strong>
                                                        {{ $day->activities }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        {{-- Fallback itinerary demo --}}
                        <div class="td-section mb-4">
                            <h2 class="td-section__heading">Tour Plan</h2>
                            <div class="accordion td-accordion" id="itineraryAccordion">
                                @foreach ([['day' => 1, 'title' => 'Arrival & City Orientation', 'desc' => 'Arrive at the destination and check in to your hotel. Evening orientation walk around the city highlights.'], ['day' => 2, 'title' => 'Guided Heritage Tour', 'desc' => 'Full day guided tour to heritage sites, museums and local markets. Enjoy authentic local cuisine for lunch.'], ['day' => 3, 'title' => 'Adventure Activities Day', 'desc' => 'Choose from a range of thrilling adventure activities. Evening bonfire and cultural performance.'], ['day' => 4, 'title' => 'Leisure & Shopping', 'desc' => 'Free morning for leisure. Afternoon shopping at local bazaars. Farewell dinner at a premium restaurant.']] as $item)
                                    <div class="accordion-item td-accordion__item">
                                        <h2 class="accordion-header" id="demoDay{{ $item['day'] }}Heading">
                                            <button
                                                class="accordion-button td-accordion__btn {{ $item['day'] !== 1 ? 'collapsed' : '' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#demoDay{{ $item['day'] }}Body"
                                                aria-expanded="{{ $item['day'] === 1 ? 'true' : 'false' }}">
                                                <span class="td-accordion__day-badge">Day{{ $item['day'] }}</span>
                                                <span class="ms-2">{{ $item['title'] }}</span>
                                            </button>
                                        </h2>
                                        <div id="demoDay{{ $item['day'] }}Body"
                                            class="accordion-collapse collapse {{ $item['day'] === 1 ? 'show' : '' }}">
                                            <div class="accordion-body td-accordion__body">
                                                <p>{{ $item['desc'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (($relatedTours ?? collect())->count() > 0)
                        <div class="td-section td-tour-slider-section mb-4">
                            <div class="td-tour-slider-head">
                                <div>
                                    <h2 class="td-section__heading mb-1">Related Tour Packages</h2>
                                    {{-- <p class="tt-section-sub mb-0">Handpicked adventures, beaches, cultures, and wildlife experiences.</p> --}}
                                </div>
                                <div class="td-tour-slider-nav">
                                    <button type="button" class="td-tour-slider-prev" aria-label="Previous tour">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="td-tour-slider-next" aria-label="Next tour">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="swiper td-tour-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($relatedTours as $i => $relatedTour)
                                        @php
                                            $relatedTourImage = $relatedTour->featured_image
                                                ? asset('storage/tours/' . $relatedTour->featured_image)
                                                : Vite::asset('resources/images/banner1.webp');
                                            $relatedTourLocation =
                                                $relatedTour->location ?: optional($relatedTour->destination)->name;
                                            $relatedTourCategory =
                                                optional($relatedTour->destination)->name ?: 'Tour Package';
                                        @endphp

                                        <div class="swiper-slide">
                                            <div class="tt-pkg-card" data-cat="featured" data-aos="fade-up"
                                                data-aos-delay="{{ ($i % 3) * 80 }}">
                                                <a href="{{ route('front.tour-details', $relatedTour->slug) }}">
                                                    <div class="tt-pkg-card__img">
                                                        <img src="{{ $relatedTourImage }}"
                                                            alt="{{ $relatedTour->title }}" loading="lazy">
                                                        <span class="tt-pkg-card__cat">{{ $relatedTourCategory }}</span>
                                                    </div>
                                                    <div class="tt-pkg-card__body">
                                                        <div class="tt-pkg-card__loc">
                                                            <i
                                                                class="fas fa-map-marker-alt me-1"></i>{{ $relatedTourLocation ?: 'Tour Package' }}
                                                        </div>
                                                        <h3 class="tt-pkg-card__title">{{ ucwords($relatedTour->title) }}
                                                        </h3>
                                                        <div class="tt-pkg-card__meta">
                                                            @if ($relatedTour->duration)
                                                                <span><i
                                                                        class="fas fa-clock me-1"></i>{{ $relatedTour->duration }}</span>
                                                            @endif
                                                            @if ($relatedTour->max_persons)
                                                                <span class="tt-pkg-card__rating"><i
                                                                        class="fas fa-users me-1"></i>{{ $relatedTour->max_persons }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="tt-pkg-card__footer">
                                                            {{--  <div>
                                                                <span class="tt-pkg-card__label">From</span>
                                                                <span class="tt-pkg-card__price">
                                                                    {!! $relatedTour->price_per_person ? '&#8377;' . number_format($relatedTour->price_per_person, 0) : 'On Request' !!}
                                                                </span>
                                                            </div> --}}
                                                            <span class="tt-pkg-card__book">Book Now</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination td-tour-slider-pagination"></div>
                            </div>
                        </div>
                    @endif
                    {{-- Reviews Section --}}
                    @if ($tour->reviews->count() > 0)
                        <div class="td-section td-tour-slider-section td-review-slider-section mb-4">
                            <div class="td-tour-slider-head">
                                <div>
                                    <h2 class="td-section__heading mb-1">Traveler Reviews</h2>
                                </div>
                                <div class="td-tour-slider-nav">
                                    <button type="button" class="td-review-slider-prev" aria-label="Previous review">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="td-review-slider-next" aria-label="Next review">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="swiper td-review-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($tour->reviews as $review)
                                        <div class="swiper-slide">
                                            <div class="td-review-card">
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <div class="td-review-card__avatar"
                                                        style="{{ $review->client_pic ? 'background:none;padding:0;overflow:hidden;' : '' }}">
                                                        @if ($review->client_pic)
                                                            <img src="{{ asset('storage/reviews/' . $review->client_pic) }}"
                                                                alt="{{ $review->reviewer_name }}"
                                                                style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                                                        @else
                                                            {{ strtoupper(substr($review->reviewer_name ?? 'U', 0, 1)) }}
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <div class="td-review-card__name">
                                                            {{ $review->reviewer_name ?? 'Anonymous' }}</div>
                                                        <div class="td-review-card__stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"
                                                                    style="font-size:11px;"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($review->review_title)
                                                    <p class="td-review-card__title">{{ $review->review_title }}</p>
                                                @endif
                                                <p class="td-review-card__body">{{ $review->review_body }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination td-review-slider-pagination"></div>
                            </div>
                        </div>
                    @endif

                    {{-- ============================================================
                     Add a Review Form
                ============================================================ --}}
                    <div class="td-section td-review-form-section mb-4" id="add-review">

                        {{-- Success message --}}
                        @if (session('review_success'))
                            <div
                                class="tt-review-alert tt-review-alert--success d-flex align-items-start justify-content-between gap-3 mb-4 alert alert-success">
                                <div class="d-flex align-items-start gap-3">
                                    <i class="fas fa-check-circle mt-1"></i>
                                    <span>{{ session('review_success') }}</span>
                                </div>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        @endif

                        <h2 class="td-section__heading">Add a Review</h2>

                        <form action="{{ route('front.tour.review.store', $tour->slug) }}" method="POST"
                            enctype="multipart/form-data" id="reviewForm" novalidate>
                            @csrf

                            {{-- Star Rating --}}
                            <div class="tt-review-form__rating-row mb-4">
                                <label class="tt-review-form__label">Your Rating <span
                                        class="text-danger">*</span></label>
                                <div class="tt-star-rating" id="starRating">
                                    @for ($s = 1; $s <= 5; $s++)
                                        <input type="radio" name="rating" id="star{{ $s }}"
                                            value="{{ $s }}" class="tt-star-rating__input visually-hidden"
                                            {{ old('rating') == $s ? 'checked' : '' }}>
                                        <label for="star{{ $s }}" class="tt-star-rating__label"
                                            title="{{ $s }} star">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <div class="tt-review-form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Profile Picture Upload --}}
                            <div class="tt-review-form__upload-row mb-4">
                                <label class="tt-review-form__label mb-2">Profile Photo <span
                                        class="text-muted fw-normal">(optional)</span></label>
                                <div class="tt-review-upload d-flex align-items-center gap-3">
                                    <div class="tt-review-upload__preview" id="uploadPreview">
                                        <i class="fas fa-user tt-review-upload__icon"></i>
                                    </div>
                                    <div class="tt-review-upload__actions">
                                        <label for="client_pic" class="tt-review-upload__btn">
                                            <i class="fas fa-camera me-2"></i>Upload Photo
                                        </label>
                                        <input type="file" name="client_pic" id="client_pic"
                                            accept="image/jpeg,image/png,image/jpg,image/webp" class="visually-hidden">
                                        <p class="tt-review-upload__hint mt-1 mb-0">JPG, PNG or WebP · Max 2 MB</p>
                                        @error('client_pic')
                                            <div class="tt-review-form__error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Name & Email --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="reviewer_name" class="tt-review-form__label">
                                        Your Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="tt-review-form__input form-control @error('reviewer_name') is-invalid @enderror"
                                        id="reviewer_name" name="reviewer_name" placeholder="Your Name"
                                        value="{{ old('reviewer_name') }}">
                                    @error('reviewer_name')
                                        <div class="tt-review-form__error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="reviewer_email" class="tt-review-form__label">
                                        Your Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                        class="tt-review-form__input form-control @error('reviewer_email') is-invalid @enderror"
                                        id="reviewer_email" name="reviewer_email" placeholder="Your Email"
                                        value="{{ old('reviewer_email') }}">
                                    @error('reviewer_email')
                                        <div class="tt-review-form__error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Review Title --}}
                            <div class="mb-3">
                                <label for="review_title" class="tt-review-form__label">
                                    Review Title <span class="text-muted fw-normal">(optional)</span>
                                </label>
                                <input type="text"
                                    class="tt-review-form__input form-control @error('review_title') is-invalid @enderror"
                                    id="review_title" name="review_title" placeholder="Summarize your experience"
                                    value="{{ old('review_title') }}">
                                @error('review_title')
                                    <div class="tt-review-form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div class="mb-4">
                                <label for="review_body" class="tt-review-form__label">
                                    Message <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    class="tt-review-form__input tt-review-form__textarea form-control @error('review_body') is-invalid @enderror"
                                    id="review_body" name="review_body" rows="5" placeholder="Write your experience...">{{ old('review_body') }}</textarea>
                                @error('review_body')
                                    <div class="tt-review-form__error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="tt-review-form__submit" id="reviewSubmitBtn">
                                Submit Now <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                    {{-- END Add a Review Form --}}

                </div>{{-- end col-lg-8 --}}

                {{-- ---- RIGHT: Booking Sidebar ---- --}}
                <div class="col-lg-4">
                    <div class="td-booking-card" style="position:sticky; top:110px; z-index:10;">
                        <div class="td-booking-card__header">
                            <h3 class="td-booking-card__title">Book This Tour</h3>
                            {{-- @if ($tour->price_per_person)
                                <div class="td-booking-card__price">
                                    <span class="td-booking-card__price-from">from</span>
                                    <span
                                        class="td-booking-card__price-value">₹{{ number_format($tour->price_per_person) }}</span>
                                </div>
                            @endif --}}
                        </div>

                        <div class="td-booking-card__body">
                            @if (session('tour_enquiry_success'))
                                <div class="tt-tour-enquiry-alert tt-tour-enquiry-alert--success alert alert-success alert-dismissible fade show mb-3"
                                    role="alert">
                                    <i class="fas fa-check-circle me-2"></i>{{ session('tour_enquiry_success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('front.tour.enquiry.store', $tour->slug) }}" method="POST"
                                id="tourEnquiryForm" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-md-12  col-sm-12  td-booking-field mb-3">
                                        <label for="tour-enquiry-name" class="td-booking-field__label">Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control td-booking-field__input"
                                                name="name" id="tour-enquiry-name" placeholder="Name"
                                                value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12  col-sm-12 td-booking-field mb-3">
                                        <label for="tour-enquiry-email" class="td-booking-field__label">Email</label>
                                        <div class="input-group">
                                            <input type="email" class="form-control td-booking-field__input"
                                                name="email" id="tour-enquiry-email" placeholder="Email"
                                                value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12  col-sm-12  td-booking-field mb-3">
                                        <label for="tour-enquiry-phone" class="td-booking-field__label">Phone</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control td-booking-field__input"
                                                name="phone" id="tour-enquiry-phone" placeholder="Phone"
                                                value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12  col-sm-12  td-booking-field mb-3">
                                        <label for="tour-enquiry-subject" class="td-booking-field__label">Subject</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control td-booking-field__input"
                                                name="subject" id="tour-enquiry-subject" placeholder="Subject"
                                                value="{{ old('subject', 'Tour booking enquiry') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12  col-sm-12  td-booking-field mb-3">
                                        <label for="tour-enquiry-city" class="td-booking-field__label">City</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control td-booking-field__input"
                                                name="city" id="tour-enquiry-city" placeholder="City"
                                                value="{{ old('city') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12  col-sm-12 td-booking-field mb-3">
                                        <label for="tour-enquiry-travel-date" class="td-booking-field__label">Travel
                                            Date</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control td-booking-field__input"
                                                name="travel_date" id="tour-enquiry-travel-date"
                                                value="{{ old('travel_date') }}">
                                            <span class="input-group-text bg-white border-start-0">
                                                <i class="far fa-calendar-alt text-primary"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="adults" class="td-booking-field__label">Adults</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-warning btn-outline-dark"
                                                onclick="changeValue('adults', -1)">-</button>

                                            <input type="number" id="adults" name="adults"
                                                class="form-control text-center" value="{{ old('adults', 1) }}"
                                                min="1">

                                            <button type="button" class="btn btn-warning btn-outline-dark"
                                                onclick="changeValue('adults', 1)">+</button>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="children" class="td-booking-field__label">Children</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-warning btn-outline-dark"
                                                onclick="changeValue('children', -1)">-</button>

                                            <input type="number" id="children" name="children"
                                                class="form-control text-center" value="{{ old('children', 0) }}"
                                                min="0">

                                            <button type="button" class="btn btn-warning btn-outline-dark"
                                                onclick="changeValue('children', 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="td-booking-field mb-3">
                                        <label for="tour-enquiry-tour" class="td-booking-field__label">Tour</label>
                                        <input type="text" class="form-control td-booking-field__input"
                                            id="tour-enquiry-tour" value="{{ $tour->title }}" disabled>
                                        <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                                    </div>
                                </div>
                                <button type="submit" class="btn td-booking-btn w-100" id="tourEnquirySubmitBtn">
                                    Book Now &raquo;
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function changeValue(id, change) {
            let input = document.getElementById(id);
            let value = parseInt(input.value) || 0;
            let min = parseInt(input.min) || 0;

            value += change;

            if (value < min) {
                value = min;
            }

            input.value = value;
        }
    </script>
@endpush
