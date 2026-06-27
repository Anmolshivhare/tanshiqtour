@extends('front.layouts.app')

@section('title', 'Gallery | Travel Photos and Videos')
@section('meta_description', 'Explore Tanishq Tour & Travel gallery with destination photos and videos from our tours.')
@section('canonical', route('front.gallery'))

@section('content')
<section class="tt-contact-hero" id="gallery-hero">
    <div class="tt-contact-hero__bg"></div>
    <div class="tt-contact-hero__overlay"></div>
    <div class="container tt-contact-hero__content" data-aos="fade-up">
        <nav aria-label="breadcrumb" class="tt-contact-hero__breadcrumb">
            <ol class="breadcrumb justify-content-center mb-3">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Gallery</li>
            </ol>
        </nav>
        <h1 class="tt-contact-hero__title">Gallery</h1>
        <p class="tt-contact-hero__sub">Photos and videos from our curated travel experiences.</p>
    </div>
    <div class="tt-contact-hero__wave">
        <svg viewBox="0 0 1440 80" fill="none" preserveAspectRatio="none">
            <path d="M0 40 C360 80 1080 0 1440 40 L1440 80 L0 80 Z" fill="#ffffff"/>
        </svg>
    </div>
</section>

<section class="tt-section tt-gallery-page">
    <div class="container">
        <div class="tt-section-head text-center" data-aos="fade-up">
            <span class="tt-kicker-v2"><i class="fas fa-images me-1"></i> Travel Moments</span>
            <h2 class="tt-section-title"><span class="tt-accent">Tour Gallery</span></h2>
            <p class="tt-section-sub">Select a gallery title to view its photos.</p>
        </div>

        @php
            $allImages = $galleries->flatMap(function ($gallery) {
                $filterKey = \Illuminate\Support\Str::slug($gallery->title);

                return $gallery->images->map(function ($image) use ($gallery, $filterKey) {
                    return [
                        'url' => asset('storage/gallery/' . $image->file_path),
                        'title' => $gallery->title,
                        'key' => $filterKey,
                    ];
                });
            })->values();
        @endphp

        @if($allImages->isNotEmpty() || $hasVideos)
            <div class="tt-gallery-filter" data-aos="fade-up">
                <button type="button" class="tt-gallery-filter__btn active" data-gallery-filter="all">All</button>
                @foreach($filters as $filter)
                    <button type="button" class="tt-gallery-filter__btn" data-gallery-filter="{{ $filter['key'] }}">
                        {{ $filter['label'] }}
                    </button>
                @endforeach
                @if($hasVideos)
                    <button type="button" class="tt-gallery-filter__btn" data-gallery-filter="video">Video</button>
                @endif
            </div>

            <div id="frontGalleryShowcase">
                <div class="tt-gallery-panel" data-gallery-panel="all">
                    <div class="tt-gallery-panel__head">
                        <h3 class="tt-gallery-panel__title">Around the Destination</h3>
                        <p class="tt-gallery-panel__sub" id="frontGalleryPanelSub">All Galleries</p>
                    </div>

                    @if($allImages->isNotEmpty())
                        <div class="td-gallery-grid" id="frontGalleryGrid">
                            @foreach($allImages as $index => $image)
                                <div class="td-gallery-grid__item td-gallery-grid__item--clickable front-gallery-item"
                                    data-gallery-item
                                    data-gallery-key="{{ $image['key'] }}"
                                    data-gallery-src="{{ $image['url'] }}"
                                    data-gallery-index="{{ $index }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#frontGalleryLightboxModal"
                                    role="button"
                                    tabindex="0"
                                    aria-label="View {{ $image['title'] }} image {{ $index + 1 }}"
                                    data-aos="fade-up">
                                    <img src="{{ $image['url'] }}" alt="{{ $image['title'] }} image {{ $index + 1 }}"
                                        class="td-gallery-grid__img" loading="lazy">
                                    <div class="td-gallery-grid__overlay">
                                        <i class="fas fa-expand-alt"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @foreach($filters as $filter)
                    <div class="tt-gallery-panel d-none" data-gallery-panel="{{ $filter['key'] }}">
                        <div class="tt-gallery-panel__head">
                            <h3 class="tt-gallery-panel__title">Around the Destination</h3>
                            <p class="tt-gallery-panel__sub">{{ $filter['label'] }}</p>
                        </div>

                        @php
                            $titleImages = $allImages->where('key', $filter['key'])->values();
                        @endphp

                        @if($titleImages->isNotEmpty())
                            <div class="td-gallery-grid">
                                @foreach($titleImages as $index => $image)
                                    <div class="td-gallery-grid__item td-gallery-grid__item--clickable front-gallery-item"
                                        data-gallery-item
                                        data-gallery-key="{{ $image['key'] }}"
                                        data-gallery-src="{{ $image['url'] }}"
                                        data-gallery-index="{{ $index }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#frontGalleryLightboxModal"
                                        role="button"
                                        tabindex="0"
                                        aria-label="View {{ $image['title'] }} image {{ $index + 1 }}"
                                        data-aos="fade-up">
                                        <img src="{{ $image['url'] }}" alt="{{ $image['title'] }} image {{ $index + 1 }}"
                                            class="td-gallery-grid__img" loading="lazy">
                                        <div class="td-gallery-grid__overlay">
                                            <i class="fas fa-expand-alt"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="tt-gallery-empty">
                                <i class="fas fa-images"></i>
                                <p>No images found for {{ $filter['label'] }}.</p>
                            </div>
                        @endif
                    </div>
                @endforeach

                @if($hasVideos)
                    <div class="tt-gallery-panel d-none" data-gallery-panel="video">
                        <div class="tt-gallery-panel__head">
                            <h3 class="tt-gallery-panel__title">Tour Videos</h3>
                            <p class="tt-gallery-panel__sub">Watch our travel stories</p>
                        </div>
                        <div class="tt-gallery-video-grid">
                            @foreach($galleries as $gallery)
                                @if(!empty($gallery->file_path))
                                    @php
                                        $mediaUrl = asset('storage/gallery/' . $gallery->file_path);
                                        $thumbUrl = $gallery->thumbnail_path
                                            ? asset('storage/gallery/thumbnails/' . $gallery->thumbnail_path)
                                            : null;
                                    @endphp
                                    <article class="tt-gallery-card" data-aos="fade-up">
                                        <div class="tt-gallery-card__media">
                                            <video class="tt-gallery-card__video" controls preload="metadata" @if($thumbUrl) poster="{{ $thumbUrl }}" @endif>
                                                <source src="{{ $mediaUrl }}">
                                            </video>
                                            <span class="tt-gallery-card__badge"><i class="fas fa-play"></i> Video</span>
                                        </div>
                                        <div class="tt-gallery-card__body">
                                            <h3 class="tt-gallery-card__title">{{ $gallery->title }}</h3>
                                        </div>
                                    </article>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="tt-gallery-empty d-none" id="frontGalleryEmpty">
                <i class="fas fa-images"></i>
                <p>No gallery media found for this filter.</p>
            </div>

            @if($allImages->isNotEmpty())
                <div class="modal fade" id="frontGalleryLightboxModal" tabindex="-1" aria-label="Gallery Lightbox"
                    aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-fullscreen gallery-lightbox-dialog">
                        <div class="modal-content gallery-lightbox-content">
                            <div class="gallery-lightbox-topbar">
                                <span class="gallery-lightbox-counter" id="frontGalleryCounter">1 / 1</span>
                                <button type="button" class="gallery-lightbox-close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="gallery-lightbox-body" id="frontGalleryLightboxBody">
                                <button class="gallery-lightbox-arrow gallery-lightbox-arrow--prev" id="frontGalleryPrev"
                                    aria-label="Previous image">
                                    <i class="fas fa-chevron-left"></i>
                                </button>

                                <div class="gallery-lightbox-img-wrap" id="frontGalleryImgWrap">
                                    <img src="" alt="Gallery full view" class="gallery-lightbox-img" id="frontGalleryLightboxImg">
                                </div>

                                <button class="gallery-lightbox-arrow gallery-lightbox-arrow--next" id="frontGalleryNext"
                                    aria-label="Next image">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>

                            <div class="gallery-lightbox-thumbstrip" id="frontGalleryThumbStrip"></div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="tt-gallery-empty">
                <i class="fas fa-images"></i>
                <p>No gallery media available right now.</p>
            </div>
        @endif
    </div>
</section>

@include('base-family-travel')
@endsection
