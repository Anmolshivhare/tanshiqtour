@extends('admin.layouts.app')
@section('title') Edit Blog Category @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Edit: {{ $blogCategory->name }}</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form class="row g-3" action="{{ route('admin.blog-categories.update', $blogCategory->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label class="form-label required">Name</label>
                    <input type="text" name="name" class="form-control makeSlug" value="{{ old('name', $blogCategory->name) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control pageSlug" value="{{ old('slug', $blogCategory->slug) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ old('status', $blogCategory->OriginalStatus) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $blogCategory->description) }}</textarea>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
