import "./bootstrap";
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";
import { gsap } from "gsap";
import { MotionPathPlugin } from "gsap/MotionPathPlugin";
import Swiper from "swiper";
import { EffectCoverflow, Pagination, Autoplay, Navigation } from "swiper/modules";

gsap.registerPlugin(MotionPathPlugin);

const BRAND_PRIMARY = "#022179";

// ==========================================
// Profile Image Cropper
// ==========================================
$(function () {
    const $dropzone = $("#profile-dropzone");
    const $fileInput = $("#profile_pic");
    const $croppedDataInput = $("#cropped_image");
    const $profilePreview = $("#profilePreview");
    const $profilePreviewDefault = $("#profilePreviewDefault");
    const $cropBtn = $("#crop-btn");
    const $cancelCropBtn = $("#cancel-crop-btn");
    const $errorMessage = $("#image-error-message");

    // Exit if dropzone doesn't exist on this page
    if ($dropzone.length === 0) {
        return;
    }

    let cropper = null;
    let modalInstance = null;
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
    const ALLOWED_TYPES = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "image/webp",
    ];

    // Show error message
    function showError(message) {
        $errorMessage.text(message).removeClass("d-none");
        setTimeout(() => {
            $errorMessage.addClass("d-none");
        }, 5000);
    }

    // Clear error message
    function clearError() {
        $errorMessage.addClass("d-none").text("");
    }

    // Validate file before processing
    function validateFile(file) {
        clearError();

        if (!file) {
            showError("Please select a file.");
            return false;
        }

        if (!ALLOWED_TYPES.includes(file.type)) {
            showError(
                "Invalid file type. Only JPEG, PNG, JPG, and WEBP are allowed.",
            );
            return false;
        }

        if (file.size > MAX_FILE_SIZE) {
            showError("File size exceeds 2MB limit.");
            return false;
        }

        return true;
    }

    // Function to initialize cropper
    function initCropper() {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }

        const imageElement = document.getElementById("cropper-image");
        if (!imageElement.src || imageElement.src === window.location.href) {
            return;
        }

        cropper = new Cropper(imageElement, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: "move",
            autoCropArea: 0.8,
            restore: false,
            guides: true,
            center: true,
            highlight: true,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
            background: true,
            responsive: true,
        });
    }

    // Initialize cropper when modal is shown
    const cropperModalEl = document.getElementById("cropperModal");
    if (cropperModalEl) {
        cropperModalEl.addEventListener("shown.bs.modal", () => {
            setTimeout(initCropper, 100);
        });

        cropperModalEl.addEventListener("hidden.bs.modal", () => {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            document.getElementById("cropper-image").src = "";
        });
    }

    // Handle file selection
    function handleFileSelect(file) {
        if (validateFile(file)) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById("cropper-image").src = e.target.result;

                if (!modalInstance) {
                    modalInstance = new bootstrap.Modal(
                        document.getElementById("cropperModal"),
                    );
                }
                modalInstance.show();
            };
            reader.readAsDataURL(file);
        }
        $fileInput.val("");
    }

    // Click on dropzone to trigger file input
    $dropzone.on("click", (e) => {
        if (!$(e.target).is("input")) {
            $fileInput.trigger("click");
        }
    });

    // File input change handler
    $fileInput.on("change", function () {
        if (this.files && this.files[0]) {
            handleFileSelect(this.files[0]);
        }
    });

    // Drag and drop handlers
    $dropzone.on("dragover dragenter", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass("dropzone-active");
    });

    $dropzone.on("dragleave dragend", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass("dropzone-active");
    });

    $dropzone.on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass("dropzone-active");

        const files = e.originalEvent.dataTransfer.files;
        if (files && files.length > 0) {
            handleFileSelect(files[0]);
        }
    });

    // Crop button handler
    $cropBtn.on("click", () => {
        if (cropper) {
            try {
                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: "high",
                });

                if (canvas) {
                    const croppedDataUrl = canvas.toDataURL("image/jpeg", 0.9);
                    $croppedDataInput.val(croppedDataUrl);
                    $profilePreview
                        .attr("src", croppedDataUrl)
                        .removeClass("d-none");

                    if ($profilePreviewDefault.length) {
                        $profilePreviewDefault.addClass("d-none");
                    }
                }

                if (modalInstance) {
                    modalInstance.hide();
                }
            } catch (error) {
                showError("Error cropping image. Please try again.");
            }
        } else {
            showError("Error: Cropper not initialized. Please try again.");
        }
    });

    // Cancel button handler
    $cancelCropBtn.on("click", () => {
        if (modalInstance) {
            modalInstance.hide();
        }
    });
});

// ==========================================
// Contact FAB Button
// ==========================================
$(function () {
    const $fabContainer = $(".contact-fab-container");
    const $fabMain = $("#fab-main");
    const $fabActions = $("#fab-actions");
    const defaultIconClass = "fas fa-comment-dots";
    const closeIconClass = "fas fa-times";

    $fabMain.html(`<i class="${defaultIconClass}"></i>`);

    $fabMain.on("click", function () {
        const isOpen = $fabContainer.toggleClass("open").hasClass("open");
        $fabActions.toggleClass("open");

        const $iconElement = $fabMain.find("i");

        if (isOpen) {
            $iconElement.removeClass(defaultIconClass).addClass(closeIconClass);
            $fabMain.css({ "background-color": BRAND_PRIMARY, transform: "none" });
        } else {
            $iconElement.removeClass(closeIconClass).addClass(defaultIconClass);
            $fabMain.css({ transform: "none" });
        }
    });
});

// ==========================================
// Counter Animation
// ==========================================
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

const counter = (element, target) => {
    let current = 0;
    const duration = 2000;
    const increment = target / (duration / 10);

    const timer = setInterval(() => {
        current += increment;

        if (current >= target) {
            clearInterval(timer);
            element.innerText = formatNumber(target) + " + ";
        } else {
            element.innerText = formatNumber(Math.ceil(current));
        }
    }, 10);
};

const counters = document.querySelectorAll(".counter-number");
let hasCounted = false;

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting && !hasCounted) {
                counters.forEach((counterElement) => {
                    const target = parseInt(counterElement.dataset.target);
                    counter(counterElement, target);
                });
                hasCounted = true;
                observer.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.5 },
);

const sectionToObserve = document.querySelector(".ameera-holidays-section");
if (sectionToObserve) {
    observer.observe(sectionToObserve);
}

// ==========================================
// Contact Booking Form AJAX
// ==========================================
$(function () {
    $("#bookingForm").on("submit", function (e) {
        e.preventDefault();

        const form = $(this);
        const button = $("#sendButton");
        const messageArea = $("#responseMessage");
        const bookingUrl = button.data("url");
        messageArea.html("");

        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return;
        }

        button.prop("disabled", true).text("Sending...");

        $.ajax({
            url: bookingUrl,
            type: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                messageArea.html(
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
                );
                button.text("Sent!").prop("disabled", false);
                form[0].reset();
            },
            error: function (xhr) {
                let errorMessage = "An error occurred. Please try again.";
                let errorDetails = "";

                if (xhr.status === 422) {
                    errorMessage = "Please fix the errors below.";
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        errorDetails += "<li>" + value[0] + "</li>";
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                messageArea.html(
                    '<div class="alert alert-danger"><strong>Error: ' +
                        errorMessage +
                        "</strong>" +
                        (errorDetails ? "<ul>" + errorDetails + "</ul>" : "") +
                        "</div>",
                );
                button.prop("disabled", false).text("Send");
            },
        });
    });
});

// ==========================================
// Booking Form - Tour Booking with Payment
// ==========================================
$(function () {
    const $form = $("#booking-form");
    const $submitBtn = $("#submit-btn");
    const $personsSelect = $("#number_of_persons");
    const $totalAmountInput = $("#total_amount");

    if ($form.length === 0) {
        return;
    }

    $.getScript("https://checkout.razorpay.com/v1/checkout.js");

    const pricePerPerson = parseFloat($form.data("price-per-person"));
    const loadingModal = new bootstrap.Modal($("#loadingModal")[0]);

    $personsSelect.on("change", function () {
        const persons = parseInt($(this).val());
        const total = pricePerPerson * persons;
        const formattedTotal = new Intl.NumberFormat("en-IN", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        }).format(total);
        $totalAmountInput.val(formattedTotal);
    });

    $form.on("submit", function (e) {
        e.preventDefault();
        $(".is-invalid").removeClass("is-invalid");

        $submitBtn
            .prop("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm me-2"></span>Processing...',
            );

        const formData = new FormData(this);
        const storeUrl = $form.data("store-url");
        const csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: storeUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: { "X-CSRF-TOKEN": csrfToken, Accept: "application/json" },
            success: function (data) {
                if (data.success) {
                    openRazorpayCheckout(data.order, data.booking_number);
                } else {
                    throw new Error(data.message || "Something went wrong");
                }
            },
            error: function (xhr) {
                $submitBtn
                    .prop("disabled", false)
                    .html(
                        '<i class="fa-solid fa-lock me-2"></i>Proceed to Payment',
                    );
                let errorMessage = "An error occurred. Please try again.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            },
        });
    });

    function openRazorpayCheckout(orderData) {
        const successUrl = $form.data("success-url");
        const cancelUrl = $form.data("cancel-url");
        const failureUrl = $form.data("failure-url");

        const options = {
            key: orderData.key,
            amount: orderData.amount,
            currency: orderData.currency,
            name: orderData.name,
            description: orderData.description,
            order_id: orderData.order_id,
            prefill: orderData.prefill,
            notes: orderData.notes,
            theme: { color: BRAND_PRIMARY },
            handler: function (response) {
                loadingModal.show();
                const redirectUrl =
                    successUrl +
                    "?razorpay_payment_id=" +
                    response.razorpay_payment_id +
                    "&razorpay_order_id=" +
                    response.razorpay_order_id +
                    "&razorpay_signature=" +
                    response.razorpay_signature;
                window.location.href = redirectUrl;
            },
            modal: {
                ondismiss: function () {
                    $submitBtn
                        .prop("disabled", false)
                        .html(
                            '<i class="fa-solid fa-lock me-2"></i>Proceed to Payment',
                        );
                    window.location.href =
                        cancelUrl + "?razorpay_order_id=" + orderData.order_id;
                },
            },
        };

        const rzp = new Razorpay(options);

        rzp.on("payment.failed", function (response) {
            const redirectUrl =
                failureUrl +
                "?razorpay_order_id=" +
                orderData.order_id +
                "&error_code=" +
                response.error.code +
                "&error_description=" +
                encodeURIComponent(response.error.description);
            window.location.href = redirectUrl;
        });

        rzp.open();
    }
});

// ==========================================
// HOMEPAGE: Swiper, GSAP, Navbar, Drawer, AOS
// ==========================================

// ---- Navbar Sticky + Shrink ----
(function () {
    const navbar = document.getElementById("tt-navbar");
    if (!navbar) return;

    let isScrolled = false;
    const addAt = 90;
    const removeAt = 40;

    function handleScroll() {
        const y = window.scrollY || window.pageYOffset;

        if (!isScrolled && y >= addAt) {
            isScrolled = true;
            navbar.classList.add("scrolled");
            return;
        }

        if (isScrolled && y <= removeAt) {
            isScrolled = false;
            navbar.classList.remove("scrolled");
        }
    }

    window.addEventListener("scroll", handleScroll, { passive: true });
    handleScroll();
})();

// ---- Mobile Drawer ----
(function () {
    const hamburger = document.getElementById("tt-hamburger");
    const drawer    = document.getElementById("tt-drawer");
    const overlay   = document.getElementById("tt-drawer-overlay");
    const close     = document.getElementById("tt-drawer-close");
    if (!hamburger) return;

    function openDrawer() {
        drawer.classList.add("open");
        overlay.classList.add("open");
        hamburger.classList.add("open");
        hamburger.setAttribute("aria-expanded", "true");
        document.body.style.overflow = "hidden";
    }
    function closeDrawer() {
        drawer.classList.remove("open");
        overlay.classList.remove("open");
        hamburger.classList.remove("open");
        hamburger.setAttribute("aria-expanded", "false");
        document.body.style.overflow = "";
    }
    hamburger.addEventListener("click", openDrawer);
    close && close.addEventListener("click", closeDrawer);
    overlay.addEventListener("click", closeDrawer);
})();

// ---- Hero Swiper (Coverflow) ----
(function () {
    const el = document.querySelector(".tt-hero-swiper");
    if (!el) return;
    new Swiper(el, {
        modules: [EffectCoverflow, Pagination, Autoplay],
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        coverflowEffect: { rotate: 30, stretch: 0, depth: 120, modifier: 1, slideShadows: true },
        pagination: { el: ".tt-hero-pagination", clickable: true },
    });
})();

// ---- Testimonials Swiper ----
(function () {
    const el = document.querySelector(".tt-testi-swiper");
    if (!el) return;
    new Swiper(el, {
        modules: [Pagination, Autoplay, Navigation],
        slidesPerView: 1,
        spaceBetween: 24,
        loop: true,
        autoplay: { delay: 4500, disableOnInteraction: false },
        pagination: { el: ".tt-testi-pagination", clickable: true },
        navigation: { prevEl: ".tt-testi-prev", nextEl: ".tt-testi-next" },
        breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } },
    });
})();

// ---- Destinations Swiper (Capsule Center Focus) ----
(function () {
    const section = document.querySelector(".tt-destinations");
    if (!section) return;

    const el = section.querySelector(".tt-destinations-swiper");
    const prevEl = section.querySelector(".tt-destinations-prev");
    const nextEl = section.querySelector(".tt-destinations-next");
    if (!el || !prevEl || !nextEl) return;

    const slideCount = el.querySelectorAll(".swiper-wrapper > .swiper-slide").length;
    const clampSlides = (value) => Math.max(1, Math.min(value, slideCount || 1));

    const destSwiper = new Swiper(el, {
        modules: [Pagination, Autoplay, Navigation],
        centeredSlides: false,
        slidesPerView: slideCount > 1 ? Math.min(1.25, slideCount) : 1,
        spaceBetween: 16,
        loop: slideCount > 1,
        loopAdditionalSlides: Math.min(4, slideCount),
        speed: 700,
        grabCursor: true,
        autoplay: { delay: 3000, disableOnInteraction: false, pauseOnMouseEnter: true },
        pagination: { el: ".tt-destinations-pagination", clickable: true },
        navigation: { prevEl, nextEl },
        watchOverflow: true,
        breakpoints: {
            480: { slidesPerView: clampSlides(2), spaceBetween: 16 },
            768: { slidesPerView: clampSlides(3), spaceBetween: 18 },
            1024: { slidesPerView: clampSlides(4), spaceBetween: 20 },
        },
    });

    const tabs = document.querySelectorAll(".tt-dest-filter__btn");
    const originalSlides = Array.from(
        el.querySelectorAll(".swiper-wrapper > .swiper-slide:not(.swiper-slide-duplicate)"),
    );

    if (!tabs.length || !originalSlides.length) return;
    const defaultIndex = originalSlides.findIndex(
        (slide) => slide.dataset.region === "asia",
    );
    if (defaultIndex >= 0) {
        destSwiper.slideToLoop(defaultIndex, 0);
    }

    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            tabs.forEach((btn) => btn.classList.remove("active"));
            tab.classList.add("active");

            const region = tab.dataset.region;
            const targetIndex = originalSlides.findIndex(
                (slide) => slide.dataset.region === region,
            );

            if (targetIndex >= 0) {
                destSwiper.slideToLoop(targetIndex, 650);
            }
        });
    });
})();

// ---- Destination Search (Live Filter) ----
(function () {
    const form = document.getElementById("destination-search-form");
    const input = document.getElementById("destination-search-input");
    const clearBtn = document.getElementById("destination-clear-btn");
    const resultsWrap = document.getElementById("destination-results");

    if (!form || !input || !clearBtn || !resultsWrap) {
        return;
    }

    const searchUrl = form.getAttribute("action");
    let debounceTimer = null;
    let activeRequest = null;
    const defaultResultsHtml = resultsWrap.innerHTML;

    function renderResults(payload) {
        if (payload && typeof payload.html === "string") {
            resultsWrap.innerHTML = payload.html;
            resultsWrap.querySelectorAll("[data-aos]").forEach((element) => {
                element.classList.add("aos-animate");
            });
        }
    }

    function setClearState(query) {
        clearBtn.classList.toggle("d-none", query.trim().length === 0);
    }

    function runSearch(rawQuery) {
        const query = rawQuery.trim();

        if (activeRequest && activeRequest.readyState !== 4) {
            activeRequest.abort();
        }

        setClearState(query);

        activeRequest = $.ajax({
            url: searchUrl,
            method: "GET",
            data: { q: query },
            dataType: "json",
            success(response) {
                renderResults(response);
            },
            error(xhr, status) {
                if (status === "abort") {
                    return;
                }

                if (!query) {
                    resultsWrap.innerHTML = defaultResultsHtml;
                }
            },
        });
    }

    input.addEventListener("input", function () {
        setClearState(this.value);
        window.clearTimeout(debounceTimer);
        debounceTimer = window.setTimeout(() => {
            runSearch(input.value);
        }, 250);
    });

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        window.clearTimeout(debounceTimer);
        runSearch(input.value);
    });

    clearBtn.addEventListener("click", function () {
        input.value = "";
        setClearState("");
        window.clearTimeout(debounceTimer);
        runSearch("");
        input.focus();
    });

    setClearState(input.value);
})();

// ---- GSAP Airplane SVG Path Animation ----
(function () {
    const plane = document.getElementById("svgPlane");
    const path  = document.getElementById("planePath");
    if (!plane || !path) return;
    gsap.to(plane, {
        duration: 8, repeat: -1, ease: "none",
        motionPath: { path: path, align: path, autoRotate: true, alignOrigin: [0.5, 0.5] },
    });
})();

// ---- Stagger Hero Reveal ----
document.addEventListener("tt:home:ready", function () {
    const items = ["#hero-badge","#hero-title","#hero-desc","#hero-ctas","#hero-search"];
    gsap.from(items, { opacity: 0, y: 40, stagger: 0.15, duration: 0.75, ease: "power3.out", delay: 0.2 });
    gsap.from("#hero-carousel", { opacity: 0, x: 60, duration: 1, ease: "power3.out", delay: 0.4 });
});

// ---- Mouse Parallax ----
(function () {
    const hero = document.getElementById("hero");
    if (!hero) return;
    hero.addEventListener("mousemove", (e) => {
        const r = hero.getBoundingClientRect();
        const x = (e.clientX - r.left - r.width  / 2) / r.width;
        const y = (e.clientY - r.top  - r.height / 2) / r.height;
        gsap.to(".tt-deco-icon", { x: x * 18, y: y * 14, duration: 0.6, ease: "power1.out" });
        gsap.to(".tt-cloud",     { x: x * -10, y: y * -6, duration: 0.8, ease: "power1.out" });
    });
})();

// ---- CTA Parallax ----
(function () {
    const bg = document.getElementById("cta-bg");
    if (!bg) return;
    window.addEventListener("scroll", () => {
        const r = bg.parentElement.getBoundingClientRect();
        bg.style.transform = `translateY(${-r.top * 0.25}px)`;
    }, { passive: true });
})();

// ---- Package Filter Tabs ----
(function () {
    const tabs  = document.querySelectorAll(".tt-filter-tab");
    const cards = document.querySelectorAll(".tt-pkg-card");
    if (!tabs.length) return;
    tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            tabs.forEach((t) => t.classList.remove("active"));
            tab.classList.add("active");
            const filter = tab.dataset.filter;
            cards.forEach((card) => {
                const match = filter === "all" || card.dataset.cat === filter;
                card.classList.toggle("hide", !match);
                if (match) gsap.fromTo(card, { opacity: 0, y: 20 }, { opacity: 1, y: 0, duration: 0.4, ease: "power2.out" });
            });
        });
    });
})();

// ---- Animated Counters ----
(function () {
    const counters = document.querySelectorAll(".tt-counter");
    const section  = document.getElementById("stats");
    if (!counters.length || !section) return;
    let triggered = false;
    new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting && !triggered) {
            triggered = true;
            counters.forEach((el) => {
                const target = parseInt(el.dataset.target, 10);
                gsap.fromTo(el,
                    { innerText: 0 },
                    {
                        innerText: target, duration: 2.2, ease: "power2.out",
                        snap: { innerText: 1 },
                        onUpdate() { el.innerText = Math.ceil(parseFloat(el.innerText)).toLocaleString(); },
                    }
                );
            });
        }
    }, { threshold: 0.4 }).observe(section);
})();

// ---- Scroll AOS ----
(function () {
    const elements = document.querySelectorAll("[data-aos]");
    if (!elements.length) return;
    new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const delay = parseInt(entry.target.dataset.aosDelay || "0", 10);
                setTimeout(() => entry.target.classList.add("aos-animate"), delay);
            }
        });
    }, { threshold: 0.12 }).observe(document.body);

    // Simpler per-element observer
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                const d = parseInt(e.target.dataset.aosDelay || "0", 10);
                setTimeout(() => e.target.classList.add("aos-animate"), d);
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    elements.forEach((el) => io.observe(el));
})();

// ---- Newsletter ----
(function () {
    const form = document.getElementById("newsletter-form");
    if (!form) return;
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        const btn = form.querySelector(".tt-newsletter__btn");
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i> Subscribed!';
        btn.style.background = "linear-gradient(135deg,#2ACE58,#1aab42)";
        setTimeout(() => { btn.innerHTML = orig; btn.style.background = ""; form.reset(); }, 3000);
    });
})();
