@extends('admin.layouts.app')
@section('title') Add Gallery Item @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Add Gallery Item</h3>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form class="row g-3" action="{{ route('admin.galleries.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label class="form-label required">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label required">Type</label>
                    <select name="type" id="gallery_type" class="form-select">
                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="col-md-6">
                    <div id="image_file_wrap">
                        <label class="form-label required">File (Image)</label>
                        <input type="file" id="gallery_image_file_path" name="file_path"
                            class="form-control @error('file_path') is-invalid @enderror" accept="image/*">
                        @error('file_path') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <x-video-uploader id="gallery_video_file_path" name="file_path" label="File (Video)"
                        :required="true" :max-size="20"
                        :allowed-types="['mp4', 'mov']" />
                </div>
                <div class="col-md-6">
                    <div id="thumbnail_wrap">
                        <x-image-uploader id="gallery_thumbnail_path" name="thumbnail_path" label="Thumbnail (for videos)"
                            :default-image="Vite::asset(config('constants.company_logo'))" :required="false" :max-size="2"
                            :enable-crop="false" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Destination (optional)</label>
                    <select name="destination_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($destinations as $id => $name)
                            <option value="{{ $id }}" {{ old('destination_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tour (optional)</label>
                    <select name="tour_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($tours as $id => $name)
                            <option value="{{ $id }}" {{ old('tour_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Featured</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add to Gallery</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
