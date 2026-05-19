@extends('admin.layouts.app')
@section('title')
    {{ __('labels.dashboard') }}
@endsection
@section('content')
    <div class="gap-2 pb-2 mb-4 d-flex flex-column align-items-center justify-content-between">
        <div class="w-100 d-flex justify-content-start align-items-baseline">
            <h3 class="page-title">{{ __('labels.dashboard') }}</h3>
            @if (session('message'))
                <div class="mx-4 mb-0 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

        </div>

    </div>
    <div class="col-md-12 divide-y-1 -main-col">
        <div class="row">
            <div class="px-4 col-md-4">
                <div class="card h-100 w-100">
                    <a href="#">
                        <div class="px-3 card-body px-xxl-5">
                            <div class="gap-3 d-block align-items-center d-flex">
                                @php
                                    $user = auth()->user();
                                @endphp
                                @if (!empty($user->profile_pic))
                                    <img src="{{ asset('storage/profile_images/' . $user->profile_pic) }}" alt="auth-profile"
                                        class="bg-white border border-white img-fluid auth-img rounded-circle transition-x">
                                @else
                                    <img src="{{ Vite::asset(config('constants.company_logo')) }}" alt="auth-profile"
                                        class="bg-white border border-white img-fluid auth-img rounded-circle transition-x">
                                @endif
                                <div class="auth-card-detail">
                                    <h3 class="welcome-head fw-mediumary">{{ __('labels.welcome') }},
                                        {{ $user->name ? $user->name : '' }}
                                    </h3>
                                    <a class="m-0 auth-text fw-medium" href="{{ route('admin.logout') }}">Logout</a>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
@endsection