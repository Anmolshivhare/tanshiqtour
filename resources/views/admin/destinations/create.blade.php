@extends('admin.layouts.app')
@section('title') Create Destination @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Create Destination</h3>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            <form class="row g-3" action="{{ route('admin.destinations.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label required">Name</label>
                    <input type="text" name="name" id="name" class="form-control makeSlug @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Destination name">
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control pageSlug @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Auto-generated if empty" readonly>
                    @error('slug') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" name="country" id="country" class="form-control" value="{{ old('country') }}" placeholder="Country">
                </div>
                <div class="col-md-4">
                    <label for="state" class="form-label">State</label>
                    <input type="text" name="state" id="state" class="form-control" value="{{ old('state') }}" placeholder="State">
                </div>
                <div class="col-md-4">
                    <label for="city" class="form-label">City</label>
                    <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}" placeholder="City">
                </div>

                <div class="col-md-6">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label for="banner_image" class="form-label">Banner Image</label>
                    <input type="file" name="banner_image" id="banner_image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label for="short_description" class="form-label">Short Description</label>
                    <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('short_description') }}" placeholder="Brief description">
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Long Description">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
