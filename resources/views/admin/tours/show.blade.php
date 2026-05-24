@extends('admin.layouts.app')
@section('title') Tour Details @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">{{ $tour->title }}</h3>
        <div class="ms-auto">
            @can('tour-edit')
                <a href="{{ route('admin.tours.edit', encrypt($tour->id)) }}" class="btn btn-sm btn-warning">Edit</a>
            @endcan
            <a href="{{ route('admin.tours.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr><th>Title</th><td>{{ $tour->title }}</td></tr>
                        <tr><th>Slug</th><td>{{ $tour->slug }}</td></tr>
                        <tr><th>Location</th><td>{{ $tour->location ?? '—' }}</td></tr>
                        <tr><th>Duration</th><td>{{ $tour->duration ?? '—' }}</td></tr>
                        <tr><th>Price/Person</th><td>{{ $tour->price_per_person ? '₹' . number_format($tour->price_per_person, 2) : '—' }}</td></tr>
                        <tr><th>Max Persons</th><td>{{ $tour->max_persons ?? '—' }}</td></tr>
                        <tr><th>Destination</th><td>{{ $tour->destination->name ?? '—' }}</td></tr>
                        <tr><th>Status</th><td>{{ $tour->statusName->name ?? '—' }}</td></tr>
                        <tr><th>Created At</th><td>{{ $tour->created_at }}</td></tr>
                    </table>
                    @if($tour->description)
                        <h5 class="mt-3">Description</h5>
                        <p>{{ $tour->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if($tour->featured_image)
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/tours/' . $tour->featured_image) }}" class="img-fluid rounded" alt="Featured">
                    </div>
                </div>
            @endif
        </div>
        @if($tour->images->count())
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Gallery</h5>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($tour->images as $image)
                            <img src="{{ asset('storage/tours/gallery/' . $image->image_path) }}" height="100" class="rounded" alt="Gallery">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($tour->itineraryDays->count())
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Itinerary</h5>
                    @foreach($tour->itineraryDays as $day)
                        <div class="border-start border-3 border-primary ps-3 mb-3">
                            <h6>Day {{ $day->day_number }}: {{ $day->title }}</h6>
                            @if($day->description) <p class="mb-1">{{ $day->description }}</p> @endif
                            @if($day->accommodation) <small class="text-muted">🏨 {{ $day->accommodation }}</small> @endif
                            @if($day->meals_included) <small class="text-muted ms-2">🍽 {{ $day->meals_included }}</small> @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection