@extends('admin.layouts.app')
@section('title') Gallery Details @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">{{ $gallery->title }}</h3>
        <div class="ms-auto d-flex gap-2">
            @can('gallery-edit')
                <a href="{{ route('admin.galleries.edit', encrypt($gallery->id)) }}" class="btn btn-sm btn-warning">Edit</a>
            @endcan
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tr><th>Title</th><td>{{ $gallery->title }}</td></tr>
                        <tr><th>Type</th><td>{{ ucfirst($gallery->type ?? 'image') }}</td></tr>
                        <tr><th>Featured</th><td>{{ $gallery->is_featured ? 'Yes' : 'No' }}</td></tr>
                        {{-- <tr><th>Destination</th><td>{{ $gallery->destination->name ?? '—' }}</td></tr>
                        <tr><th>Tour</th><td>{{ $gallery->tour->title ?? '—' }}</td></tr> --}}
                        <tr><th>Status</th><td>{{ $gallery->statusName->name ?? '—' }}</td></tr>
                        <tr><th>Created At</th><td>{{ $gallery->created_at }}</td></tr>
                    </table>
                    @if($gallery->description)
                        <h5 class="mt-4 mb-2">Description</h5>
                        <p class="mb-0">{{ $gallery->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if(!empty($gallery->file_path))
                <div class="card mb-3">
                    <div class="card-header py-2">
                        <strong>Gallery Video</strong>
                    </div>
                    <div class="card-body">
                        <video class="w-100 rounded" controls preload="metadata"
                            @if(!empty($gallery->thumbnail_path)) poster="{{ asset('storage/gallery/thumbnails/' . $gallery->thumbnail_path) }}" @endif>
                            <source src="{{ asset('storage/gallery/' . $gallery->file_path) }}">
                        </video>
                    </div>
                </div>
            @endif

            @if(!empty($gallery->thumbnail_path))
                <div class="card">
                    <div class="card-header py-2">
                        <strong>Video Thumbnail</strong>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/gallery/thumbnails/' . $gallery->thumbnail_path) }}"
                            class="img-fluid rounded" alt="Video thumbnail">
                    </div>
                </div>
            @endif
        </div>

        @if($gallery->images->count())
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                        <strong>Gallery Images ({{ $gallery->images->count() }})</strong>
                        <small class="text-muted">Click an image to view full size</small>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($gallery->images as $index => $image)
                                <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                                    <button type="button"
                                        class="admin-gallery-image-view p-0 border rounded overflow-hidden bg-light w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#galleryImageModal"
                                        data-image-src="{{ asset('storage/gallery/' . $image->file_path) }}"
                                        data-image-index="{{ $index + 1 }}"
                                        data-image-total="{{ $gallery->images->count() }}"
                                        aria-label="View gallery image {{ $index + 1 }}">
                                        <img src="{{ asset('storage/gallery/' . $image->file_path) }}"
                                            alt="Gallery image {{ $index + 1 }}"
                                            class="w-100"
                                            style="height: 140px; object-fit: cover;">
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="alert alert-light border mb-0">No gallery images uploaded yet.</div>
            </div>
        @endif
    </div>
</div>

@if($gallery->images->count())
    <div class="modal fade" id="galleryImageModal" tabindex="-1" aria-labelledby="galleryImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="galleryImageModalLabel">
                        Gallery Image <span id="galleryImageCounter">1 / {{ $gallery->images->count() }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-dark text-center position-relative">
                    <button type="button" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y ms-2"
                        id="galleryImagePrev" aria-label="Previous image">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <img src="" alt="Gallery full view" id="galleryImagePreview" class="img-fluid" style="max-height: 75vh;">
                    <button type="button" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y me-2"
                        id="galleryImageNext" aria-label="Next image">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
@if($gallery->images->count())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('galleryImageModal');
        const preview = document.getElementById('galleryImagePreview');
        const counter = document.getElementById('galleryImageCounter');
        const prevBtn = document.getElementById('galleryImagePrev');
        const nextBtn = document.getElementById('galleryImageNext');
        const triggers = Array.from(document.querySelectorAll('.admin-gallery-image-view'));
        let currentIndex = 0;

        function showImage(index) {
            if (!triggers.length) {
                return;
            }

            currentIndex = (index + triggers.length) % triggers.length;
            const trigger = triggers[currentIndex];
            preview.src = trigger.dataset.imageSrc;
            counter.textContent = `${currentIndex + 1} / ${trigger.dataset.imageTotal}`;
        }

        triggers.forEach(function (trigger, index) {
            trigger.addEventListener('click', function () {
                showImage(index);
            });
        });

        prevBtn.addEventListener('click', function () {
            showImage(currentIndex - 1);
        });

        nextBtn.addEventListener('click', function () {
            showImage(currentIndex + 1);
        });

        modal.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowLeft') {
                showImage(currentIndex - 1);
            }
            if (event.key === 'ArrowRight') {
                showImage(currentIndex + 1);
            }
        });
    });
</script>
@endif
@endpush
