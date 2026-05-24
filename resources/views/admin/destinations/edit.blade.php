@extends('admin.layouts.app')
@section('title') Edit Destination @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Edit Destination</h3>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            <form class="row g-3" action="{{ route('admin.destinations.update', $destination->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="name" class="form-label required">Name</label>
                    <input type="text" name="name" id="name" class="form-control makeSlug @error('name') is-invalid @enderror" value="{{ old('name', $destination->name) }}">
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control pageSlug" value="{{ old('slug', $destination->slug) }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $destination->country) }}">
                </div>
                <div class="col-md-4">
                    <label for="state" class="form-label">State</label>
                    <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $destination->state) }}">
                </div>
                <div class="col-md-4">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $destination->city) }}">
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Select Status</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('status', $destination->OriginalStatus) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    @if($destination->featured_image)
                        <div class="mb-2"><img src="{{ asset('storage/destinations/' . $destination->featured_image) }}" height="60" alt="Featured"></div>
                    @endif
                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label for="banner_image" class="form-label">Banner Image</label>
                    @if($destination->banner_image)
                        <div class="mb-2"><img src="{{ asset('storage/destinations/' . $destination->banner_image) }}" height="60" alt="Banner"></div>
                    @endif
                    <input type="file" name="banner_image" id="banner_image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label for="short_description" class="form-label">Short Description</label>
                    <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('short_description', $destination->short_description) }}">
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $destination->description) }}</textarea>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.update') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
