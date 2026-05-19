@extends('admin.layouts.app')
@section('title')
    {{ __('Change Password') }}
@endsection
@section('content')
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">{{ __('Change Password') }}</h3>
    </div>
    <div class="col-md-12 divide-y-1">
        <div class="row">
            <div class="col-xxl-7 col-md-10 col-sm-12">
                <div class="card border-rounded">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.update-password') }}" class="row g-3">
                            @if (session('error'))
                                <div class="p-2 mb-3 alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @csrf

                            {{-- Old Password --}}
                            <div class="col-12 col-md-12">
                                <div class="form-floating position-relative password-toggle-group">
                                    <input class="form-control @error('old_password') is-invalid @enderror"
                                           name="old_password"
                                           type="password"
                                           id="old_password"
                                           placeholder="{{ __('labels.old_password') }}" />
                                    <label class="form-label text-dark" for="old_password">{{ __('labels.old_password') }}</label>
                                    <button type="button"
                                            class="btn btn-sm position-absolute shadow-none h-fit-content m-auto end-0 toggle-password-btn me-2 border-0 bg-primary text-white"
                                            onclick="togglePassword('old_password', this)">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    @error('old_password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- New Password --}}
                            <div class="col-12 col-md-12">
                                <div class="form-floating position-relative password-toggle-group">
                                    <input class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           type="password"
                                           id="password"
                                           placeholder="{{ __('labels.new_password') }}" />
                                    <label class="form-label text-dark" for="password">{{ __('labels.new_password') }}</label>
                                    <button type="button"
                                            class="btn btn-sm position-absolute shadow-none h-fit-content m-auto end-0 toggle-password-btn me-2 border-0 bg-primary text-white"
                                            onclick="togglePassword('old_password', this)">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-12 col-md-12">
                                <div class="form-floating position-relative password-toggle-group">
                                    <input class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" type="password" id="confirm_password"   placeholder="{{ __('labels.confirm_password') }}" />
                                    <label class="form-label text-dark" for="confirm_password">{{ __('labels.confirm_password') }}</label>
                                    <button type="button"
                                            class="btn btn-sm position-absolute shadow-none h-fit-content m-auto end-0 toggle-password-btn me-2 border-0 bg-primary text-white"
                                            onclick="togglePassword('old_password', this)">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Hidden Remember Me --}}
                            <div class="mb-3 text-center form-check d-none">
                                <input type="checkbox" class="float-none form-check-input" id="rememberCheckbox" name="remember_me" {{ old('remember_me') ? 'checked' : '' }} />
                                <label class="form-check-label" for="rememberCheckbox">
                                    {{ __('labels.remember_me') }}
                                </label>
                            </div>

                            {{-- Submit Button --}}
                            <div class="mt-4 mb-0 d-flex align-items-center justify-content-between">
                                <button class="px-0 btn btn-primary d-block w-25 ms-auto" type="submit">
                                    {{ __('buttons.submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


