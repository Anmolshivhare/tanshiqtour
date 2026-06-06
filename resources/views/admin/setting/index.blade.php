@extends('admin.layouts.app')
@section('title') Site Settings @endsection
@section('content')
<div class="container-fluid">
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">Site Settings</h3>
    </div>
    @if (session('message'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- General --}}
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">General Settings</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Copyright Text</label>
                        <input type="text" name="copyright" class="form-control" value="{{ $settings['copyright'] ?? '' }}" placeholder="© 2025 TanshiqTour">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2">{{ $settings['address'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Social Media --}}
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Social Media Links</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control" value="{{ $settings['facebook_url'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-control" value="{{ $settings['instagram_url'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Twitter/X URL</label>
                        <input type="url" name="twitter_url" class="form-control" value="{{ $settings['twitter_url'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">YouTube URL</label>
                        <input type="url" name="youtube_url" class="form-control" value="{{ $settings['youtube_url'] ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" class="form-control" value="{{ $settings['whatsapp_number'] ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Logos --}}
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Logos & Branding</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Admin Sidebar Logo</label>
                        @if(!empty($settings['sidebar_logo_img']))
                            <div class="mb-2"><img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('sidebar_logo_img', config('constants.company_logo')) }}" height="50"></div>
                        @else
                            <div class="mb-2"><img src="{{ Vite::asset(config('constants.company_logo')) }}" height="50"></div>
                        @endif
                        <input type="file" name="sidebar_logo_img" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Header Logo</label>
                        @if(!empty($settings['header_logo']))
                            <div class="mb-2"><img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('header_logo', config('constants.company_logo')) }}" height="50"></div>
                        @else
                            <div class="mb-2"><img src="{{ Vite::asset(config('constants.company_logo')) }}" height="50"></div>
                        @endif
                        <input type="file" name="header_logo" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Footer Logo</label>
                        @if(!empty($settings['footer_logo']))
                            <div class="mb-2"><img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('footer_logo', config('constants.company_logo')) }}" height="50"></div>
                        @else
                            <div class="mb-2"><img src="{{ Vite::asset(config('constants.company_logo')) }}" height="50"></div>
                        @endif
                        <input type="file" name="footer_logo" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Favicon</label>
                        @if(!empty($settings['favicon']))
                            <div class="mb-2"><img src="{{ \App\Helpers\SiteSettingHelper::imageUrl('favicon', config('constants.company_logo_favicon')) }}" height="32"></div>
                        @else
                            <div class="mb-2"><img src="{{ Vite::asset(config('constants.company_logo_favicon')) }}" height="32"></div>
                        @endif
                        <input type="file" name="favicon" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary px-5">Save Settings</button>
        </div>
    </form>
</div>
@endsection
