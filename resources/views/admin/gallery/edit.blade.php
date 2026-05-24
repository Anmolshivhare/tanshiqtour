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
                <div class="col-md-3">
                    <label class="form-label required">Type</label>
                    <select name="type" class="form-select">
                        <option value="image" {{ old('type', $gallery->type) == 'image' ? 'selected' : '' }}>Image</option>
                        <option value="video" {{ old('type', $gallery->type) == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $gallery->sort_order) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Replace File</label>
                    @if($gallery->file_path)
                        <div class="mb-1 text-muted small">Current: {{ $gallery->file_path }}</div>
                    @endif
                    <input type="file" name="file_path" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('status', $gallery->OriginalStatus) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ $gallery->is_featured ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Featured</label>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
