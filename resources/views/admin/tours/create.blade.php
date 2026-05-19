@extends('admin.layouts.app')
@section('title') Create Tour @endsection
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
                <div class="col-md-6">
                    <label class="form-label required">Tour Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" placeholder="e.g. 5D/4N">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Max Persons</label>
                    <input type="number" name="max_persons" class="form-control" value="{{ old('max_persons') }}" min="1">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price Per Person (₹)</label>
                    <input type="number" name="price_per_person" class="form-control" value="{{ old('price_per_person') }}" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Destination</label>
                    <select name="destination_id" class="form-select">
                        <option value="">Select Destination</option>
                        @foreach($destinations as $id => $name)
                            <option value="{{ $id }}" {{ old('destination_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Select Status</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('status') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Featured Image</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gallery Images (Multiple)</label>
                    <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                </div>

                {{-- Itinerary --}}
                <h5 class="col-12 border-bottom pb-2 mt-3">Itinerary Days</h5>
                <div class="col-12" id="itinerary-container">
                    <div class="itinerary-day card mb-3 p-3" data-day="1">
                        <h6>Day 1</h6>
                        <input type="hidden" name="itinerary[0][day_number]" value="1">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="itinerary[0][title]" class="form-control" placeholder="Day title">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="itinerary[0][accommodation]" class="form-control" placeholder="Accommodation">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="itinerary[0][meals_included]" class="form-control" placeholder="Meals (B/L/D)">
                            </div>
                            <div class="col-12">
                                <textarea name="itinerary[0][description]" class="form-control" rows="2" placeholder="Day description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="add-day-btn">+ Add Day</button>
                </div>

                <div class="col-12 mt-3">
                    <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Tour</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let dayCount = 1;
    document.getElementById('add-day-btn').addEventListener('click', function () {
        dayCount++;
        const idx = dayCount - 1;
        const container = document.getElementById('itinerary-container');
        container.insertAdjacentHTML('beforeend', `
            <div class="itinerary-day card mb-3 p-3">
                <h6>Day ${dayCount}</h6>
                <input type="hidden" name="itinerary[${idx}][day_number]" value="${dayCount}">
                <div class="row g-2">
                    <div class="col-md-6"><input type="text" name="itinerary[${idx}][title]" class="form-control" placeholder="Day title"></div>
                    <div class="col-md-6"><input type="text" name="itinerary[${idx}][accommodation]" class="form-control" placeholder="Accommodation"></div>
                    <div class="col-md-6"><input type="text" name="itinerary[${idx}][meals_included]" class="form-control" placeholder="Meals (B/L/D)"></div>
                    <div class="col-12"><textarea name="itinerary[${idx}][description]" class="form-control" rows="2" placeholder="Day description"></textarea></div>
                </div>
            </div>`);
    });
</script>
@endpush