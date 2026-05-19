@extends('admin.layouts.auth')
@section('title')
    {{ __('labels.reset_password') }}
@endsection
@section('content')
    <section class="login-sec">
        <div class="container">
            <div class="row justify-content-center flex-column align-items-center">
                <div class="mb-4 col-xl-4 col-lg-6">
                    <div class="text-center d-block card-image">
                        <img src="{{ Vite::asset(config('constants.company_logo')) }}" alt="logo" class="img-fluid" />
                    </div>
                </div>
                <div class="col-xl-6 col-xxl-4 col-lg-8">
                    <div class="border-0 card login-shadow rounded-1 login-card">
                        <div class="p-0 card-body">
                            <div class="row">
                                <div class="p-5 col-sm-12">
                                    <h1 class="mt-0 mb-3 text-center fw-bold text-dark">{{ __('labels.reset_password') }}
                                    </h1>
                                    @if (session('error'))
                                        <div class="p-2 mb-3 alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('password.update') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="hidden" name="email" value="{{ $email }}">
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-floating position-relative password-toggle-group">
                                                <input id="password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       name="password"
                                                       placeholder="{{ __('Password') }}">
                                                <label for="password">{{ __('Password') }}</label>
                                                <button type="button"
                                                        class="btn btn-sm position-absolute shadow-none h-fit-content m-auto end-0 toggle-password-btn me-2 border-0 bg-primary text-white"
                                                        onclick="togglePassword('password', this)">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <div class="form-floating position-relative password-toggle-group">
                                                <input id="password-confirm" type="password"
                                                       class="form-control"
                                                       name="password_confirmation"
                                                       placeholder="{{ __('Confirm Password') }}">
                                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                                <button type="button"
                                                        class="btn btn-sm position-absolute shadow-none h-fit-content m-auto end-0 toggle-password-btn me-2 border-0 bg-primary text-white"
                                                        onclick="togglePassword('password-confirm', this)">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="pt-2 mb-0 row">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Reset Password') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
