@extends('admin.layouts.app')
@section('title') Create Blog Category @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Create Blog Category</h3>
    </div>
    <div class="card">
        <div class="card-body">
            <form class="row g-3" action="{{ route('admin.blog-categories.store') }}" method="post">
                @csrf
                <div class="col-md-6">
                    <label class="form-label required">Name</label>
                    <input type="text" name="name" class="form-control makeSlug @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control pageSlug" value="{{ old('slug') }}" placeholder="Auto-generated">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">{{ __('buttons.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
