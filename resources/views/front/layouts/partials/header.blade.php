{{-- Top Contact Bar --}}
<div class="tt-topbar d-none d-md-block">
    <div class="container">
        @php
            $phone = $settingData->contact_phone ?? '';
            $email = $settingData->contact_email ?? '';
            $address = $settingData->address ?? '';
            $facebookUrl = $settingData->facebook_url ?? '';
            $instagramUrl = $settingData->instagram_url ?? '';
            $youtubeUrl = $settingData->youtube_url ?? '';
            $whatsappNumber = preg_replace('/\D+/', '', (string) ($settingData->whatsapp_number ?? ''));
        @endphp
        <div class="tt-topbar__inner">
            <div class="tt-topbar__left">
                <a href="tel:{{ $phone }}" class="tt-topbar__item">
                    <i class="fa fa-phone"></i>
                    <span>{{ $phone }}</span>
                </a>
                <a href="mailto:{{ $email }}" class="tt-topbar__item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $email }}</span>
                </a>
                <span class="tt-topbar__item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $address }}</span>
                </span>
            </div>
            <div class="tt-topbar__right">
                <a href="{{ $facebookUrl }}" target="_blank" class="tt-topbar__social"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ $instagramUrl }}" target="_blank" class="tt-topbar__social"><i class="fab fa-instagram"></i></a>
                <a href="{{ $youtubeUrl }}" target="_blank" class="tt-topbar__social"><i class="fab fa-youtube"></i></a>
                <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="tt-topbar__social"><i class="fab fa-whatsapp"></i></a>
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
                <img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('header_logo', 'resources/images/Tanishq Tour & Travels.png') }}" alt="Tanishq Tour & Travel" class="tt-nav__logo-img" id="nav-logo">
            </a>

            {{-- Desktop Nav Links --}}
            <ul class="tt-nav__links" id="nav-links">
                <li><a href="{{ route('home') }}" class="tt-nav__link {{ Request::routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('front.about') }}" class="tt-nav__link {{ Request::routeIs('front.about') ? 'active' : '' }}">About Us</a></li>
                <li><a href="{{ route('front.destinations') }}" class="tt-nav__link {{ Request::routeIs('front.destinations') ? 'active' : '' }}">Destinations</a></li>
                <li><a href="{{ route('front.tours') }}" class="tt-nav__link {{ Request::routeIs('front.tours') ? 'active' : '' }}">Tour Packages</a></li>
                <li><a href="{{ route('front.gallery') }}" class="tt-nav__link {{ Request::routeIs('front.gallery') ? 'active' : '' }}">Gallery</a></li>
                {{-- <li><a href="{{ route('front.careers') }}" class="tt-nav__link {{ Request::routeIs('front.careers') ? 'active' : '' }}">Careers</a></li> --}}
                <li><a href="{{ route('front.contact') }}" class="tt-nav__link {{ Request::routeIs('front.contact') ? 'active' : '' }}">Contact Us</a></li>
                @auth
                    <li><a href="{{ route('front.profile') }}" class="tt-nav__link {{ Request::routeIs('front.profile*') ? 'active' : '' }}">My Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('front.logout') }}">
                            @csrf
                            <button type="submit" class="tt-nav__link border-0 bg-transparent">Sign Out</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('front.login') }}" class="tt-nav__link {{ Request::routeIs('front.login') ? 'active' : '' }}">Sign In</a></li>
                    <li><a href="{{ route('front.register') }}" class="tt-nav__link {{ Request::routeIs('front.register') ? 'active' : '' }}">Register</a></li>
                @endauth
            </ul>

            {{-- Nav Actions --}}

             <div class="tt-nav__actions">
                <button class="tt-hamburger" id="tt-hamburger" aria-label="Toggle navigation" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
              
        </nav>
    </div>
</header>

{{-- Mobile Slide-In Drawer --}}
<div class="tt-drawer-overlay" id="tt-drawer-overlay"></div>
<aside class="tt-drawer" id="tt-drawer">
    <div class="tt-drawer__header">
        <img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('header_logo', 'resources/images/Tanishq Tour & Travels.png') }}" alt="Logo" height="60">
        <button class="tt-drawer__close" id="tt-drawer-close"><i class="fas fa-times"></i></button>
    </div>
    <nav class="tt-drawer__nav">
        <a href="{{ route('home') }}" class="tt-drawer__link {{ Request::routeIs('home') ? 'active' : '' }}"><i class="fas fa-home"></i> Home</a>
        <a href="{{ route('front.about') }}" class="tt-drawer__link {{ Request::routeIs('front.about') ? 'active' : '' }}"><i class="fas fa-info-circle"></i> About Us</a>
        <a href="{{ route('front.tours') }}" class="tt-drawer__link {{ Request::routeIs('front.tours') ? 'active' : '' }}"><i class="fas fa-map-marked-alt"></i> Tour packages</a>
        <a href="{{ route('front.destinations') }}" class="tt-drawer__link {{ Request::routeIs('front.destinations') ? 'active' : '' }}"><i class="fas fa-map-marker-alt"></i> Destinations</a>
        <a href="{{ route('front.gallery') }}" class="tt-drawer__link {{ Request::routeIs('front.gallery') ? 'active' : '' }}"><i class="fas fa-images"></i> Gallery</a>
        {{-- <a href="{{ route('front.careers') }}" class="tt-drawer__link {{ Request::routeIs('front.careers') ? 'active' : '' }}"><i class="fas fa-briefcase"></i> Careers</a> --}}
        <a href="{{ route('front.contact') }}" class="tt-drawer__link {{ Request::routeIs('front.contact') ? 'active' : '' }}"><i class="fas fa-phone-alt"></i> Contact</a>
        @auth
            <a href="{{ route('front.profile') }}" class="tt-drawer__link {{ Request::routeIs('front.profile*') ? 'active' : '' }}"><i class="fas fa-user"></i> My Profile</a>
            <form method="POST" action="{{ route('front.logout') }}">
                @csrf
                <button type="submit" class="tt-drawer__link w-100 text-start border-0 bg-transparent"><i class="fas fa-sign-out-alt"></i> Sign Out</button>
            </form>
        @else
            <a href="{{ route('front.login') }}" class="tt-drawer__link {{ Request::routeIs('front.login') ? 'active' : '' }}"><i class="fas fa-sign-in-alt"></i> Sign In</a>
            <a href="{{ route('front.register') }}" class="tt-drawer__link {{ Request::routeIs('front.register') ? 'active' : '' }}"><i class="fas fa-user-plus"></i> Register</a>
        @endauth
    </nav>
    <div class="tt-drawer__footer">
        {{-- <a href="{{ route('front.tours') }}" class="tt-nav__btn-primary w-100 text-center"><i class="fas fa-compass me-1"></i> Book Now</a> --}}
        <div class="tt-drawer__socials">
            <a href="{{ $facebookUrl }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="{{ $instagramUrl }}" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://wa.me/{{ $whatsappNumber }}z" target="_blank"><i class="fab fa-whatsapp"></i></a>
            <a href="{{ $youtubeUrl }}" target="_blank" class="tt-topbar__social"><i class="fab fa-youtube"></i></a>
        </div>
    </div>
</aside>
