@extends('admin.layouts.app')
@section('title') Review Details @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Review by {{ $review->reviewer_name }}</h3>
        <div class="ms-auto">
            @can('review-approve')
                <a href="{{ route('admin.reviews.approve', encrypt($review->id)) }}" class="btn btn-sm btn-success">Approve</a>
            @endcan
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Reviewer</th><td>{{ $review->reviewer_name }}</td></tr>
                <tr><th>Email</th><td>{{ $review->reviewer_email ?? '—' }}</td></tr>
                <tr><th>Tour</th><td>{{ $review->tour->title ?? '—' }}</td></tr>
                <tr><th>Rating</th><td>{{ $review->rating }}/5 ⭐</td></tr>
                <tr><th>Title</th><td>{{ $review->review_title ?? '—' }}</td></tr>
                <tr><th>Status</th><td>{{ $review->status == 1 ? 'Active' : 'Inactive' }}</td></tr>
                <tr><th>Date</th><td>{{ $review->created_at }}</td></tr>
            </table>
            <div class="mt-3">
                <h5>Review</h5>
                <p>{{ $review->review_body }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
