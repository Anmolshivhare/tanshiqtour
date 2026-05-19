@extends('admin.layouts.app')
@section('title')
    {{ __('labels.edit_user') }}
@endsection
@section('content')
    <div class="profile-page">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h3 class="page-title">{{ __('labels.user_profile') }}</h3>

            @if (session('message'))
                <div class="mx-4 mt-3 mb-0 alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="gap-3 row gap-xl-0">
            <div class="col-xxl-5">
                <div class="rounded shadow card h-100">
                    <div class="profile-bg">
                        <img src="{{ Vite::asset('resources/images/logo.jpg') }}" alt="bg-img"
                            class="mb-n4 w-100 border-bottom border-3 border-primary img-fluid ">
                        @if ($user->profile_pic)
                            <a href="{{ asset('storage/profile_images/' . $user->profile_pic) }}" target="_blank">
                                <img src="{{ asset('storage/profile_images/' . $user->profile_pic) }}"
                                    class="m-auto bg-white border d-block mt-n5 border-3 rounded-circle border-primary profile-img"
                                    alt="profile">
                            </a>
                        @else
                            <img src="{{ Vite::asset(config('constants.company_logo')) }}" alt="user"
                                class="m-auto bg-white border d-block mt-n5 border-3 rounded-circle border-primary profile-img">
                        @endif


                    </div>
                    <div class="pb-3 mx-3 mt-5 mb-3 user-details border-bottom border-1">
                        <h4 class="mt-4 mb-0 text-center text-primary fw-semibold">{{ $user->name }}</h4>
                        <p class="m-0 text-center"><a href="mailto:{{ $user->email }}"
                                class="text-profile-text-color">{{ $user->email }}</a></p>
                    </div>
                    <div class="p-3 personal-info">
                        <h5 class="mb-4 fw-semibold">{{ __('labels.user_personal_info') }}</h5>
                        <div class="mb-3 info-div d-flex justify-content-start">
                            <label for="full_name" class="w-50 fw-semibold">{{ __('labels.full_name') }}</label>
                            <div class="info w-50">:{{ $user->name }}</div>
                        </div>
                        <div class="mb-3 info-div d-flex justify-content-start">
                            <label for="user-email" class="w-50 fw-semibold">{{ __('labels.email') }}</label>
                            <div class="info w-50">:{{ $user->email }}</div>
                        </div>
                        <div class="mb-3 info-div d-flex justify-content-start">
                            <label for="phone-number" class="w-50 fw-semibold">{{ __('labels.phone_number') }}</label>
                            <div class="info w-50">:{{ $user->phone_no }}</div>
                        </div>

                        <div class="mb-3 info-div d-flex justify-content-start">
                            <label for="role" class="w-50 fw-semibold">{{ __('labels.role') }}</label>
                            <div class="info w-50">:{{ $user->roles[0]->name }}</div>
                        </div>
                        <div class="mb-3 info-div d-flex justify-content-start">
                            <label for="address" class="w-50 fw-semibold">{{ __('labels.address') }}</label>
                            <div class="info w-50">:{{ $user->address }}.</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-7">
                <div class="p-3 rounded card h-100">
                    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
                        <h3 class="page-title">{{ __('labels.edit_info') }}</h3>
                    </div>
                    <form method="POST" action="{{ route('admin.update.user-profile', $user->id) }}" class="py-1 row g-3"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-8">
                            <label for="file-upload" class="pointer">
                                @if (!empty($user->profile_pic))
                                    <img src="{{ asset('storage/profile_images/' . $user->profile_pic) }}"
                                        class="border border-primary border-3 rounded-circle upload-img" alt="profile">
                                @else
                                    <img src="{{ Vite::asset(config('constants.company_logo')) }}" alt="user" class="img-fluid">
                                @endif
                            </label>
                            <input type="file" name="profile_pic" id="file-upload" class="d-none">
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">{{ __('labels.full_name') }}</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ !empty($user->name) ? $user->name : old('name') }}"
                                placeholder="{{ __('labels.full_name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">{{ __('labels.email') }}</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ !empty($user->email) ? $user->email : old('email') }}"
                                placeholder="{{ __('labels.email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone_no" class="form-label">{{ __('labels.phone_number') }}</label>
                            <input type="text" name="phone_no" id="phone_no"
                                class="form-control @error('phone_no') is-invalid @enderror"
                                value="{{ !empty($user->phone_no) ? $user->phone_no : old('phone_no') }}"
                                placeholder="{{ __('labels.phone_number') }}">
                            @error('phone_no')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="role" class="form-label">{{ __('labels.role') }}</label>
                            <input type="text" name="role" id="role" class="form-control"
                                value="{{ !empty($user->roles) ? $user->roles[0]->name : old('role') }}"
                                placeholder="{{ __('labels.role') }}" disabled>
                        </div>

                        <div class="col-md-12">
                            <label for="address" class="form-label">{{ __('labels.address') }}</label>
                            <textarea name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror" rows="5"
                                cols="10">{{ !empty($user->address) ? $user->address : old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit"
                                class="btn btn-primary d-block w-100 w-md-25 ms-auto">{{ __('buttons.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
