@extends('front.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <a href="{{ route('home') }}">
                                <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="Logo" width="120"
                                    class="mb-3">
                            </a>
                            <h2 class="fw-bold text-primary">Create Account</h2>
                            <p class="text-muted">Join us and start booking your adventures</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('front.post-register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa-solid fa-user text-muted"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name"
                                        required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa-solid fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                                        required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa-solid fa-phone text-muted"></i>
                                    </span>
                                    <input type="tel"
                                        class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="Enter 10-digit phone number" maxlength="10" required>
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa-solid fa-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Create a password (min 6 characters)"
                                        required>
                                    <button type="button" class="input-group-text bg-light border-start-0"
                                        onclick="togglePassword('password', 'toggleIcon1')">
                                        <i class="fa-solid fa-eye text-muted" id="toggleIcon1"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fa-solid fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 border-end-0 ps-0"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirm your password" required>
                                    <button type="button" class="input-group-text bg-light border-start-0"
                                        onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                        <i class="fa-solid fa-eye text-muted" id="toggleIcon2"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    <i class="fa-solid fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="text-muted mb-0">Already have an account?</p>
                            <a href="{{ route('front.login') }}" class="btn btn-outline-primary mt-2 fw-semibold">
                                <i class="fa-solid fa-right-to-bracket me-2"></i>Sign In
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
@endpush