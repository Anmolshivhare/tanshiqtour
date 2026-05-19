import "./bootstrap";
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

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
// Navbar Scroll Effect
// ==========================================
$(function () {
    $(window).on("scroll", function () {
        if ($(window).scrollTop() > 50) {
            $("#main-nav").addClass("scrolled");
        } else {
            $("#main-nav").removeClass("scrolled");
        }
    });

    if ($(window).scrollTop() > 50) {
        $("#main-nav").addClass("scrolled");
    }
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
            $fabMain.css({ "background-color": "#00004F", transform: "none" });
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
            theme: { color: "#0d6efd" },
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
