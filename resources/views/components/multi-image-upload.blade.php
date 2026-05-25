@php
    $errorMessage = $errors->first('gallery_images') ?: $errors->first('gallery_images.*');
    $allowedTypesList = implode(',', $allowedTypes);
@endphp

<div class="multi-image-uploader" id="{{ $id }}-wrapper" data-max-size="{{ $maxSize }}"
    data-max-files="{{ $maxFiles }}" data-allowed-types="{{ $allowedTypesList }}">
    @if (!empty($label))
        <label for="{{ $id }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif

    <div class="multi-image-uploader__dropzone" data-role="dropzone" role="button" tabindex="0">
        <input type="file" id="{{ $id }}" name="{{ $name }}" class="d-none multi-image-uploader__input"
            accept="{{ $accept }}" multiple {{ $required ? 'required' : '' }}>
        <div class="text-center">
            <i class="bi bi-images multi-image-uploader__icon"></i>
            <p class="mb-1 fw-semibold">Drag and drop images here</p>
            <small class="text-muted">or click to browse (max {{ $maxFiles }} images, {{ $maxSize }}MB each)</small>
        </div>
    </div>

    <div class="multi-image-uploader__loading d-none mt-2" data-role="loading">
        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
        <span>Rendering previews...</span>
    </div>

    <div class="invalid-feedback d-block multi-image-uploader__error mt-2 {{ empty($errorMessage) ? 'd-none' : '' }}"
        data-role="error">
        {{ $errorMessage }}
    </div>

    <div class="multi-image-uploader__meta mt-2 small text-muted" data-role="meta">
        0 image(s) selected
    </div>

    <div class="multi-image-uploader__grid mt-3" data-role="grid"></div>
</div>
