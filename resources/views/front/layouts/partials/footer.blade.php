<div class="contact-fab-container">

    <a href="#" class="contact-label text-decoration-none border border-white" id="contact-label">Contact us</a>

    <button class="fab-main border border-white" id="fab-main">
        <i class="fas fa-comment-dots"></i>
    </button>

    <div class="fab-actions" id="fab-actions">
        <a href="https://www.instagram.com/primostravellers/" target="_blank" class="fab-action fab-instagram" data-bs-toggle="tooltip"
            data-bs-placement="left" title="instagram">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.facebook.com/profile.php?id=61584292436038" target="_blank" class="fab-action fab-facebook" data-bs-toggle="tooltip"
            data-bs-placement="left" title="facebook">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.youtube.com/" target="_blank" class="fab-action fab-youtube" data-bs-toggle="tooltip"
            data-bs-placement="left" title="youtube">
            <i class="fab fa-youtube"></i>
        </a>
        <a href="tel:918445542594" class="fab-action fab-phone" data-bs-toggle="tooltip" data-bs-placement="left"
            title="Call Us">
            <i class="fas fa-phone-alt"></i>
        </a>
        <a href="https://wa.me/918445542594" target="_blank" class="fab-action fab-whatsapp" data-bs-toggle="tooltip"
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
                    <img src="{{ Vite::asset('resources/images/footer_logo.svg') }}" alt="Primos Travellers Logo"
                        width="120" height="100">
                </a>
                <p class="text-white text-justify small lh-lg">
                    Explore the world with us. We offer the best tour packages and customized adventures across the
                    globe.
                </p>
                <div class="d-flex mt-3">
                    <a href="javascript:void(0)" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="javascript:void(0)" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="javascript:void(0)" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase fw-bolder mb-5">Quick Links</h5>
                <ul class="list-unstyled ps-lg-5 ps-2">
                    <li class="mb-2"><a href="{{ route('home') }}"
                            class="text-white lh-lg text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="{{ route('front.tours') }}"
                            class="text-white lh-lg text-decoration-none">Tours</a></li>
                    <li class="mb-2"><a href="{{ route('front.about') }}"
                            class="text-white lh-lg text-decoration-none">About Us</a></li>
                    <li class="mb-2"><a href="{{ route('front.contact') }}"
                            class="text-white lh-lg text-decoration-none">Contact Us</a></li>

                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase fw-bolder mb-5">Contact Info</h5>

                <p class="text-white lh-lg mb-2"><a href="mailto:info@primostravellers.com" class="text-white"
                        target="_blank"><i class="fas fa-envelope me-3"></i> info@primostravellers.com </a></p>
                <p class="text-white lh-lg mb-2"><a href="mailto:support@primostravellers.com" class="text-white"
                        target="_blank"><i class="fas fa-envelope me-3"></i> support@primostravellers.com </a></p>
                <p class="text-white lh-lg mb-2"> <a href="tel:+918445542594" class="text-white">
                        <i class="fa fa-phone me-3"></i> +91-8445542594
                    </a>
                </p>
                <p class="text-white lh-lg mb-2"> <a href="https://primostravellers.com" class="text-white">
                        <i class="fas fa-globe-americas me-3"></i> www.primostravellers.com
                    </a>
                </p>
                <div class="d-flex">
                    <div class="text-white lh-lg mb-2">
                        <i class="fas fa-map-marker-alt me-3"></i>
                    </div>
                    <div>
                        <p class="text-white lh-lg mb-2">
                            220, Udyog Vihar Phase 4 rd phase 3rd Udyog Vihar sector 18 gurugram Shahpur Haryana 122019
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="text-uppercase fw-bolder mb-5 ">Map</h5>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d248.3809009050046!2d77.0803829905804!3d28.491743976176814!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d193e3a6a7905%3A0x5ca3e96c47a011f0!2sTag%20Tower%2C%20220%2C%20Udyog%20Vihar%20Phase%204%20Rd%2C%20Phase%20III%2C%20Udyog%20Vihar%2C%20Sector%2018%2C%20Gurugram%2C%20Shahpur%2C%20Haryana%20122015!5e0!3m2!1sen!2sin!4v1763576348366!5m2!1sen!2sin"
                    width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <hr class="my-3 text-secondary">

    <div class="row me-0 ">
        <div class="col-12 text-center my-3">
            <p class="mb-0 text-white fw-bolder ">&copy; <span id="currentYear"></span> Copyrights All Rights Reserved
                by
                Primos Travellers. </p>
        </div>
    </div>
</footer>
