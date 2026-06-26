// ---- Contact Form ----
(function () {
    const form = document.getElementById("contact-form");
    if (!form) return;

    const submitBtn = document.getElementById("contact-submit-btn");
    const defaultSubmitHtml = submitBtn?.innerHTML || "Send Message";

    function removeAjaxMessages() {
        form.parentElement
            ?.querySelectorAll(".tt-contact-alert--ajax")
            .forEach((message) => message.remove());
    }

    function showMessage(type, message, details = []) {
        removeAjaxMessages();

        const alertType = type === "success" ? "success" : "danger";
        const iconClass = type === "success" ? "fa-check-circle" : "fa-exclamation-circle";
        const detailList = details.length
            ? `<ul class="mb-0 mt-2">${details.map((detail) => `<li>${detail}</li>`).join("")}</ul>`
            : "";

        form.insertAdjacentHTML(
            "beforebegin",
            `<div class="tt-contact-alert tt-contact-alert--ajax alert alert-${alertType} alert-dismissible fade show mb-4" role="alert">
                <i class="fas ${iconClass} me-2"></i>${message}${detailList}
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
        form.querySelectorAll(".tt-contact-form__error--ajax").forEach((error) => {
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
            error.className = "invalid-feedback d-block tt-contact-form__error--ajax";
            error.textContent = Array.isArray(messages) ? messages[0] : messages;

            const inputWrap = field.closest(".tt-contact-form__input-wrap");
            if (inputWrap) {
                inputWrap.insertAdjacentElement("afterend", error);
                return;
            }

            field.insertAdjacentElement("afterend", error);
        });
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        removeAjaxMessages();
        clearValidation();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

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
                form.reset();
                showMessage(
                    "success",
                    response.message || "Thank you! Your message has been sent successfully.",
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
                    response.message || "Unable to send your message. Please try again.",
                );
            },
            complete() {
                setSubmitting(false);
            },
        });
    });
})();
