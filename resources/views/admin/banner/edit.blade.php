@extends('admin.layouts.app')
@section('title') Edit Banner @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Edit Banner</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form class="row g-3" action="{{ route('admin.banners.update', $banner->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label class="form-label required">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}">
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $banner->subtitle) }}">
                    @error('subtitle') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $banner->sort_order) }}" min="0">
                    @error('sort_order') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $banner->button_text) }}">
                    @error('button_text') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Button URL</label>
                    <input type="url" name="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url', $banner->button_url) }}" placeholder="https://">
                    @error('button_url') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                 <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status', $banner->OriginalStatus) == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $banner->description) }}</textarea>
                    @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
               
                <div class="col-md-6">
                    <label class="form-label">Banner Image Size:(1700 * 800px)</label>
                    <x-image-uploader id="banner_image" name="image" label="Image"
                        :preview-image="!empty($banner->image) ? asset('storage/' . config('constants.banner_image_path') . '/' . $banner->image) : null"
                        :default-image="Vite::asset(config('constants.company_logo'))" :required="false" :max-size="4"
                        :enable-crop="false" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">{{ __('buttons.cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
