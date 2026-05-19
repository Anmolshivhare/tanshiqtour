@extends('front.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">My Profile</h2>
                            <p class="text-muted">Update your personal information</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('front.profile.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Profile Picture Section with Dropzone -->
                                <div class="col-md-4 text-center mb-4">
                                    <div class="d-inline-block">
                                        <!-- Dropzone Container -->
                                        <div class="profile-dropzone" id="profile-dropzone">
                                            @if($user->profile_pic)
                                                <img src="{{ Storage::url('profile_images/' . $user->profile_pic) }}"
                                                    alt="Profile Picture" class="dropzone-preview" id="profilePreview">
                                            @else
                                                <div class="dropzone-placeholder" id="profilePreviewDefault">
                                                    <i class="fa-solid fa-user"></i>
                                                </div>
                                                <img src="" alt="Profile Picture" class="dropzone-preview d-none"
                                                    id="profilePreview">
                                            @endif

                                            <!-- Camera Icon Overlay -->
                                            <div class="dropzone-overlay">
                                                <i class="fa-solid fa-camera"></i>
                                            </div>
                                        </div>

                                        <!-- Hidden file input -->
                                        <input type="file" class="d-none" id="profile_pic" name="profile_pic"
                                            accept="image/jpeg,image/png,image/jpg,image/webp">

                                        <!-- Hidden input for cropped image base64 data -->
                                        <input type="hidden" id="cropped_image" name="cropped_image">
                                    </div>

                                    <p class="text-muted small mt-2">Click the camera icon to change photo</p>

                                    <!-- Error message container -->
                                    <div id="image-error-message" class="image-error-message d-none"></div>

                                    @error('profile_pic')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @error('cropped_image')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Form Fields -->
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-semibold">Full Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-user text-muted"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $user->name) }}"
                                                placeholder="Enter your full name" required>
                                        </div>
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-envelope text-muted"></i>
                                            </span>
                                            <input type="email"
                                                class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', $user->email) }}"
                                                placeholder="Enter your email" required>
                                        </div>
                                        @error('email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fa-solid fa-phone text-muted"></i>
                                            </span>
                                            <input type="tel"
                                                class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror"
                                                id="phone" name="phone" value="{{ old('phone', $user->phone_no) }}"
                                                placeholder="Enter 10-digit phone number" maxlength="10" required>
                                        </div>
                                        @error('phone')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="address" class="form-label fw-semibold">Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 align-items-start pt-2">
                                                <i class="fa-solid fa-location-dot text-muted"></i>
                                            </span>
                                            <textarea
                                                class="form-control border-start-0 ps-0 @error('address') is-invalid @enderror"
                                                id="address" name="address" rows="3"
                                                placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
                                        </div>
                                        @error('address')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Back to Home
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg fw-bold text-white">
                                    <i class="fa-solid fa-save me-2 text-white"></i>Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Cropper Modal -->
    <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropperModalLabel">
                        <i class="fa-solid fa-crop me-2"></i>Crop Profile Image
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="cropper-container-wrapper">
                        <img id="cropper-image" src="" alt="Image to crop" style="display: block; max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" id="cancel-crop-btn">
                        <i class="fa-solid fa-times me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="crop-btn">
                        <i class="fa-solid fa-check me-1"></i>Crop & Save
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection