@php
    $isPaginator = $destinations instanceof \Illuminate\Contracts\Pagination\Paginator
        || $destinations instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
@endphp

<div class="tt-pkg-grid" id="tt-pkg-grid">
    @forelse ($destinations as $i => $destination)
        @php
            $image = $destination->featured_image
                ? asset('storage/destinations/' . $destination->featured_image)
                : Vite::asset(config('constants.destination_default_image'));
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

@if ($isPaginator && $destinations->hasPages())
    <div class="tt-theme-pagination-wrap mt-5" data-aos="fade-up">
        {{ $destinations->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
@endif
