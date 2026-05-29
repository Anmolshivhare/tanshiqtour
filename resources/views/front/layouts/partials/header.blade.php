{{-- Top Contact Bar --}}
<div class="tt-topbar d-none d-md-block">
    <div class="container">
        <div class="tt-topbar__inner">
            <div class="tt-topbar__left">
                <a href="tel:+918445542594" class="tt-topbar__item">
                    <i class="fa fa-phone"></i>
                    <span>+91-8445542594</span>
                </a>
                <a href="mailto:info@tanishqtourandtravels.com" class="tt-topbar__item">
                    <i class="fas fa-envelope"></i>
                    <span>info@tanishqtourandtravels.com</span>
                </a>
                <span class="tt-topbar__item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>220, Udyog Vihar Phase 4, Gurugram, Haryana</span>
                </span>
            </div>
            <div class="tt-topbar__right">
                <a href="https://www.facebook.com/profile.php?id=61584292436038" target="_blank" class="tt-topbar__social"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/tanishqtourandtravels/" target="_blank" class="tt-topbar__social"><i class="fab fa-instagram"></i></a>
                <a href="https://www.youtube.com/" target="_blank" class="tt-topbar__social"><i class="fab fa-youtube"></i></a>
                <a href="https://wa.me/918445542594" target="_blank" class="tt-topbar__social"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
</div>

{{-- Main Navbar --}}
<header class="tt-navbar" id="tt-navbar">
    <div class="container">
        <nav class="tt-nav">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="tt-nav__logo">
                <img src="{{ Vite::asset('resources/images/Tanishq Tour & Travels.png') }}" alt="Tanishq Tour & Travel" class="tt-nav__logo-img" id="nav-logo">
            </a>

            {{-- Desktop Nav Links --}}
            <ul class="tt-nav__links" id="nav-links">
                <li><a href="{{ route('home') }}" class="tt-nav__link {{ Request::routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('front.about') }}" class="tt-nav__link {{ Request::routeIs('front.about') ? 'active' : '' }}">About Us</a></li>
                <li><a href="{{ route('front.destinations') }}" class="tt-nav__link {{ Request::routeIs('front.destinations') ? 'active' : '' }}">Destinations</a></li>
                <li><a href="{{ route('front.tours') }}" class="tt-nav__link {{ Request::routeIs('front.tours') ? 'active' : '' }}">Tour Packages</a></li>
                <li><a href="{{ route('front.careers') }}" class="tt-nav__link {{ Request::routeIs('front.careers') ? 'active' : '' }}">Careers</a></li>
                <li><a href="{{ route('front.contact') }}" class="tt-nav__link {{ Request::routeIs('front.contact') ? 'active' : '' }}">Contact Us</a></li>
            </ul>

            {{-- Nav Actions --}}

            {{--  <div class="tt-nav__actions">
                @auth
                    <div class="dropdown">
                        <a class="tt-nav__user dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if (auth()->user()->profile_pic)
                                <img src="{{ Storage::url('profile_images/' . auth()->user()->profile_pic) }}" alt="Profile" class="tt-nav__avatar">
                            @else
                                <div class="tt-nav__avatar tt-nav__avatar--initials">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            @endif
                            <span class="d-none d-lg-inline">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="userDropdown">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-bold small">{{ auth()->user()->name }}</div>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </li>
                            <li><a class="dropdown-item py-2" href="{{ route('front.profile') }}"><i class="fa-solid fa-user me-2 text-primary"></i>My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 text-danger" href="{{ route('front.logout') }}"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('front.login') }}" class="tt-nav__btn-outline">
                        <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                    </a>
                @endauth
                <a href="{{ route('front.tours') }}" class="tt-nav__btn-primary">
                    <i class="fa-solid fa-compass me-1"></i> Book Now
                </a>

                
                <button class="tt-hamburger" id="tt-hamburger" aria-label="Toggle navigation" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
               --}}
        </nav>
    </div>
</header>

{{-- Mobile Slide-In Drawer --}}
<div class="tt-drawer-overlay" id="tt-drawer-overlay"></div>
<aside class="tt-drawer" id="tt-drawer">
    <div class="tt-drawer__header">
        <img src="{{ Vite::asset('resources/images/Tanishq Tour & Travels.png') }}" alt="Logo" height="60">
        <button class="tt-drawer__close" id="tt-drawer-close"><i class="fas fa-times"></i></button>
    </div>
    <nav class="tt-drawer__nav">
        <a href="{{ route('home') }}" class="tt-drawer__link {{ Request::routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('front.tours') }}" class="tt-drawer__link {{ Request::routeIs('front.tours') ? 'active' : '' }}"><i class="fas fa-map-marked-alt"></i> Tours</a>
        <a href="{{ route('front.about') }}" class="tt-drawer__link {{ Request::routeIs('front.about') ? 'active' : '' }}"><i class="fas fa-info-circle"></i> About Us</a>
        <a href="{{ route('front.contact') }}" class="tt-drawer__link {{ Request::routeIs('front.contact') ? 'active' : '' }}"><i class="fas fa-phone-alt"></i> Contact</a>
    </nav>
    <div class="tt-drawer__footer">
        <a href="{{ route('front.tours') }}" class="tt-nav__btn-primary w-100 text-center"><i class="fas fa-compass me-1"></i> Book Now</a>
        <div class="tt-drawer__socials">
            <a href="https://www.facebook.com/profile.php?id=61584292436038" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/tanishqtourandtravels/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://wa.me/918445542594" target="_blank"><i class="fab fa-whatsapp"></i></a>
        </div>
    </div>
</aside>
