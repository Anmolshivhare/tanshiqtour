@extends('admin.layouts.app')
@section('title') Edit Blog Post @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Edit: {{ $blog->title }}</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form class="row g-3" action="{{ route('admin.blogs.update', $blog->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-8">
                    <label class="form-label required">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $blog->slug) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Author</label>
                    <select name="author_id" class="form-select">
                        <option value="">Select Author</option>
                        @foreach($authors as $id => $name)
                            <option value="{{ $id }}" {{ old('author_id', $blog->author_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Select Category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ old('category_id', $blog->category_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('status', $blog->OriginalStatus) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
               
                <div class="col-md-6">
                    <x-image-uploader id="featured_image" name="featured_image" label="Featured Image"
                        :preview-image="$blog->featured_image ? asset('storage/blogs/' . $blog->featured_image) : null"
                        :default-image="Vite::asset(config('constants.company_logo'))" :required="false" :max-size="2"
                        :allowed-types="['jpg', 'jpeg', 'png', 'webp']" />
                </div>

                <div class="col-md-6">
                    <label class="form-label">Publish Date</label>
                    <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label required">Content</label>
                    <textarea name="body" class="form-control" rows="12">{{ old('body', $blog->body) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tags (comma-separated)</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags', is_array($blog->tags) ? implode(', ', $blog->tags) : $blog->tags) }}">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ $blog->is_featured ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Featured</label>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
