@php
    $isPaginator = $tours instanceof \Illuminate\Contracts\Pagination\Paginator
        || $tours instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
@endphp

<div class="tt-pkg-grid" id="tt-pkg-grid">
    @forelse ($tours as $i => $tour)
        @php
            $tourImage = $tour->featured_image
                ? asset('storage/tours/' . $tour->featured_image)
                : Vite::asset('resources/images/banner1.webp');
            $tourLocation = $tour->location ?: optional($tour->destination)->name;
            $tourCategory = optional($tour->destination)->name ?: 'Tour Package';
        @endphp

        <div class="tt-pkg-card" data-cat="featured" data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}">
            <a href="{{ route('front.tour-details', $tour->slug) }}">
                <div class="tt-pkg-card__img">
                    <img src="{{ $tourImage }}" alt="{{ $tour->title }}" loading="lazy">
                    <span class="tt-pkg-card__cat">{{ $tourCategory }}</span>
                </div>

                <div class="tt-pkg-card__body">
                    <div class="tt-pkg-card__loc">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ $tourLocation ?: 'Tour Package' }}
                    </div>
                    <h3 class="tt-pkg-card__title">{{ ucwords($tour->title) }}</h3>
                    <div class="tt-pkg-card__meta">
                        @if ($tour->duration)
                            <span><i class="fas fa-clock me-1"></i>{{ $tour->duration }}</span>
                        @endif
                        @if ($tour->max_persons)
                            <span class="tt-pkg-card__rating"><i class="fas fa-users me-1"></i>{{ $tour->max_persons }}</span>
                        @endif
                    </div>
                    <div class="tt-pkg-card__footer">
                        {{-- <div>
                            <span class="tt-pkg-card__label">From</span>
                            <span class="tt-pkg-card__price">
                                {!! $tour->price_per_person ? '&#8377;' . number_format($tour->price_per_person, 0) : 'On Request' !!}
                            </span>
                        </div> --}}
                        <span class="tt-pkg-card__book">Book Now</span>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <div class="tt-destination-empty text-center">
                <h3>No tour packages found</h3>
                <p>Try a different name, destination, or location in search.</p>
            </div>
        </div>
    @endforelse
</div>

@if ($isPaginator && $tours->hasPages())
    <div class="tt-theme-pagination-wrap mt-5" data-aos="fade-up">
        {{ $tours->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
@endif
