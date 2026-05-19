@extends('layouts.app')
@section('title') My Wishlist @endsection
@section('content')
<div class="container py-5">
    <h2>My Wishlist</h2>
    @if($wishlist->count())
        <div class="row g-4">
            @foreach($wishlist as $item)
                <div class="col-md-4">
                    <div class="card h-100">
                        @if($item->tour->featured_image)
                            <img src="{{ asset('storage/tours/' . $item->tour->featured_image) }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $item->tour->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->tour->title }}</h5>
                            <p class="text-muted mb-1">📍 {{ $item->tour->location ?? '—' }}</p>
                            <p class="text-muted mb-1">⏱ {{ $item->tour->duration ?? '—' }}</p>
                            @if($item->tour->price_per_person)
                                <p class="fw-bold">₹{{ number_format($item->tour->price_per_person, 0) }}/person</p>
                            @endif
                        </div>
                        <div class="card-footer d-flex gap-2">
                            <a href="{{ route('front.tours') }}" class="btn btn-sm btn-outline-primary">View Tour</a>
                            <button class="btn btn-sm btn-outline-danger wishlist-btn" data-tour-id="{{ $item->tour_id }}">Remove</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <h4 class="text-muted">Your wishlist is empty.</h4>
            <a href="{{ route('front.tours') }}" class="btn btn-primary mt-3">Browse Tours</a>
        </div>
    @endif
</div>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.wishlist-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const tourId = this.dataset.tourId;
        fetch('{{ route("front.wishlist.toggle") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ tour_id: tourId })
        }).then(r => r.json()).then(data => {
            if (data.success) { location.reload(); }
        });
    });
});
</script>
@endpush
