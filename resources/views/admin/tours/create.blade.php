@extends('admin.layouts.app')
@section('title')
    Create Tour
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h3 class="page-title">Create Tour Package</h3>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form class="row g-3" action="{{ route('admin.tours.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Basic Info --}}
                    <h5 class="col-12 border-bottom pb-2">Basic Information</h5>
                    <div class="col-md-5">
                        <label class="form-label required">Tour Title</label>
                        <input type="text" name="title"
                            class="form-control makeSlug @error('title') is-invalid @enderror" value="{{ old('title') }}">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control pageSlug" value="{{ old('slug') }}"
                            placeholder="Auto-generated if empty" readonly>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input"
                                value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" class="form-check-label">Mark as Featured</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Duration</label>
                        <input type="text" name="duration" class="form-control" value="{{ old('duration') }}"
                            placeholder="e.g. 5D/4N">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Max Persons</label>
                        <input type="number" name="max_persons" class="form-control" value="{{ old('max_persons') }}"
                            min="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price Per Person (₹)</label>
                        <input type="number" name="price_per_person" class="form-control"
                            value="{{ old('price_per_person') }}" step="0.01">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Destination</label>
                        <select name="destination_id" class="form-select">
                            <option value="">Select Destination</option>
                            @foreach ($destinations as $id => $name)
                                <option value="{{ $id }}" {{ old('destination_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <x-image-uploader id="featured_image" name="featured_image" label="Featured Image" :default-image="Vite::asset(config('constants.company_logo'))"
                            :required="false" :max-size="2" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                    </div>
                    <div class="col-md-6">
                        <x-multi-image-upload id="gallery_images" name="gallery_images[]" label="Gallery Images (Multiple)"
                            :max-size="2" :max-files="10" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                    </div>

                    {{-- Itinerary --}}
                    <h5 class="col-12 border-bottom pb-2 mt-3">Itinerary Days</h5>
                    @php
                        $itineraryRows = old('itinerary');
                        if (!is_array($itineraryRows) || empty($itineraryRows)) {
                            $itineraryRows = [[]];
                        }
                    @endphp
                    <div class="col-12" id="itinerary-container">
                        @foreach ($itineraryRows as $i => $day)
                            <div class="itinerary-day card mb-3 p-3" data-day="{{ $i + 1 }}">
                                <h6>Day {{ $i + 1 }}</h6>
                                <input type="hidden" name="itinerary[{{ $i }}][day_number]"
                                    value="{{ $i + 1 }}">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" name="itinerary[{{ $i }}][title]"
                                            class="form-control" value="{{ $day['title'] ?? '' }}" placeholder="Day title">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="itinerary[{{ $i }}][accommodation]"
                                            class="form-control" value="{{ $day['accommodation'] ?? '' }}"
                                            placeholder="Accommodation">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="itinerary[{{ $i }}][meals_included]"
                                            class="form-control" value="{{ $day['meals_included'] ?? '' }}"
                                            placeholder="Meals (B/L/D)">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="itinerary[{{ $i }}][description]" class="form-control" rows="2"
                                            placeholder="Day description">{{ $day['description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-day-btn">+ Add
                            Day</button>
                    </div>

                    <div class="col-12 mt-3">
                        <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ __('buttons.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
