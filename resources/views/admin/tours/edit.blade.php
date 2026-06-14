@extends('admin.layouts.app')
@section('title')
    Edit Tour
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h3 class="page-title">Edit Tour: {{ $tour->title }}</h3>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <form class="row g-3" action="{{ route('admin.tours.update', $tour->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h5 class="col-12 border-bottom pb-2">Basic Information</h5>
                    <div class="col-md-5">
                        <label class="form-label required">Tour Title</label>
                        <input type="text" name="title"
                            class="form-control makeSlug @error('title') is-invalid @enderror"
                            value="{{ old('title', $tour->title) }}">
                        @error('title')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control pageSlug"
                            value="{{ old('slug', $tour->slug) }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input"
                                value="1" {{ old('is_featured', $tour->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured" class="form-check-label">Mark as Featured</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control"
                            value="{{ old('location', $tour->location) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Duration</label>
                        <input type="text" name="duration" class="form-control"
                            value="{{ old('duration', $tour->duration) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Max Persons</label>
                        <input type="number" name="max_persons" class="form-control"
                            value="{{ old('max_persons', $tour->max_persons) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price Per Person (₹)</label>
                        <input type="number" name="price_per_person" class="form-control"
                            value="{{ old('price_per_person', $tour->price_per_person) }}" step="0.01">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Destination</label>
                        <select name="destination_id" class="form-select">
                            <option value="">Select Destination</option>
                            @foreach ($destinations as $id => $name)
                                <option value="{{ $id }}"
                                    {{ old('destination_id', $tour->destination_id) == $id ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Select Status</option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s->id }}"
                                    {{ old('status', $tour->OriginalStatus) == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                   

                    <div class="col-md-6">
                        <x-image-uploader id="featured_image" name="featured_image" label="Featured Image" :preview-image="$tour->featured_image ? asset('storage/tours/' . $tour->featured_image) : null"
                            :default-image="Vite::asset(config('constants.company_logo'))" :required="false" :max-size="2" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                    </div>

                    <div class="col-md-6">
                        @if ($tour->images && $tour->images->count())
                            <div class="mb-2">
                                <label class="form-label">Current Gallery</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($tour->images as $image)
                                        <label class="d-inline-block text-center">
                                            <img src="{{ asset('storage/tours/gallery/' . $image->image_path) }}"
                                                alt="Gallery image" class="rounded border d-block mb-1"
                                                style="width:72px;height:72px;object-fit:cover;">
                                            <input type="checkbox" name="remove_gallery_image_ids[]"
                                                value="{{ $image->id }}"
                                                {{ in_array((string) $image->id, old('remove_gallery_image_ids', [])) ? 'checked' : '' }}>
                                            <small class="d-block text-danger">Remove</small>
                                        </label>
                                    @endforeach
                                </div>
                                <small class="text-muted d-block mt-1">Select Remove on specific images to delete
                                    them.</small>
                            </div>
                        @endif
                        <x-multi-image-upload id="gallery_images" name="gallery_images[]" label="Gallery Images (Add More)"
                            :max-size="2" :max-files="10" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="6">{{ old('description', $tour->description) }}</textarea>
                    </div>

                    <h5 class="col-12 border-bottom pb-2 mt-3">Highlight List</h5>
                    @php
                        $highlightRows = old('highlights');
                        if (!is_array($highlightRows)) {
                            $highlightRows = $tour->highlights ?? [];
                        }
                        if (empty($highlightRows)) {
                            $highlightRows = [''];
                        }
                    @endphp
                    <div class="col-12" id="highlights-container">
                        @foreach ($highlightRows as $highlight)
                            <div class="tour-highlight-row input-group mb-2">
                                <span class="input-group-text"><i class="fas fa-check text-success"></i></span>
                                <input type="text" name="highlights[]" class="form-control"
                                    value="{{ $highlight }}" placeholder="Highlight text">
                                <button type="button" class="btn btn-outline-danger remove-highlight-btn">Remove</button>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-highlight-btn">+ Add Highlight</button>
                    </div>

                    <h5 class="col-12 border-bottom pb-2 mt-3">Tour Amenities</h5>
                    @php
                        $amenityRows = old('amenities');
                        if (!is_array($amenityRows)) {
                            $amenityRows = $tour->amenities ?? [];
                        }
                        if (empty($amenityRows)) {
                            $amenityRows = [['label' => '', 'available' => 1]];
                        }
                    @endphp
                    <div class="col-12" id="amenities-container">
                        @foreach ($amenityRows as $i => $amenity)
                            <div class="tour-amenity-row row g-2 align-items-center mb-2">
                                <div class="col-md-8">
                                    <input type="text" name="amenities[{{ $i }}][label]" class="form-control"
                                        value="{{ $amenity['label'] ?? '' }}" placeholder="Amenity label">
                                </div>
                                <div class="col-md-2">
                                    <input type="hidden" name="amenities[{{ $i }}][available]" value="0">
                                    <div class="form-check">
                                        <input type="checkbox" name="amenities[{{ $i }}][available]" value="1"
                                            class="form-check-input" id="amenity-available-{{ $i }}"
                                            {{ !empty($amenity['available']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity-available-{{ $i }}">Available</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger w-100 remove-amenity-btn">Remove</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-amenity-btn">+ Add Amenity</button>
                    </div>

                    <h5 class="col-12 border-bottom pb-2 mt-3">Itinerary Days</h5>
                    @php
                        $oldItineraryRows = old('itinerary');
                        if (is_array($oldItineraryRows) && !empty($oldItineraryRows)) {
                            $itineraryRows = array_values($oldItineraryRows);
                        } else {
                            $itineraryRows = $tour->itineraryDays
                                ->map(function ($day) {
                                    return [
                                        'title' => $day->title,
                                        'accommodation' => $day->accommodation,
                                        'meals_included' => $day->meals_included,
                                        'description' => $day->description,
                                    ];
                                })
                                ->toArray();
                        }
                        if (empty($itineraryRows)) {
                            $itineraryRows = [[]];
                        }
                    @endphp
                    <div class="col-12" id="itinerary-container">
                        @foreach ($itineraryRows as $i => $day)
                            <div class="itinerary-day card mb-3 p-3">
                                <h6>Day {{ $i + 1 }}</h6>
                                <input type="hidden" name="itinerary[{{ $i }}][day_number]"
                                    value="{{ $i + 1 }}">
                                <div class="row g-2">
                                    <div class="col-md-6"><input type="text"
                                            name="itinerary[{{ $i }}][title]" class="form-control"
                                            value="{{ $day['title'] ?? '' }}" placeholder="Day title"></div>
                                    <div class="col-md-6"><input type="text"
                                            name="itinerary[{{ $i }}][accommodation]" class="form-control"
                                            value="{{ $day['accommodation'] ?? '' }}" placeholder="Accommodation"></div>
                                    <div class="col-md-6"><input type="text"
                                            name="itinerary[{{ $i }}][meals_included]" class="form-control"
                                            value="{{ $day['meals_included'] ?? '' }}" placeholder="Meals (B/L/D)"></div>
                                    <div class="col-12">
                                        <textarea name="itinerary[{{ $i }}][description]" class="form-control" rows="2">{{ $day['description'] ?? '' }}</textarea>
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
                        <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
