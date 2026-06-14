// ---- Tour Details Review Form ----
(function () {
    const form = document.getElementById("reviewForm");
    if (!form) return;

    const fileInput = document.getElementById("client_pic");
    const preview = document.getElementById("uploadPreview");
    const submitBtn = document.getElementById("reviewSubmitBtn");
    const starRating = document.getElementById("starRating");
    const stars = Array.from(document.querySelectorAll(".tt-star-rating__label"));
    const inputs = Array.from(document.querySelectorAll(".tt-star-rating__input"));
    const defaultPreviewHtml = preview?.innerHTML || "";
    const defaultSubmitHtml = submitBtn?.innerHTML || "Submit Now";

    function highlightStars(upTo) {
        stars.forEach((star, index) => {
            star.classList.toggle("tt-star-rating__label--active", index < upTo);
        });
    }

    function selectedStarIndex() {
        return inputs.findIndex((input) => input.checked);
    }

    function removeAjaxMessages() {
        form.parentElement
            ?.querySelectorAll(".tt-review-alert--ajax")
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
            `<div class="tt-review-alert tt-review-alert--ajax tt-review-alert--${type} d-flex align-items-start justify-content-between gap-3 mb-4 alert alert-${alertType}">
                <div class="d-flex align-items-start gap-3">
                    <i class="fas ${iconClass} mt-1"></i>
                    <span>${message}${detailList}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`,
        );
    }

    function setSubmitting(isSubmitting) {
        if (!submitBtn) return;
        submitBtn.disabled = isSubmitting;
        submitBtn.innerHTML = isSubmitting
            ? '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Submitting...'
            : defaultSubmitHtml;
    }

    function clearValidation() {
        form.querySelectorAll(".is-invalid").forEach((field) => {
            field.classList.remove("is-invalid");
        });
        form.querySelectorAll(".tt-review-form__error--ajax").forEach((error) => {
            error.remove();
        });
    }

    function fieldForError(name) {
        return form.querySelector(`[name="${name}"]`) || form.querySelector(`[name="${name}[]"]`);
    }

    function showValidationErrors(errors) {
        clearValidation();

        Object.entries(errors || {}).forEach(([name, messages]) => {
            const field = fieldForError(name);
            if (!field) return;

            field.classList.add("is-invalid");
            const message = Array.isArray(messages) ? messages[0] : messages;
            const error = document.createElement("div");
            error.className = "tt-review-form__error tt-review-form__error--ajax";
            error.textContent = message;

            if (field.type === "radio") {
                starRating?.insertAdjacentElement("afterend", error);
                return;
            }

            field.insertAdjacentElement("afterend", error);
        });
    }

    function resetReviewForm() {
        form.reset();
        clearValidation();
        highlightStars(0);

        if (preview) {
            preview.innerHTML = defaultPreviewHtml;
        }
    }

    fileInput?.addEventListener("change", function () {
        const file = this.files?.[0];
        if (!file || !preview) return;

        const reader = new FileReader();
        reader.onload = (event) => {
            preview.innerHTML = `<img src="${event.target?.result || ""}" alt="Profile preview" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        };
        reader.readAsDataURL(file);
    });

    stars.forEach((star, index) => {
        star.addEventListener("mouseenter", () => highlightStars(index + 1));
        star.addEventListener("click", () => {
            if (inputs[index]) {
                inputs[index].checked = true;
            }
            highlightStars(index + 1);
        });
    });

    starRating?.addEventListener("mouseleave", () => {
        const checkedIndex = selectedStarIndex();
        highlightStars(checkedIndex >= 0 ? checkedIndex + 1 : 0);
    });

    const initialCheckedIndex = selectedStarIndex();
    if (initialCheckedIndex >= 0) {
        highlightStars(initialCheckedIndex + 1);
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
                resetReviewForm();
                showMessage(
                    "success",
                    response.message ||
                        "Thank you! Your review has been submitted and is pending approval.",
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
                    response.message || "Unable to submit your review. Please try again.",
                );
            },
            complete() {
                setSubmitting(false);
            },
        });
    });
})();