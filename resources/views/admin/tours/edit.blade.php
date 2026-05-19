@extends('admin.layouts.app')
@section('title')
    {{ __('labels.edit_page', ['action' => __('labels.tour')]) }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h3 class="page-title">{{ __('labels.edit_page', ['action' => __('labels.tour')]) }}</h3>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="row g-3" action="{{ route('admin.tours.update', $tour->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <label for="title" class="form-label required">{{ __('labels.tour_title') }}</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $tour->title) }}" placeholder="{{ __('labels.tour_title') }}">
                        @error('title')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label required">{{ __('labels.location') }}</label>
                        <input type="text" name="location" id="location"
                            class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location', $tour->location) }}" placeholder="{{ __('labels.location') }}">
                        @error('location')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="duration" class="form-label required">{{ __('labels.duration') }}</label>
                        <input type="text" name="duration" id="duration"
                            class="form-control @error('duration') is-invalid @enderror"
                            value="{{ old('duration', $tour->duration) }}" placeholder="e.g., 5 Days 4 Nights">
                        @error('duration')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="price_per_person"
                            class="form-label required">{{ __('labels.price_per_person') }}</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" min="0" name="price_per_person" id="price_per_person"
                                class="form-control @error('price_per_person') is-invalid @enderror"
                                value="{{ old('price_per_person', $tour->price_per_person) }}" placeholder="0.00">
                            @error('price_per_person')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="status_id" class="form-label required">{{ __('labels.status') }}</label>
                        <select name="status_id" id="status_id"
                            class="form-select @error('status_id') is-invalid @enderror">
                            <option value="">{{ __('labels.select') }}</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ old('status_id', $tour->status_id) == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="featured_image" class="form-label">{{ __('labels.featured_image') }}</label>
                        <input type="file" name="featured_image" id="featured_image"
                            class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                        @error('featured_image')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                        @if($tour->featured_image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . config('constants.tour_image_path') . '/' . $tour->featured_image) }}"
                                    alt="{{ $tour->title }}" class="img-thumbnail" style="max-width: 150px;">
                                <p class="text-muted small mt-1">Current image</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">{{ __('labels.description') }}</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            id="description" rows="5"
                            placeholder="{{ __('labels.description') }}">{{ old('description', $tour->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary mt-2 mt-sm-0">
                            {{ __('labels.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection