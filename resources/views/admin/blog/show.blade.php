@extends('admin.layouts.app')
@section('title') Blog Post Details @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">{{ $blog->title }}</h3>
        <div class="ms-auto">
            @can('blog-edit')
                <a href="{{ route('admin.blogs.edit', encrypt($blog->id)) }}" class="btn btn-sm btn-warning">Edit</a>
            @endcan
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr><th>Author</th><td>{{ $blog->author->name ?? '—' }}</td></tr>
                        <tr><th>Category</th><td>{{ $blog->category->name ?? '—' }}</td></tr>
                        <tr><th>Status</th><td>{{ $blog->statusName->name ?? '—' }}</td></tr>
                        <tr><th>Featured</th><td>{{ $blog->is_featured ? 'Yes' : 'No' }}</td></tr>
                        <tr><th>Published At</th><td>{{ $blog->published_at ?? '—' }}</td></tr>
                        <tr><th>Created At</th><td>{{ $blog->created_at }}</td></tr>
                    </table>
                    @if($blog->excerpt)
                        <h5 class="mt-3">Excerpt</h5>
                        <p class="text-muted">{{ $blog->excerpt }}</p>
                    @endif
                    <h5 class="mt-3">Content</h5>
                    <div>{!! nl2br(e($blog->body)) !!}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if($blog->featured_image)
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/blogs/' . $blog->featured_image) }}" class="img-fluid rounded">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
