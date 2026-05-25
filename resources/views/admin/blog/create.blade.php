@extends('admin.layouts.app')
@section('title') Create Blog Post @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Create Blog Post</h3>
    </div>
    <div class="card">
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form class="row g-3" action="{{ route('admin.blogs.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-8">
                    <label class="form-label required">Title</label>
                    <input type="text" name="title" class="form-control makeSlug @error('title') is-invalid @enderror" value="{{ old('title') }}">
                    @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control pageSlug" value="{{ old('slug') }}" placeholder="Auto-generated">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Author</label>
                    <select name="author_id" class="form-select">
                        <option value="">Select Author</option>
                        @foreach($authors as $id => $name)
                            <option value="{{ $id }}" {{ old('author_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select Category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Publish Date</label>
                    <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at') }}">
                </div>

                <div class="col-lg-6 col-md-6">
                 <x-image-uploader id="featured_image" name="featured_image" label="Featured Image" :default-image="Vite::asset(config('constants.company_logo'))"
                            :required="false" :max-size="2" :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                </div>
               
                <div class="col-md-12">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt') }}</textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label required">Content</label>
                    <textarea name="body" id="blog-body" class="form-control @error('body') is-invalid @enderror" rows="12">{{ old('body') }}</textarea>
                    @error('body') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="travel, adventure, india">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Mark as Featured</label>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
