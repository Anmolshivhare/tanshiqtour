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
                 <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Featured</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <x-multi-image-upload id="gallery_images" name="gallery_images[]"
                        label="Gallery Images (Multiple) Size (771 x 514 px)"
                        :max-size="2" :max-files="20" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                </div>
                <div class="col-md-6">
                    <x-video-uploader id="gallery_video_file_path" name="video_file" label="Gallery Video"
                        :required="false" :max-size="20" :allowed-types="['mp4', 'mov']" />
                    
                </div>
                <div class="col-md-6">
                   <div class="mt-3">
                        <x-image-uploader id="gallery_thumbnail_path" name="thumbnail_path" label="Video Thumbnail"
                            :default-image="Vite::asset(config('constants.company_logo'))" :required="false"
                            :max-size="2" :enable-crop="false" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                    </div>
                    
                </div>
{{-- 
                <div class="col-md-6">
                    <label class="form-label">Destination (optional)</label>
                    <select name="destination_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($destinations as $id => $name)
                            <option value="{{ $id }}" {{ old('destination_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Tour (optional)</label>
                    <select name="tour_id" class="form-select">
                        <option value="">— None —</option>
                        @foreach($tours as $id => $name)
                            <option value="{{ $id }}" {{ old('tour_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div> --}}
               
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
