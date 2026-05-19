@extends('admin.layouts.app')
@section('title') Enquiry Details @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Enquiry from {{ $enquiry->name }}</h3>
        <div class="ms-auto">
            @can('enquiry-reply')
                <a href="{{ route('admin.enquiries.reply', encrypt($enquiry->id)) }}" class="btn btn-sm btn-success">Mark as Replied</a>
            @endcan
            <a href="{{ route('admin.enquiries.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th style="width:200px">Name</th><td>{{ $enquiry->name }}</td></tr>
                <tr><th>Email</th><td><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td></tr>
                <tr><th>Phone</th><td>{{ $enquiry->phone ?? '—' }}</td></tr>
                <tr><th>Subject</th><td>{{ $enquiry->subject ?? '—' }}</td></tr>
                <tr><th>Tour</th><td>{{ $enquiry->tour->title ?? 'General' }}</td></tr>
                <tr><th>Status</th><td>{!! $enquiry->statusBadge() !!}</td></tr>
                @if($enquiry->replied_at)
                    <tr><th>Replied At</th><td>{{ $enquiry->replied_at }}</td></tr>
                    <tr><th>Replied By</th><td>{{ $enquiry->repliedBy->name ?? '—' }}</td></tr>
                @endif
                <tr><th>Received At</th><td>{{ $enquiry->created_at }}</td></tr>
            </table>
            <div class="mt-4">
                <h5>Message</h5>
                <div class="p-3 bg-light rounded">{{ $enquiry->message }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
