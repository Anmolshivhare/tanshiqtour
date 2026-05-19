<header class="sticky-top bg-white shadow bg-body-tertiary rounded">
    <div class="d-flex d-none d-md-block d-lg-block align-items-center justify-content-start bg-primary py-3">
        <div class="container d-flex gap-4 align-items-center">

            <p class="text-white mb-2 fs-6"><a href="mailto:info@primostravellers.com" class="text-white"
                    target="_blank"><i class="fas fa-envelope me-1  "></i> info@primostravellers.com </a></p>

            <p class="text-white mb-2 fs-6"> <a href="tel:+918445542594" class="text-white">
                    <i class="fa fa-phone me-1  "></i> +918445542594
                </a>
            </p>
        </div>
    </div>
    <nav class="container navbar navbar-expand-lg  ">
        <div class="container-fluid ">
            <a class="navbar-brand fw-bold logo-container w-auto" href="{{route('home')}}">
                <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="Primos Travellers Logo" width="120"
                    height="100">
            </a>
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav gap-md-4 d-flex justify-content-center">
                    <li class="nav-item"><a class="nav-link active" href="{{ route('home') }}">Home </a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('front.tours') }}">Tours</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('front.about') }}">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('front.contact') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="d-flex d-none d-md-flex d-lg-flex align-items-center justify-content-end gap-3">
                <a href="{{ route('front.tours') }}" class="btn btn-primary text-white btn-lg fw-bold">Book
                    Now</a>

                {{-- User Profile Section --}}
                @auth
                    <div class="dropdown">
                        <a class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2" href="#"
                            role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth()->user()->profile_pic)
                                <img src="{{ Storage::url('profile_images/' . auth()->user()->profile_pic) }}" alt="Profile"
                                    class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                    style="width: 30px; height: 30px; font-size: 12px;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="d-none d-lg-inline">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-bold">{{ auth()->user()->name }}</div>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('front.profile') }}">
                                    <i class="fa-solid fa-user me-2 text-primary"></i>My Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="{{ route('front.logout') }}">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('front.login') }}" class="btn btn-outline-primary">
                        <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>
</header>
