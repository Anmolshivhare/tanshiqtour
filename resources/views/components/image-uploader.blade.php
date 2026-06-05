@php
    $errorClass = $errors->has($name) ? 'is-invalid' : '';
    $errorMessage = $errors->first($name);
    $allowedTypesList = implode(',', $allowedTypes);
@endphp

<div class="image-uploader" id="{{ $id }}-wrapper" data-default-image="{{ $defaultImage ?? '' }}"
    data-preview-image="{{ $previewImage ?? '' }}" data-max-size="{{ $maxSize }}"
    data-allowed-types="{{ $allowedTypesList }}" data-enable-crop="{{ $enableCrop ? '1' : '0' }}"
    data-crop-aspect-ratio="{{ $cropAspectRatio ?? '' }}">
    @if (!empty($label))
        <label for="{{ $id }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif

    <div class="image-uploader__dropzone {{ $errorClass }}" data-role="dropzone" role="button" tabindex="0"
        aria-controls="{{ $id }}">
        <input type="file" id="{{ $id }}" name="{{ $name }}" class="d-none image-uploader__input"
            accept="{{ $accept }}" {{ $required ? 'required' : '' }}>

        <div class="image-uploader__preview-frame">
            <img src="{{ $previewImage ?: $defaultImage }}" alt="Preview image" class="image-uploader__preview"
                data-role="preview">
            <div class="image-uploader__loading d-none" data-role="loading">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span>Loading preview...</span>
            </div>
        </div>

        <div class="image-uploader__content">
            <i class="bi bi-cloud-arrow-up image-uploader__icon"></i>
            <p class="mb-1 fw-semibold">Drag and drop image here</p>
            <small class="text-muted">or click to browse (JPG, JPEG, PNG, WEBP up to {{ $maxSize }}MB)</small>
            <div class="image-uploader__meta mt-2 text-muted small">
                <span data-role="file-name">No file selected</span>
                <span class="mx-1">|</span>
                <span data-role="file-size">0 KB</span>
            </div>
        </div>
    </div>

    <div class="mt-2 d-flex justify-content-between align-items-center gap-2">
        <div class="invalid-feedback d-block image-uploader__error {{ empty($errorMessage) ? 'd-none' : '' }}"
            data-role="error">
            {{ $errorMessage }}
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm image-uploader__remove ms-auto" data-role="remove">
            Remove
        </button>
    </div>
</div>
