@php
    $errorClass = $errors->has($name) ? 'is-invalid' : '';
    $errorMessage = $errors->first($name);
    $allowedTypesList = implode(',', $allowedTypes);
    $isRequiredType = !empty($requiredType) && old('type', $requiredType) === $requiredType;
@endphp

<div class="video-uploader {{ !empty($requiredType) && old('type') && old('type') !== $requiredType ? 'd-none' : '' }}"
    id="{{ $id }}-wrapper" data-preview-video="{{ $previewVideo ?? '' }}" data-max-size="{{ $maxSize }}"
    data-allowed-types="{{ $allowedTypesList }}" data-required-type="{{ $requiredType ?? '' }}"
    data-required-state="{{ $isRequiredType ? '1' : '0' }}">
    @if (!empty($label))
        <label for="{{ $id }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif

    <div class="video-uploader__dropzone {{ $errorClass }}" data-role="dropzone" role="button" tabindex="0"
        aria-controls="{{ $id }}">
        <input type="file" id="{{ $id }}" name="{{ $name }}" class="d-none video-uploader__input"
            accept="{{ $accept }}" {{ $required && $isRequiredType ? 'required' : '' }}>

        <div class="video-uploader__preview-frame" data-role="preview-wrap">
            <video class="video-uploader__preview {{ empty($previewVideo) ? 'd-none' : '' }}" data-role="preview" controls>
                @if (!empty($previewVideo))
                    <source src="{{ $previewVideo }}">
                @endif
            </video>
            <div class="video-uploader__placeholder {{ empty($previewVideo) ? '' : 'd-none' }}" data-role="placeholder">
                <i class="bi bi-play-circle video-uploader__icon"></i>
                <p class="mb-1 fw-semibold">Video preview will appear here</p>
            </div>
            <div class="video-uploader__loading d-none" data-role="loading">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span>Loading preview...</span>
            </div>
        </div>

        <div class="video-uploader__content">
            <i class="bi bi-camera-reels video-uploader__upload-icon"></i>
            <p class="mb-1 fw-semibold">Drag and drop file here</p>
            <small class="text-muted">or click to browse (MP4, MOV and gallery formats up to {{ $maxSize }}MB)</small>
            <div class="video-uploader__meta mt-2 text-muted small">
                <span data-role="file-name">No file selected</span>
                <span class="mx-1">|</span>
                <span data-role="file-size">0 KB</span>
            </div>
        </div>
    </div>

    <div class="mt-2 d-flex justify-content-between align-items-center gap-2">
        <div class="invalid-feedback d-block video-uploader__error {{ empty($errorMessage) ? 'd-none' : '' }}"
            data-role="error">
            {{ $errorMessage }}
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm video-uploader__remove ms-auto" data-role="remove">
            Remove
        </button>
    </div>
</div>

