// ---- Tour Enquiry Form ----
(function () {
    const form = document.getElementById("tourEnquiryForm");
    if (!form) return;

    const submitBtn = document.getElementById("tourEnquirySubmitBtn");
    const defaultSubmitHtml = submitBtn?.innerHTML || "Book Now &raquo;";

    function removeMessages() {
        form.parentElement
            ?.querySelectorAll(".tt-tour-enquiry-alert--ajax")
            .forEach((message) => message.remove());
    }

    function showMessage(type, message) {
        removeMessages();

        const alertType = type === "success" ? "success" : "danger";
        const iconClass = type === "success" ? "fa-check-circle" : "fa-exclamation-circle";

        form.insertAdjacentHTML(
            "beforebegin",
            `<div class="tt-tour-enquiry-alert tt-tour-enquiry-alert--ajax alert alert-${alertType} alert-dismissible fade show mb-3" role="alert">
                <i class="fas ${iconClass} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`,
        );
    }

    function setSubmitting(isSubmitting) {
        if (!submitBtn) return;
        submitBtn.disabled = isSubmitting;
        submitBtn.innerHTML = isSubmitting
            ? '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Sending...'
            : defaultSubmitHtml;
    }

    function clearValidation() {
        form.querySelectorAll(".is-invalid").forEach((field) => {
            field.classList.remove("is-invalid");
        });
        form.querySelectorAll(".tt-tour-enquiry-error--ajax").forEach((error) => {
            error.remove();
        });
    }

    function showValidationErrors(errors) {
        clearValidation();

        Object.entries(errors || {}).forEach(([name, messages]) => {
            const field = form.querySelector(`[name="${name}"]`);
            if (!field) return;

            field.classList.add("is-invalid");
            const error = document.createElement("div");
            error.className = "invalid-feedback d-block tt-tour-enquiry-error--ajax";
            error.textContent = Array.isArray(messages) ? messages[0] : messages;

            const inputGroup = field.closest(".input-group");
            if (inputGroup) {
                inputGroup.insertAdjacentElement("afterend", error);
                return;
            }

            field.insertAdjacentElement("afterend", error);
        });
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        removeMessages();
        clearValidation();
        setSubmitting(true);

        $.ajax({
            url: form.action,
            type: form.method || "POST",
            data: new FormData(form),
            processData: false,
            contentType: false,
            headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content"),
            },
            success(response) {
                const tourId = form.querySelector('[name="tour_id"]')?.value || "";
                form.reset();
                if (tourId) {
                    form.querySelector('[name="tour_id"]').value = tourId;
                }
                showMessage(
                    "success",
                    response.message || "Thank you! Your tour enquiry has been sent successfully.",
                );
            },
            error(xhr) {
                const response = xhr.responseJSON || {};

                if (xhr.status === 422 && response.errors) {
                    showValidationErrors(response.errors);
                    showMessage("error", "Please fix the errors below.");
                    return;
                }

                showMessage(
                    "error",
                    response.message || "Unable to send your tour enquiry. Please try again.",
                );
            },
            complete() {
                setSubmitting(false);
            },
        });
    });
})();
