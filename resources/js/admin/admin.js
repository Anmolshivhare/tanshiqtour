import "./bootstrap";
import "laravel-datatables-vite";
import "select2";
import Swal from "sweetalert2";
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

import {
    ClassicEditor,
    Essentials,
    Bold,
    Italic,
    Font,
    Paragraph,
    SourceEditing,
} from "ckeditor5";

// image  upload start
(($) => {
    class ImageUploader {
        constructor(element, options = {}) {
            this.$root = $(element);
            this.$input = this.$root.find(".image-uploader__input").first();
            this.$dropzone = this.$root.find('[data-role="dropzone"]').first();

            const resolvedPreviewSelector =
                options.preview && typeof options.preview === "string"
                    ? options.preview
                    : options.previewSelector;

            this.$preview = this.$root.find(resolvedPreviewSelector).first();
            if (!this.$preview.length && resolvedPreviewSelector) {
                this.$preview = $(resolvedPreviewSelector).first();
            }

            this.$error = this.$root.find(options.errorSelector).first();
            this.$remove = this.$root.find(options.removeSelector).first();
            this.$name = this.$root.find(options.fileNameSelector).first();
            this.$size = this.$root.find(options.fileSizeSelector).first();
            this.$loading = this.$root.find(options.loadingSelector).first();

            this.options = {
                ...options,
                maxSize: Number(this.$root.data("max-size")) || Number(options.maxSize),
                defaultImage: this.$root.data("default-image") || options.defaultImage || "",
                previewImage: this.$root.data("preview-image") || options.previewImage || "",
                allowedTypes: this.readAllowedTypes(options.allowedTypes) || options.allowedTypes,
                enableCrop: String(this.$root.data("enable-crop")) === "1",
                cropAspectRatio:
                    this.$root.data("crop-aspect-ratio") !== ""
                        ? Number(this.$root.data("crop-aspect-ratio"))
                        : null,
            };

            this.currentImage = this.options.previewImage || this.options.defaultImage;
            this.cropper = null;
            this.currentFile = null;
            this.ensureCropModal();
            this.bindEvents();
            this.resetMeta();
            this.setPreview(this.currentImage);
        }

        readAllowedTypes(fallback) {
            const attr = this.$root.data("allowed-types");
            if (!attr || typeof attr !== "string") return fallback;

            return attr
                .split(",")
                .map((type) => type.trim().toLowerCase())
                .filter(Boolean);
        }

        bindEvents() {
            this.$dropzone.on("click", (event) => {
                if ($(event.target).is(".image-uploader__input")) return;
                if ($(event.target).closest('[data-role="remove"]').length) return;
                this.$input[0].click();
            });

            this.$input.on("click", (event) => {
                event.stopPropagation();
            });

            this.$dropzone.on("keydown", (event) => {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    this.$input.trigger("click");
                }
            });

            this.$input.on("change", (event) => {
                const file = event.target.files?.[0];
                if (!file) {
                    this.clearError();
                    return;
                }
                this.handleFile(file);
            });

            this.$remove.on("click", (event) => {
                event.preventDefault();
                this.clear();
            });

            this.$dropzone.on("dragenter dragover", (event) => {
                event.preventDefault();
                event.stopPropagation();
                this.$dropzone.addClass("is-dragging");
            });

            this.$dropzone.on("dragleave dragend drop", (event) => {
                event.preventDefault();
                event.stopPropagation();
                this.$dropzone.removeClass("is-dragging");
            });

            this.$dropzone.on("drop", (event) => {
                const file = event.originalEvent?.dataTransfer?.files?.[0];
                if (!file) return;

                const dt = new DataTransfer();
                dt.items.add(file);
                this.$input[0].files = dt.files;
                this.$input.trigger("change");
            });
        }

        handleFile(file) {
            const validationError = this.validate(file);
            if (validationError) {
                this.showError(validationError);
                this.clearInput();
                return;
            }

            this.clearError();
            if (this.options.enableCrop) {
                this.openCropModal(file);
                return;
            }

            this.setLoading(true);
            const reader = new FileReader();
            reader.onload = (event) => {
                this.setPreview(event.target?.result || "");
                this.setMeta(file.name, this.formatBytes(file.size));
                this.setLoading(false);
            };
            reader.onerror = () => {
                this.showError("Unable to render preview. Please try another image.");
                this.setLoading(false);
            };
            reader.readAsDataURL(file);
        }

        ensureCropModal() {
            if ($("#imageUploaderCropModal").length) {
                this.$cropModal = $("#imageUploaderCropModal");
                return;
            }

            $("body").append(`
                <div class="image-uploader-crop-modal d-none" id="imageUploaderCropModal">
                    <div class="image-uploader-crop-modal__dialog">
                        <div class="image-uploader-crop-modal__header">
                            <h6 class="mb-0">Crop image</h6>
                        </div>
                        <div class="image-uploader-crop-modal__body">
                            <img src="" alt="Crop preview" id="imageUploaderCropTarget">
                        </div>
                        <div class="image-uploader-crop-modal__footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-action="cancel-crop">Cancel</button>
                            <button type="button" class="btn btn-primary btn-sm" data-action="apply-crop">Apply Crop</button>
                        </div>
                    </div>
                </div>
            `);
            this.$cropModal = $("#imageUploaderCropModal");
        }

        openCropModal(file) {
            this.currentFile = file;
            const imageUrl = URL.createObjectURL(file);
            const $target = this.$cropModal.find("#imageUploaderCropTarget");
            $target.attr("src", imageUrl);
            this.$cropModal.removeClass("d-none");

            if (this.cropper) {
                this.cropper.destroy();
            }

            const aspectRatio =
                this.options.cropAspectRatio && this.options.cropAspectRatio > 0
                    ? this.options.cropAspectRatio
                    : NaN;

            this.cropper = new Cropper($target[0], {
                aspectRatio,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
            });

            this.$cropModal
                .off("click.cropperActions")
                .on("click.cropperActions", '[data-action="cancel-crop"]', () => {
                    this.clearInput();
                    this.closeCropModal();
                })
                .on("click.cropperActions", '[data-action="apply-crop"]', () => {
                    this.applyCrop();
                });
        }

        closeCropModal() {
            this.$cropModal.addClass("d-none");
            if (this.cropper) {
                this.cropper.destroy();
                this.cropper = null;
            }
        }

        applyCrop() {
            if (!this.cropper || !this.currentFile) return;
            this.setLoading(true);

            const cropData = this.cropper.getData(true);
            const targetWidth = Math.max(1, Math.round(cropData.width || 1));
            const targetHeight = Math.max(1, Math.round(cropData.height || 1));

            const canvas = this.cropper.getCroppedCanvas({
                width: targetWidth,
                height: targetHeight,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: "high",
            });
            if (!canvas) {
                this.showError("Unable to crop selected image.");
                this.setLoading(false);
                this.closeCropModal();
                return;
            }

            canvas.toBlob((blob) => {
                if (!blob) {
                    this.showError("Unable to crop selected image.");
                    this.setLoading(false);
                    this.closeCropModal();
                    return;
                }

                const croppedFile = new File([blob], this.currentFile.name, {
                    type: this.currentFile.type,
                    lastModified: Date.now(),
                });

                const dt = new DataTransfer();
                dt.items.add(croppedFile);
                this.$input[0].files = dt.files;

                const reader = new FileReader();
                reader.onload = (event) => {
                    this.setPreview(event.target?.result || "");
                    this.setMeta(croppedFile.name, this.formatBytes(croppedFile.size));
                    this.clearError();
                    this.setLoading(false);
                };
                reader.onerror = () => {
                    this.showError("Unable to render preview. Please try another image.");
                    this.setLoading(false);
                };
                reader.readAsDataURL(croppedFile);

                this.closeCropModal();
            }, this.currentFile.type || "image/jpeg", 0.95);
        }

        validate(file) {
            const extension = file.name.split(".").pop()?.toLowerCase() || "";
            const allowed = (this.options.allowedTypes || []).map((type) => String(type).toLowerCase());

            if (!allowed.includes(extension)) {
                return `Allowed formats: ${allowed.join(", ").toUpperCase()}.`;
            }

            if (!file.type.startsWith("image/")) {
                return "Invalid image file.";
            }

            const maxBytes = Number(this.options.maxSize) * 1024 * 1024;
            if (file.size > maxBytes) {
                return `Image size must be ${this.options.maxSize}MB or less.`;
            }

            return "";
        }

        clear() {
            this.clearInput();
            this.clearError();
            this.resetMeta();
            this.currentImage = this.options.previewImage || this.options.defaultImage;
            this.setPreview(this.currentImage);
            this.$input.trigger("change");
        }

        clearInput() {
            this.$input.val("");
        }

        resetMeta() {
            this.setMeta("No file selected", "0 KB");
        }

        setMeta(name, size) {
            this.$name.text(name);
            this.$size.text(size);
        }

        setPreview(source) {
            this.$preview.attr("src", source || this.options.defaultImage || "");
        }

        setLoading(state) {
            this.$loading.toggleClass("d-none", !state);
        }

        showError(message) {
            this.$error.removeClass("d-none").text(message);
            this.$dropzone.addClass("is-invalid");
        }

        clearError() {
            this.$error.addClass("d-none").text("");
            this.$dropzone.removeClass("is-invalid");
        }

        formatBytes(bytes) {
            if (bytes === 0) return "0 KB";
            const k = 1024;
            const sizes = ["B", "KB", "MB", "GB"];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return `${parseFloat((bytes / Math.pow(k, i)).toFixed(2))} ${sizes[i]}`;
        }
    }

    $.fn.imageUploader = function (options = {}) {
        const defaults = {
            preview: null,
            previewImage: "",
            defaultImage: "",
            maxSize: 2,
            allowedTypes: ["jpg", "jpeg", "png", "webp"],
            previewSelector: '[data-role="preview"]',
            errorSelector: '[data-role="error"]',
            removeSelector: '[data-role="remove"]',
            fileNameSelector: '[data-role="file-name"]',
            fileSizeSelector: '[data-role="file-size"]',
            loadingSelector: '[data-role="loading"]',
        };

        return this.each(function initializeUploader() {
            const $el = $(this);
            const $root = $el.hasClass("image-uploader")
                ? $el
                : $el.closest(".image-uploader");

            if (!$root.length || $root.data("imageUploader")) return;

            const settings = { ...defaults, ...options };
            const instance = new ImageUploader($root[0], settings);
            $root.data("imageUploader", instance);
        });
    };
})(window.jQuery);

// image  upload end
$(function () {
    $(".image-uploader").imageUploader();
});

// video upload start
(($) => {
    class VideoUploader {
        constructor(element, options = {}) {
            this.$root = $(element);
            this.$input = this.$root.find(".video-uploader__input").first();
            this.$dropzone = this.$root.find('[data-role="dropzone"]').first();
            this.$preview = this.$root.find('[data-role="preview"]').first();
            this.$previewWrap = this.$root.find('[data-role="preview-wrap"]').first();
            this.$placeholder = this.$root.find('[data-role="placeholder"]').first();
            this.$error = this.$root.find('[data-role="error"]').first();
            this.$remove = this.$root.find('[data-role="remove"]').first();
            this.$name = this.$root.find('[data-role="file-name"]').first();
            this.$size = this.$root.find('[data-role="file-size"]').first();
            this.$loading = this.$root.find('[data-role="loading"]').first();

            this.options = {
                ...options,
                maxSize: Number(this.$root.data("max-size")) || Number(options.maxSize) || 20,
                allowedTypes: this.readAllowedTypes(options.allowedTypes) || options.allowedTypes || ["mp4", "mov", "jpg", "jpeg", "png", "webp"],
                previewVideo: this.$root.data("preview-video") || options.previewVideo || "",
                requiredType: this.$root.data("required-type") || options.requiredType || "",
                requiredState: String(this.$root.data("required-state")) === "1",
                typeSelector: options.typeSelector || "#gallery_type",
            };

            this.previewUrl = "";
            this.bindEvents();
            this.resetMeta();
            this.updateTypeVisibility();
            if (this.options.previewVideo) {
                this.setPreview(this.options.previewVideo, false);
                this.setMeta("Existing file", "--");
            }
        }

        readAllowedTypes(fallback) {
            const attr = this.$root.data("allowed-types");
            if (!attr || typeof attr !== "string") return fallback;
            return attr.split(",").map((type) => type.trim().toLowerCase()).filter(Boolean);
        }

        bindEvents() {
            this.$dropzone.on("click", (event) => {
                if ($(event.target).is(".video-uploader__input")) return;
                if ($(event.target).closest('[data-role="remove"]').length) return;
                this.$input[0].click();
            });

            this.$dropzone.on("keydown", (event) => {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    this.$input[0].click();
                }
            });

            this.$input.on("change", (event) => {
                const file = event.target.files?.[0];
                if (!file) return;
                this.handleFile(file);
            });

            this.$remove.on("click", (event) => {
                event.preventDefault();
                this.clear();
            });

            this.$dropzone.on("dragenter dragover", (event) => {
                event.preventDefault();
                event.stopPropagation();
                this.$dropzone.addClass("is-dragging");
            });

            this.$dropzone.on("dragleave dragend drop", (event) => {
                event.preventDefault();
                event.stopPropagation();
                this.$dropzone.removeClass("is-dragging");
            });

            this.$dropzone.on("drop", (event) => {
                const file = event.originalEvent?.dataTransfer?.files?.[0];
                if (!file) return;
                const dt = new DataTransfer();
                dt.items.add(file);
                this.$input[0].files = dt.files;
                this.$input.trigger("change");
            });

            const $typeEl = $(this.options.typeSelector);
            if ($typeEl.length) {
                $typeEl.on("change", () => this.updateTypeVisibility());
            }
        }

        updateTypeVisibility() {
            if (!this.options.requiredType) return;
            const selectedType = $(this.options.typeSelector).val();
            const shouldShow = selectedType === this.options.requiredType;
            this.$root.toggleClass("d-none", !shouldShow);
            this.$input.prop("required", shouldShow && this.options.requiredState);
            this.$input.prop("disabled", !shouldShow);
            if (!shouldShow) {
                this.clear(false);
            }
        }

        handleFile(file) {
            const validationError = this.validate(file);
            if (validationError) {
                this.showError(validationError);
                this.clearInput();
                return;
            }

            this.clearError();
            this.setLoading(true);
            this.setMeta(file.name, this.formatBytes(file.size));

            if (file.type.startsWith("video/")) {
                this.setPreview(URL.createObjectURL(file), true);
            } else {
                this.clearPreview();
                this.$placeholder
                    .removeClass("d-none")
                    .find("p")
                    .text("Preview available only for video files");
            }
            this.setLoading(false);
        }

        validate(file) {
            const extension = file.name.split(".").pop()?.toLowerCase() || "";
            const allowed = (this.options.allowedTypes || []).map((type) => String(type).toLowerCase());
            if (!allowed.includes(extension)) {
                return `Allowed formats: ${allowed.join(", ").toUpperCase()}.`;
            }

            const maxBytes = Number(this.options.maxSize) * 1024 * 1024;
            if (file.size > maxBytes) {
                return `File size must be ${this.options.maxSize}MB or less.`;
            }
            return "";
        }

        clear(clearInput = true) {
            if (clearInput) this.clearInput();
            this.clearError();
            this.resetMeta();
            this.clearPreview();
            this.$placeholder.removeClass("d-none").find("p").text("Video preview will appear here");
        }

        clearInput() {
            this.$input.val("");
        }

        clearPreview() {
            if (this.previewUrl) {
                URL.revokeObjectURL(this.previewUrl);
                this.previewUrl = "";
            }
            this.$preview.addClass("d-none").attr("src", "");
            this.$preview[0].load();
        }

        setPreview(source, revokable = false) {
            this.clearPreview();
            if (revokable) this.previewUrl = source;
            this.$preview.removeClass("d-none").attr("src", source);
            this.$preview[0].load();
            this.$placeholder.addClass("d-none");
        }

        resetMeta() {
            this.setMeta("No file selected", "0 KB");
        }

        setMeta(name, size) {
            this.$name.text(name);
            this.$size.text(size);
        }

        setLoading(state) {
            this.$loading.toggleClass("d-none", !state);
        }

        showError(message) {
            this.$error.removeClass("d-none").text(message);
            this.$dropzone.addClass("is-invalid");
        }

        clearError() {
            this.$error.addClass("d-none").text("");
            this.$dropzone.removeClass("is-invalid");
        }

        formatBytes(bytes) {
            if (bytes === 0) return "0 KB";
            const k = 1024;
            const sizes = ["B", "KB", "MB", "GB"];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return `${parseFloat((bytes / Math.pow(k, i)).toFixed(2))} ${sizes[i]}`;
        }
    }

    $.fn.videoUploader = function (options = {}) {
        return this.each(function initializeUploader() {
            const $root = $(this);
            if (!$root.length || $root.data("videoUploader")) return;
            const instance = new VideoUploader($root[0], options);
            $root.data("videoUploader", instance);
        });
    };
})(window.jQuery);

$(function () {
    $(".video-uploader").videoUploader();
});
// video upload end

// multi image upload start
(($) => {
    class MultiImageUploader {
        constructor(element, options = {}) {
            this.$root = $(element);
            this.$input = this.$root.find(".multi-image-uploader__input").first();
            this.$dropzone = this.$root.find('[data-role="dropzone"]').first();
            this.$error = this.$root.find('[data-role="error"]').first();
            this.$grid = this.$root.find('[data-role="grid"]').first();
            this.$meta = this.$root.find('[data-role="meta"]').first();
            this.$loading = this.$root.find('[data-role="loading"]').first();

            this.options = {
                ...options,
                maxSize: Number(this.$root.data("max-size")) || Number(options.maxSize) || 2,
                maxFiles: Number(this.$root.data("max-files")) || Number(options.maxFiles) || 10,
                allowedTypes: this.readAllowedTypes(options.allowedTypes) || options.allowedTypes || ["jpg", "jpeg", "png", "webp"],
            };

            this.files = [];
            this.bindEvents();
            this.renderMeta();
        }

        readAllowedTypes(fallback) {
            const attr = this.$root.data("allowed-types");
            if (!attr || typeof attr !== "string") return fallback;
            return attr.split(",").map((type) => type.trim().toLowerCase()).filter(Boolean);
        }

        bindEvents() {
            this.$dropzone.on("click", () => {
                this.$input[0].click();
            });

            this.$dropzone.on("keydown", (event) => {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    this.$input[0].click();
                }
            });

            this.$input.on("change", async (event) => {
                const selected = Array.from(event.target.files || []);
                await this.addFiles(selected);
            });

            this.$dropzone.on("dragenter dragover", (event) => {
                event.preventDefault();
                event.stopPropagation();
                this.$dropzone.addClass("is-dragging");
            });

            this.$dropzone.on("dragleave dragend drop", (event) => {
                event.preventDefault();
                event.stopPropagation();
                this.$dropzone.removeClass("is-dragging");
            });

            this.$dropzone.on("drop", async (event) => {
                const selected = Array.from(event.originalEvent?.dataTransfer?.files || []);
                await this.addFiles(selected);
            });

            this.$grid.on("click", '[data-action="remove"]', (event) => {
                const index = Number($(event.currentTarget).closest("[data-index]").data("index"));
                this.removeAt(index);
            });

            this.$grid.on("dragstart", ".multi-image-uploader__item", (event) => {
                const idx = Number($(event.currentTarget).data("index"));
                event.originalEvent.dataTransfer.setData("text/plain", String(idx));
                $(event.currentTarget).addClass("is-sorting");
            });

            this.$grid.on("dragend", ".multi-image-uploader__item", (event) => {
                $(event.currentTarget).removeClass("is-sorting");
            });

            this.$grid.on("dragover", ".multi-image-uploader__item", (event) => {
                event.preventDefault();
                $(event.currentTarget).addClass("is-over");
            });

            this.$grid.on("dragleave", ".multi-image-uploader__item", (event) => {
                $(event.currentTarget).removeClass("is-over");
            });

            this.$grid.on("drop", ".multi-image-uploader__item", (event) => {
                event.preventDefault();
                const from = Number(event.originalEvent.dataTransfer.getData("text/plain"));
                const to = Number($(event.currentTarget).data("index"));
                this.$grid.find(".multi-image-uploader__item").removeClass("is-over");
                this.reorder(from, to);
            });
        }

        async addFiles(newFiles) {
            if (!newFiles.length) return;
            this.clearError();

            if (this.files.length + newFiles.length > this.options.maxFiles) {
                this.showError(`You can upload a maximum of ${this.options.maxFiles} images.`);
                this.$input.val("");
                return;
            }

            this.setLoading(true);
            for (const file of newFiles) {
                const error = this.validate(file);
                if (error) {
                    this.showError(error);
                    continue;
                }

                const preview = await this.readFile(file);
                this.files.push({ file, preview });
            }
            this.setLoading(false);
            this.syncInput();
            this.renderGrid();
            this.renderMeta();
        }

        validate(file) {
            const extension = file.name.split(".").pop()?.toLowerCase() || "";
            const allowed = (this.options.allowedTypes || []).map((type) => String(type).toLowerCase());

            if (!allowed.includes(extension)) {
                return `Allowed formats: ${allowed.join(", ").toUpperCase()}.`;
            }
            if (!file.type.startsWith("image/")) {
                return "Invalid image file.";
            }
            const maxBytes = Number(this.options.maxSize) * 1024 * 1024;
            if (file.size > maxBytes) {
                return `Each image must be ${this.options.maxSize}MB or less.`;
            }
            return "";
        }

        readFile(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = (event) => resolve(event.target?.result || "");
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

        removeAt(index) {
            this.files.splice(index, 1);
            this.syncInput();
            this.renderGrid();
            this.renderMeta();
            this.clearError();
        }

        reorder(from, to) {
            if (Number.isNaN(from) || Number.isNaN(to) || from === to || from < 0 || to < 0) return;
            const moved = this.files.splice(from, 1)[0];
            this.files.splice(to, 0, moved);
            this.syncInput();
            this.renderGrid();
        }

        syncInput() {
            const dt = new DataTransfer();
            for (const entry of this.files) {
                dt.items.add(entry.file);
            }
            this.$input[0].files = dt.files;
            this.$input.trigger("change.multiUploaderSync");
        }

        renderGrid() {
            this.$grid.empty();
            this.files.forEach((entry, index) => {
                this.$grid.append(`
                    <div class="multi-image-uploader__item" data-index="${index}" draggable="true">
                        <img src="${entry.preview}" alt="${entry.file.name}" class="multi-image-uploader__thumb">
                        <div class="multi-image-uploader__item-bar">
                            <span class="multi-image-uploader__handle" title="Drag to reorder"><i class="bi bi-grip-vertical"></i></span>
                            <small class="text-truncate">${entry.file.name}</small>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-action="remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                `);
            });
        }

        renderMeta() {
            this.$meta.text(`${this.files.length} image(s) selected`);
        }

        setLoading(state) {
            this.$loading.toggleClass("d-none", !state);
        }

        showError(message) {
            this.$error.removeClass("d-none").text(message);
            this.$dropzone.addClass("is-invalid");
        }

        clearError() {
            this.$error.addClass("d-none").text("");
            this.$dropzone.removeClass("is-invalid");
        }
    }

    $.fn.multiImageUploader = function (options = {}) {
        return this.each(function initMultiUploader() {
            const $el = $(this);
            if ($el.data("multiImageUploader")) return;
            const instance = new MultiImageUploader(this, options);
            $el.data("multiImageUploader", instance);
        });
    };
})(window.jQuery);

// multi image upload end
$(function () {
    $(".multi-image-uploader").multiImageUploader();
});

$(function () {
    const $typeEl = $("#gallery_type");
    if (!$typeEl.length) return;

    const $thumbWrap = $("#thumbnail_wrap");
    const $thumbInput = $("#gallery_thumbnail_path");
    const $imageWrap = $("#image_file_wrap");
    const $imageInput = $("#gallery_image_file_path");
    const $videoWrap = $("#gallery_video_file_path-wrapper");
    const $videoInput = $("#gallery_video_file_path");
    const isEditForm = $typeEl.closest("form").find('input[name="_method"][value="PUT"]').length > 0;

    const updateByType = () => {
        const isVideo = $typeEl.val() === "video";
        $thumbWrap.toggleClass("d-none", !isVideo);
        $thumbInput.prop("disabled", !isVideo);
        $imageWrap.toggleClass("d-none", isVideo);
        $imageInput.prop("disabled", isVideo).prop("required", !isVideo);
        $videoWrap.toggleClass("d-none", !isVideo);
        $videoInput.prop("disabled", !isVideo).prop("required", isVideo && !isEditForm);
    };

    $typeEl.on("change", updateByType);
    updateByType();
});

//role and permission nestedtree
$(function () {
    // Parent checkbox change - toggle child checkboxes
    $(".parent-checkbox").on("change", function () {
        const parentId = $(this).val();
        $('input.child-checkbox[data-parent-id="' + parentId + '"]').prop(
            "checked",
            $(this).prop("checked"),
        );
        updateSelectAllStatus();
    });

    // "Select All" checkbox functionality
    $("#select-all").on("change", function () {
        $(".parent-checkbox, .child-checkbox").prop(
            "checked",
            $(this).prop("checked"),
        );
    });

    // Update "Select All" checkbox based on individual selections
    function updateSelectAllStatus() {
        $("#select-all").prop(
            "checked",
            $(".parent-checkbox, .child-checkbox").length ===
                $(".parent-checkbox, .child-checkbox:checked").length,
        );
    }

    // Child checkbox change - update parent checkbox and "Select All"
    $(".child-checkbox").on("change", function () {
        const parentId = $(this).data("parent-id");
        const parentCheckbox = $(
            'input.parent-checkbox[value="' + parentId + '"]',
        );
        parentCheckbox.prop(
            "checked",
            $('input.child-checkbox[data-parent-id="' + parentId + '"]:checked')
                .length > 0,
        );
        updateSelectAllStatus();
    });

    // category code when "Select All" is clicked
    $("#allCategory").on("change", function () {
        $(".category-item").prop("checked", this.checked);
    });

    // when any single category is clicked
    $(".category-item").on("change", function () {
        const total = $(".category-item").length;
        const checked = $(".category-item:checked").length;

        // check/uncheck "Select All"
        $("#allCategory").prop("checked", total === checked);
    });
});

// Password Icons js start ---
$(".password-toggle-group .toggle-password-btn").on("click", function () {
    const $group = $(this).closest(".password-toggle-group");
    const $input = $group.find("input");
    const $icon = $(this).find("i");

    if ($input.attr("type") === "password") {
        $input.attr("type", "text");
        $icon.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
    } else {
        $input.attr("type", "password");
        $icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
    }
});

// Menu js end ----
$(".hamburg-icon").click(function () {
    $(".sidebar-menus .accordion-item .show").removeClass("show");
    $(".sidebar").toggleClass("sidebar-close");
    $(".main-content").toggleClass("fullWidth-screen");
});

if ($(".editor").length) {
    document.querySelectorAll(".editor").forEach((editorElement) => {
        ClassicEditor.create(editorElement, {
            licenseKey: "GPL",
            plugins: [Essentials, Bold, Italic, Font, Paragraph, SourceEditing],
            toolbar: [
                "undo",
                "redo",
                "|",
                "bold",
                "italic",
                "|",
                "fontSize",
                "fontFamily",
                "fontColor",
                "fontBackgroundColor",
                "|",
                "sourceEditing",
            ],
        })
            .then((newEditor) => {
                // Optional: Store editor instance if needed
                window.editors = window.editors || [];
                window.editors.push(newEditor);
            })
            .catch((error) => console.error(error));
    });
}



/**Sweet alert on delete button
 * code start */
$(document).on("click", ".delete-btn", function (event) {
    event.preventDefault();
    const form = $(this).closest("form");
    const actionUrl = form.attr("action");
    Swal.fire({
        title: delete_modal_title,
        text: delete_modal_text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: confirm_button_modal,
        cancelButtonText: cancel,
        confirmButtonColor: "",
        cancelButtonColor: "",
        customClass: {
            title: "delete-modal-title",
            icon: "warning-icon mt-0",
            confirmButton:
                "confirm-button-class border-primary btn btn-primary px-4 fw-semibold",
            cancelButton:
                "cancel-button-class px-4 btn btn-secondary fw-semibold",
            popup: "rounded-3 py-8",
        },
        didRender: function () {
            $(".swal2-html-container").addClass("py-2");
        },
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: actionUrl,
                type: "POST",
                data: form.serialize(),
                success: function (response) {
                    if (response.status == "success") {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your item has been deleted.",
                            icon: "success",
                            confirmButtonText: "ok",

                            customClass: {
                                title: "delete-modal-title text-secondary mt-0",
                                popup: "rounded-3 py-8",
                                confirmButton:
                                    "confirm-button-ok confirm-button-class border-primary btn btn-primary px-8 fw-semibold",
                                icon: "warning-icon-delete-modal mt-0",
                            },
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                },
            });
        }
    });
});
// Sweet alert on delete button code end

$(document).on("change", ".review-status-toggle", function () {
    const $toggle = $(this);
    const $cell = $toggle.closest("td");
    const $label = $cell.find(".review-status-label");
    const previousState = !$toggle.is(":checked");
    const activeLabel = $toggle.data("active-label") || "Active";
    const inactiveLabel = $toggle.data("inactive-label") || "Inactive";
    const nextStatus = $toggle.is(":checked") ? 1 : 0;

    $toggle.prop("disabled", true);
    $label.text(nextStatus === 1 ? activeLabel : inactiveLabel);

    $.ajax({
        url: $toggle.data("url"),
        type: "PATCH",
        dataType: "json",
        data: {
            status: nextStatus,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success(response) {
            if (response.status !== "success") {
                throw new Error(response.message || "Unable to update status.");
            }

            const savedStatus = Number(response.data?.status ?? nextStatus);
            const savedLabel =
                response.data?.label || (savedStatus === 1 ? activeLabel : inactiveLabel);

            $toggle.prop("checked", savedStatus === 1);
            $label.text(savedLabel);

            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "success",
                title: response.message || "Review status updated successfully.",
                showConfirmButton: false,
                timer: 1800,
                timerProgressBar: true,
            });
        },
        error(xhr) {
            const message =
                xhr.responseJSON?.message ||
                "Unable to update review status. Please try again.";

            $toggle.prop("checked", previousState);
            $label.text(previousState ? activeLabel : inactiveLabel);

            Swal.fire({
                icon: "error",
                title: "Status not updated",
                text: message,
                confirmButtonText: "ok",
                customClass: {
                    title: "delete-modal-title text-secondary mt-0",
                    popup: "rounded-3 py-8",
                    confirmButton:
                        "confirm-button-ok confirm-button-class border-primary btn btn-primary px-8 fw-semibold",
                },
            });
        },
        complete() {
            $toggle.prop("disabled", false);
        },
    });
});

// ==========================================
// Generic Daterangepicker + DataTable Filter
// Reusable across any page with #filter-form, #apply-filter, #reset-filter, #daterange
// ==========================================
$(function () {
    // --- Daterangepicker setup (only if #daterange exists) ---
    if ($("#daterange").length > 0) {
        import("daterangepicker").then(() => {
            import("daterangepicker/daterangepicker.css");

            $("#daterange").daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: "Clear",
                    format: "YYYY-MM-DD",
                    separator: " to ",
                },
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [
                        moment().subtract(1, "days"),
                        moment().subtract(1, "days"),
                    ],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [
                        moment().startOf("month"),
                        moment().endOf("month"),
                    ],
                    "Last Month": [
                        moment().subtract(1, "month").startOf("month"),
                        moment().subtract(1, "month").endOf("month"),
                    ],
                },
            });

            $("#daterange").on("apply.daterangepicker", function (ev, picker) {
                $(this).val(
                    picker.startDate.format("YYYY-MM-DD") +
                        " to " +
                        picker.endDate.format("YYYY-MM-DD"),
                );
            });

            $("#daterange").on("cancel.daterangepicker", function (ev, picker) {
                $(this).val("");
            });
        });
    }

    // --- Generic DataTable filter (auto-detects the table) ---
    if ($("#filter-form").length === 0) return;

    // Find the first DataTable instance on the page
    let dataTable = null;
    let tableKeys = Object.keys(window.LaravelDataTables || {});
    if (tableKeys.length > 0) {
        dataTable = window.LaravelDataTables[tableKeys[0]];
    }

    if (!dataTable) return;

    // Collect all filter values from #filter-form by their name attribute
    function getFilters() {
        let filters = {};
        $("#filter-form")
            .find("select, input")
            .each(function () {
                let name = $(this).attr("name");
                let value = $(this).val();
                if (name && value) {
                    filters[name] = value;
                }
            });
        return filters;
    }

    // Attach filter data to every DataTable AJAX request
    dataTable.on("preXhr.dt", function (e, settings, data) {
        data.filters = getFilters();
    });

    // Apply filters
    $("#apply-filter").on("click", function () {
        dataTable.ajax.reload();
    });

    // Reset filters
    $("#reset-filter").on("click", function () {
        $("#filter-form")[0].reset();
        $("#daterange").val("");
        dataTable.ajax.reload();
    });

});


// Generic slug auto-generation
$(function () {
    const toSlug = (value) =>
        value
            .toString()
            .trim()
            .toLowerCase()
            .replace(/[^\w\s-]+/g, "")
            .replace(/\s+/g, "-")
            .replace(/-+/g, "-");

    if (!$(".makeSlug").length || !$(".pageSlug").length) return;

    $(".makeSlug").on("input blur", function () {
        $(".pageSlug").val(toSlug($(this).val() || ""));
    });

    if (!$(".pageSlug").val() && $(".makeSlug").val()) {
        $(".pageSlug").val(toSlug($(".makeSlug").val()));
    }
});

// Tour itinerary add/remove days
$(function () {
    const $container = $("#itinerary-container");
    const $addBtn = $("#add-day-btn");
    if (!$container.length || !$addBtn.length) return;

    const dayCardTemplate = (index, dayNumber) => `
        <div class="itinerary-day card mb-3 p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Day ${dayNumber}</h6>
                <button type="button" class="btn btn-outline-danger btn-sm remove-day-btn">Remove</button>
            </div>
            <input type="hidden" name="itinerary[${index}][day_number]" value="${dayNumber}">
            <div class="row g-2">
                <div class="col-md-6"><input type="text" name="itinerary[${index}][title]" class="form-control" placeholder="Day title"></div>
                <div class="col-md-6"><input type="text" name="itinerary[${index}][accommodation]" class="form-control" placeholder="Accommodation"></div>
                <div class="col-md-6"><input type="text" name="itinerary[${index}][meals_included]" class="form-control" placeholder="Meals (B/L/D)"></div>
                <div class="col-12"><textarea name="itinerary[${index}][description]" class="form-control" rows="2" placeholder="Day description"></textarea></div>
            </div>
        </div>`;

    function ensureRemoveButtons() {
        $container.find(".itinerary-day").each(function () {
            const $card = $(this);
            const $heading = $card.find("h6").first();
            if (!$card.find(".remove-day-btn").length) {
                if (!$heading.parent().hasClass("d-flex")) {
                    $heading.wrap('<div class="d-flex justify-content-between align-items-center mb-2"></div>');
                }
                $heading.after('<button type="button" class="btn btn-outline-danger btn-sm remove-day-btn">Remove</button>');
            }
        });
    }

    function reindexDays() {
        $container.find(".itinerary-day").each(function (index) {
            const dayNumber = index + 1;
            const $card = $(this);
            $card.find("h6").first().text(`Day ${dayNumber}`);

            $card.find("input, textarea, select").each(function () {
                const $field = $(this);
                const fieldName = $field.attr("name");
                if (!fieldName) return;
                $field.attr("name", fieldName.replace(/itinerary\[\d+\]/, `itinerary[${index}]`));
            });

            const $dayNumberField = $card.find('input[name^="itinerary["][name$="[day_number]"]').first();
            if ($dayNumberField.length) {
                $dayNumberField.val(dayNumber);
            }
        });
    }

    ensureRemoveButtons();
    reindexDays();

    $addBtn.on("click", function () {
        const dayNumber = $container.find(".itinerary-day").length + 1;
        const index = dayNumber - 1;
        $container.append(dayCardTemplate(index, dayNumber));
    });

    $container.on("click", ".remove-day-btn", function () {
        $(this).closest(".itinerary-day").remove();
        reindexDays();
    });

    $container.closest("form").on("submit", function () {
        reindexDays();
    });
});

// Tour highlights add/remove rows
$(function () {
    const $container = $("#highlights-container");
    const $addBtn = $("#add-highlight-btn");
    if (!$container.length || !$addBtn.length) return;

    const highlightTemplate = () => `
        <div class="tour-highlight-row input-group mb-2">
            <span class="input-group-text"><i class="fas fa-check text-success"></i></span>
            <input type="text" name="highlights[]" class="form-control" placeholder="Highlight text">
            <button type="button" class="btn btn-outline-danger remove-highlight-btn">Remove</button>
        </div>`;

    $addBtn.on("click", function () {
        $container.append(highlightTemplate());
    });

    $container.on("click", ".remove-highlight-btn", function () {
        if ($container.find(".tour-highlight-row").length === 1) {
            $(this).closest(".tour-highlight-row").find("input").val("");
            return;
        }

        $(this).closest(".tour-highlight-row").remove();
    });
});

// Tour amenities add/remove rows
$(function () {
    const $container = $("#amenities-container");
    const $addBtn = $("#add-amenity-btn");
    if (!$container.length || !$addBtn.length) return;

    const amenityTemplate = (index) => `
        <div class="tour-amenity-row row g-2 align-items-center mb-2">
            <div class="col-md-8">
                <input type="text" name="amenities[${index}][label]" class="form-control" placeholder="Amenity label">
            </div>
            <div class="col-md-2">
                <input type="hidden" name="amenities[${index}][available]" value="0">
                <div class="form-check">
                    <input type="checkbox" name="amenities[${index}][available]" value="1" class="form-check-input" id="amenity-available-${index}" checked>
                    <label class="form-check-label" for="amenity-available-${index}">Available</label>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100 remove-amenity-btn">Remove</button>
            </div>
        </div>`;

    function reindexAmenities() {
        $container.find(".tour-amenity-row").each(function (index) {
            const $row = $(this);
            const checkboxId = `amenity-available-${index}`;

            $row.find("input").each(function () {
                const $field = $(this);
                const fieldName = $field.attr("name");
                if (!fieldName) return;
                $field.attr("name", fieldName.replace(/amenities\[\d+\]/, `amenities[${index}]`));
            });

            $row.find('input[type="checkbox"]').attr("id", checkboxId);
            $row.find("label").attr("for", checkboxId);
        });
    }

    reindexAmenities();

    $addBtn.on("click", function () {
        $container.append(amenityTemplate($container.find(".tour-amenity-row").length));
        reindexAmenities();
    });

    $container.on("click", ".remove-amenity-btn", function () {
        if ($container.find(".tour-amenity-row").length === 1) {
            const $row = $(this).closest(".tour-amenity-row");
            $row.find('input[type="text"]').val("");
            $row.find('input[type="checkbox"]').prop("checked", true);
            return;
        }

        $(this).closest(".tour-amenity-row").remove();
        reindexAmenities();
    });

    $container.closest("form").on("submit", function () {
        reindexAmenities();
    });
});

// Admin gallery show — image lightbox modal
$(function () {
    const modal = document.getElementById("galleryImageModal");
    const preview = document.getElementById("galleryImagePreview");
    const counter = document.getElementById("galleryImageCounter");
    const prevBtn = document.getElementById("galleryImagePrev");
    const nextBtn = document.getElementById("galleryImageNext");
    const triggers = Array.from(document.querySelectorAll(".admin-gallery-image-view"));

    if (!modal || !preview || !counter || !prevBtn || !nextBtn || !triggers.length) {
        return;
    }

    let currentIndex = 0;

    function showImage(index) {
        currentIndex = (index + triggers.length) % triggers.length;
        const trigger = triggers[currentIndex];
        preview.src = trigger.dataset.imageSrc;
        counter.textContent = `${currentIndex + 1} / ${trigger.dataset.imageTotal}`;
    }

    triggers.forEach(function (trigger, index) {
        trigger.addEventListener("click", function () {
            showImage(index);
        });
    });

    prevBtn.addEventListener("click", function () {
        showImage(currentIndex - 1);
    });

    nextBtn.addEventListener("click", function () {
        showImage(currentIndex + 1);
    });

    modal.addEventListener("keydown", function (event) {
        if (event.key === "ArrowLeft") {
            showImage(currentIndex - 1);
        }
        if (event.key === "ArrowRight") {
            showImage(currentIndex + 1);
        }
    });
});
