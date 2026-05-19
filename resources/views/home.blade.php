@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-primary mb-3">Welcome</h1>
    <p class="mb-4">Laravel 13 admin + user/role/permission management setup is ready.</p>
    <a href="{{ route('front.tours') }}" class="btn btn-primary">View Tours</a>
</div>
@endsection
