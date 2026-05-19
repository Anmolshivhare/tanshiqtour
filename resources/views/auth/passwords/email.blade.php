@extends('admin.layouts.auth')
@section('title')
    {{ __('labels.login') }}
@endsection
@section('content')
    <section class="login-sec">
        <div class="container">
            <div class="row justify-content-center flex-column align-items-center">
                <div class="mb-4 col-xl-4 col-lg-6">
                    <div class="text-center d-block card-image">
                        @if (!empty($settingData->admin_panel_logo_img))
                            <img src="{{ asset('storage/setting_images/' . $settingData->admin_panel_logo_img) }}" alt="logo"
                                class="img-fluid" />
                        @else
                            <img src="{{ Vite::asset(config('constants.company_logo')) }}" alt="logo" class="img-fluid" />
                        @endif
                    </div>
                </div>
                <div class="col-xl-6 col-xxl-4 col-lg-8">
                    <div class="border-0 card login-shadow rounded-1 login-card">
                        <div class="p-0 card-body">
                            <div class="row">
                                <div class="p-5 col-sm-12">
                                    <h1 class="my-2 text-center fw-bold text-dark">{{ __('labels.forgot_password') }}
                                        </h3>

                                        @if (session('status'))
                                            <div class="mt-3 mb-0 alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session('status') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        <form action="{{ route('password.email') }}" class="p-0 pt-2 mt-4" method="post">
                                            @csrf
                                            <div class="mb-4 form-group">
                                                <label for="email"
                                                    class="form-label required">{{ __('labels.email') }}</label>
                                                <input type="email" name="email" id="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email') }}" placeholder="{{ __('labels.email') }}">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-6 d-grid">
                                                    <button type="submit" class="btn btn-primary btn-lg">
                                                        {{ __('buttons.send') }}
                                                    </button>
                                                </div>
                                                <div class="col-6 d-grid">
                                                    <a href="{{ route('admin.login') }}"
                                                        class="btn btn-outline-secondary btn-lg">
                                                        {{ __('Back to Login') }}
                                                    </a>
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