@extends('admin.layouts.app')
@section('title') Destination Details @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Destination: {{ $destination->name }}</h3>
        <a href="{{ route('admin.destinations.index') }}" class="btn btn-sm btn-secondary ms-auto">Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr><th>Name</th><td>{{ $destination->name }}</td></tr>
                        <tr><th>Slug</th><td>{{ $destination->slug }}</td></tr>
                        <tr><th>Country</th><td>{{ $destination->country ?? '—' }}</td></tr>
                        <tr><th>State</th><td>{{ $destination->state ?? '—' }}</td></tr>
                        <tr><th>City</th><td>{{ $destination->city ?? '—' }}</td></tr>
                        <tr><th>Status</th><td>{{ $destination->statusName->name ?? '—' }}</td></tr>
                        <tr><th>Created At</th><td>{{ $destination->created_at }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    @if($destination->featured_image)
                        <div class="mb-3">
                            <strong>Featured Image:</strong><br>
                            <img src="{{ asset('storage/destinations/' . $destination->featured_image) }}" class="img-fluid rounded" style="max-height:200px" alt="Featured">
                        </div>
                    @endif
                    @if($destination->banner_image)
                        <div>
                            <strong>Banner Image:</strong><br>
                            <img src="{{ asset('storage/destinations/' . $destination->banner_image) }}" class="img-fluid rounded" style="max-height:150px" alt="Banner">
                        </div>
                    @endif
                </div>
                @if($destination->description)
                    <div class="col-12 mt-3">
                        <h5>Description</h5>
                        <p>{{ $destination->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
