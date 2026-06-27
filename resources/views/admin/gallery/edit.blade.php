@extends('admin.layouts.app')
@section('title') Edit Gallery Item @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Edit: {{ $gallery->title }}</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form class="row g-3" action="{{ route('admin.galleries.update', $gallery->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label class="form-label required">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}">
                </div>
                <div class="col-md-6">
                    <div class="form-check mt-4">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ $gallery->is_featured ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Featured</label>
                    </div>
                </div>
                <div class="col-md-12">
                    @if($gallery->images->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Current Gallery Images</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($gallery->images as $image)
                                    <label class="d-inline-block text-center">
                                        <img src="{{ asset('storage/gallery/' . $image->file_path) }}"
                                            alt="Gallery image" class="rounded border d-block mb-1"
                                            style="width:72px;height:72px;object-fit:cover;">
                                        <input type="checkbox" name="remove_gallery_image_ids[]"
                                            value="{{ $image->id }}"
                                            {{ in_array((string) $image->id, old('remove_gallery_image_ids', [])) ? 'checked' : '' }}>
                                        <small class="d-block text-danger">Remove</small>
                                    </label>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mt-1">Select Remove on specific images to delete them.</small>
                        </div>
                    @endif
                    <x-multi-image-upload id="gallery_images" name="gallery_images[]"
                        label="Gallery Images (Add More) Size (771 x 514 px)"
                        :max-size="2" :max-files="20" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                </div>
                <div class="col-md-6">
                    <x-video-uploader id="gallery_video_file_path" name="video_file" label="Gallery Video (Single)"
                        :preview-video="!empty($gallery->file_path) ? asset('storage/gallery/' . $gallery->file_path) : null"
                        :required="false" :max-size="20" :allowed-types="['mp4', 'mov']" />
                </div>
                <div class="col-md-6">
                    <div class="mt-3">
                        <x-image-uploader id="gallery_thumbnail_path" name="thumbnail_path" label="Video Thumbnail"
                            :preview-image="!empty($gallery->thumbnail_path) ? asset('storage/gallery/thumbnails/' . $gallery->thumbnail_path) : null"
                            :default-image="Vite::asset(config('constants.company_logo'))" :required="false"
                            :max-size="2" :enable-crop="false" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <label class="form-label">Destination (optional)</label>
                    <select name="destination_id" class="form-select">
                        <option value="">None</option>
                        @foreach($destinations as $destinationId => $destinationName)
                            <option value="{{ $destinationId }}" {{ old('destination_id', $gallery->destination_id) == $destinationId ? 'selected' : '' }}>{{ $destinationName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tour (optional)</label>
                    <select name="tour_id" class="form-select">
                        <option value="">None</option>
                        @foreach($tours as $tourId => $tourName)
                            <option value="{{ $tourId }}" {{ old('tour_id', $gallery->tour_id) == $tourId ? 'selected' : '' }}>{{ $tourName }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('status', $gallery->OriginalStatus) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
