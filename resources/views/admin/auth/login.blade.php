@extends('admin.layouts.auth')
@section('title')
    Login
@endsection

@section('content')
    <section class="login-sec admin-login-page">
        <div class="container">
            <div class="row justify-content-center flex-column align-items-center login-shell">
                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="text-center d-block card-image login-logo-wrap">
                        <img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('sidebar_logo_img', config('constants.company_logo')) }}" alt="logo" class="img-fluid login-logo" />

                    </div>
                </div>

                <div class="col-xl-5 col-lg-6 col-md-8">
                    <div class="shadow-sm card rounded-3 border-0 login-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="text-center fw-bold text-dark login-title">{{ __('labels.login') }}</h1>
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @elseif (session('message') || session('status'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('message') }} {{ session('status') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('admin.post-login') }}" class="row g-3 login-form">
                                        @csrf
                                        <div class="col-md-12">
                                            <label for="email" class="form-label required">{{ __('labels.email') }}</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="{{ __('labels.email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="password"
                                                class="form-label required">{{ __('labels.password') }}</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="{{ __('labels.password') }}">
                                                <button type="button" class="btn btn-outline-secondary login-pass-btn border border-primary-subtle"
                                                    onclick="togglePassword('password', this)">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                            @if (Route::has('password.request'))
                                                <label for="password" class="form-label d-block font-lg mt-2">
                                                    <a href="{{ route('password.request') }}"
                                                        class="hover-primary">{{ __('labels.forgot_password') }}</a>
                                                </label>
                                            @endif
                                        </div>

                                        <div class="mb-3 d-none form-check">
                                            <input type="checkbox" class="form-check-input" id="rememberCheckbox"
                                                name="remember_me" {{ old('remember_me') ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="rememberCheckbox">{{ __('labels.remember_me') }}</label>
                                        </div>

                                        <div class="gap-2 mt-1 d-grid">
                                            <button type="submit" class="btn btn-primary">{{ __('labels.login') }}</button>
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

@section('scripts')
    @parent
    <script type="module">
        window.togglePassword = function (inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            }
        }
    </script>
@endsection
