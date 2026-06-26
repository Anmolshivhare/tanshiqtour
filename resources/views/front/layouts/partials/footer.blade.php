<div class="contact-fab-container">
    @php
        $facebookUrl = $settingData->facebook_url ?? '';
        $instagramUrl = $settingData->instagram_url ?? '';
        $youtubeUrl = $settingData->youtube_url ?? '';
        $phone = $settingData->contact_phone ?? '';
        $whatsappNumber = preg_replace('/\D+/', '', (string) ($settingData->whatsapp_number ?? ''));
    @endphp

    <a href="#" class="contact-label text-decoration-none border border-white" id="contact-label">Contact us</a>

    <button class="fab-main border border-white" id="fab-main">
        <i class="fas fa-comment-dots"></i>
    </button>

    <div class="fab-actions" id="fab-actions">
        <a href="{{ $instagramUrl }}" target="_blank" class="fab-action fab-instagram" data-bs-toggle="tooltip"
            data-bs-placement="left" title="instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="{{ $facebookUrl }}" target="_blank" class="fab-action fab-facebook" data-bs-toggle="tooltip"
            data-bs-placement="left" title="facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="{{ $youtubeUrl }}" target="_blank" class="fab-action fab-youtube" data-bs-toggle="tooltip"
            data-bs-placement="left" title="youtube">
            <i class="fab fa-youtube"></i>
        </a>
        <a href="tel:{{ $phone }}" class="fab-action fab-phone" data-bs-toggle="tooltip" data-bs-placement="left"
            title="Call Us">
            <i class="fas fa-phone-alt"></i>
        </a>
        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="fab-action fab-whatsapp" data-bs-toggle="tooltip"
            data-bs-placement="left" title="WhatsApp Us">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

</div>

<footer class="bg-primary text-white pt-5 pb-4 mt-5">
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <a class="navbar-brand fw-bold logo-container mb-3" href="{{ route('home') }}">
                    <img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('footer_logo', 'resources/images/Tanishq Tour & Travels.png') }}" alt="Tanishq Tour & Travel Logo"
                        width="120" height="100">
                </a>
                <p class="text-white text-justify small lh-lg pt-3">
                    Explore the world with us. We offer the best tour packages and customized adventures across the
                    globe.
                </p>
                <div class="d-flex mt-3">
                    <a href="{{ $facebookUrl }}" class="text-white me-3" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $instagramUrl }}" class="text-white me-3" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $youtubeUrl }}" class="text-white me-3" target="_blank"><i class="fab fa-youtube"></i></a>
                    <a href="https://wa.me/{{ $whatsappNumber }}" class="text-white me-3" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase fw-bolder mb-5">Quick Links</h5>
                <ul class="list-unstyled ps-lg-5 ps-2">
                    <li class="mb-2"><a href="{{ route('home') }}"
                            class="text-white lh-lg text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ route('front.about') }}"
                                    class="text-white lh-lg text-decoration-none">About Us</a></li>
                    <li class="mb-2"><a href="{{ route('front.destinations') }}"
                                    class="text-white lh-lg text-decoration-none">Destinations</a></li>
                    <li class="mb-2"><a href="{{ route('front.tours') }}"
                            class="text-white lh-lg text-decoration-none">Tour Packages</a></li>
                    <li class="mb-2"><a href="{{ route('front.gallery') }}"
                            class="text-white lh-lg text-decoration-none">Gallery</a></li>
                    <li class="mb-2"><a href="{{ route('front.contact') }}"
                            class="text-white lh-lg text-decoration-none">Contact Us</a></li>

                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase fw-bolder mb-5">Contact Info</h5>

                <p class="text-white lh-lg mb-2"><a href="mailto:{{ $settingData->contact_email ?? '' }}" class="text-white"
                        target="_blank"><i class="fas fa-envelope me-3"></i> {{ $settingData->contact_email ?? '' }} </a></p>
                <p class="text-white lh-lg mb-2"><a href="mailto:{{ $settingData->support_email ?? 'support@tanishqtourandtravels.com' }}" class="text-white"
                        target="_blank"><i class="fas fa-envelope me-3"></i> {{ $settingData->support_email ?? 'support@tanishqtourandtravels.com' }} </a></p>
                <p class="text-white lh-lg mb-2"> <a href="tel:{{ $phone }}" class="text-white">
                        <i class="fa fa-phone me-3"></i> {{ $phone }}
                    </a>
                </p>
                <p class="text-white lh-lg mb-2"> <a href="{{ $settingData->website_url ?? 'https://tanishqtourandtravels.com' }}" class="text-white">
                        <i class="fas fa-globe-americas me-3"></i> {{ $settingData->website_url ?? 'www.tanishqtourandtravels.com' }}
                    </a>
                </p>
                <div class="d-flex">
                    <div class="text-white lh-lg mb-2">
                        <i class="fas fa-map-marker-alt me-3"></i>
                    </div>
                    <div>
                        <p class="text-white lh-lg mb-2">
                            {{ $settingData->address ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase fw-bolder mb-5 ">Map</h5>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d887.4185215112226!2d78.03612516962596!3d27.166542791689533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397471c46e6ba04d%3A0xdaa3691a1a34b453!2sTanishq%20Tour%20%26%20Travels%20%7C%20best%20travel%20agency%20in%20agra!5e0!3m2!1sen!2sin!4v1781940985266!5m2!1sen!2sin" width="400" height="250" class="me-2" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
  
</footer>
 <div class="row me-0 footer-copyright">
        <div class="col-12 text-center my-3">
            <p class="mb-0 text-white fw-bolder ">{{ $settingData->copyright ?? 'Copyright 2026 Tanishq Tour' }}</p>
        </div>
 </div>
