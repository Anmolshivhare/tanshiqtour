@extends('admin.layouts.app')
@section('title')
    {{ __('labels.general_setting') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h1 class="mb-0 page-title"> {{ __('labels.general_setting') }}</h1>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('message'))
                    <div class="mx-4 mt-3 mb-0 alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="row g-3 mt-4" action="{{ route('admin.settings.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <label for="sidebar_logo_img" class="form-label">{{ __('labels.sidebar_logo_img') }}</label>
                        <input type="file" name="sidebar_logo_img" id="sidebar_logo_img"
                            class="form-control @error('sidebar_logo_img') is-invalid @enderror">
                        @error('sidebar_logo_img')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                        @if (!empty($settingData->sidebar_logo_img))
                            <a href="{{ asset('storage/setting_images/' . $settingData['sidebar_logo_img']) }}" target="_blank">
                                <img src="{{ asset('storage/setting_images/' . $settingData['sidebar_logo_img']) }}"
                                    style="width:70px;height:70px;border: 1px solid black; cursor: pointer;"
                                    class="rounded-circle mt-2" alt="sidebar logo">
                            </a>
                        @else
                            <img src="{{ Vite::asset(config('constants.default_image')) }}"
                                style="width:70px;height:70px;border: 1px solid black;" class="rounded-circle mt-2"
                                alt="default-image">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="header_logo_img" class="form-label">{{ __('labels.header_logo_img') }}</label>
                        <input type="file" name="header_logo_img" id="header_logo_img"
                            class="form-control @error('header_logo_img') is-invalid @enderror">
                        @error('header_logo_img')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                        @if (!empty($settingData->header_logo_img))
                            <a href="{{ asset('storage/setting_images/' . $settingData['header_logo_img']) }}" target="_blank">
                                <img src="{{ asset('storage/setting_images/' . $settingData['header_logo_img']) }}"
                                    style="width:70px;height:70px;border: 1px solid black; cursor: pointer;"
                                    class="rounded-circle mt-2" alt="header logo">
                            </a>
                        @else
                            <img src="{{ Vite::asset(config('constants.default_image')) }}"
                                style="width:70px;height:70px;border: 1px solid black;" class="rounded-circle mt-2"
                                alt="default-image">
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="admin_panel_logo_img" class="form-label">{{ __('labels.admin_panel_logo_img') }}</label>
                        <input type="file" name="admin_panel_logo_img" id="admin_panel_logo_img"
                            class="form-control @error('admin_panel_logo_img') is-invalid @enderror">
                        @error('admin_panel_logo_img')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                        @if (!empty($settingData->admin_panel_logo_img))
                            <a href="{{ asset('storage/setting_images/' . $settingData['admin_panel_logo_img']) }}"
                                target="_blank">
                                <img src="{{ asset('storage/setting_images/' . $settingData['admin_panel_logo_img']) }}"
                                    style="width:70px;height:70px;border: 1px solid black; cursor: pointer;"
                                    class="rounded-circle mt-2" alt="header logo">
                            </a>
                        @else
                            <img src="{{ Vite::asset(config('constants.default_image')) }}"
                                style="width:70px;height:70px;border: 1px solid black;" class="rounded-circle mt-2"
                                alt="default-image">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="header_banner_img" class="form-label">{{ __('labels.header_banner_img') }}</label>
                        <input type="file" name="header_banner_img" id="header_banner_img"
                            class="form-control @error('header_banner_img') is-invalid @enderror">
                        @error('header_banner_img')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                        @if (!empty($settingData->header_banner_img))
                            <a href="{{ asset('storage/setting_images/' . $settingData['header_banner_img']) }}"
                                target="_blank">
                                <img src="{{ asset('storage/setting_images/' . $settingData['header_banner_img']) }}"
                                    style="width:70px;height:70px;border: 1px solid black; cursor: pointer;"
                                    class="rounded-circle mt-2" alt="header logo">
                            </a>
                        @else
                            <img src="{{ Vite::asset(config('constants.default_image')) }}"
                                style="width:70px;height:70px;border: 1px solid black;" class="rounded-circle mt-2"
                                alt="default-image">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label for="facebook_url" class="form-label">{{ __('labels.facebook_url') }}</label>
                        <input type="text" name="facebook_url" id="facebook_url"
                            class="form-control @error('facebook_url') is-invalid @enderror"
                            value="{{ old('facebook_url', $settingData['facebook_url'] ?? '') }}"
                            placeholder="{{ __('labels.facebook_url') }}">
                        @error('facebook_url')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="instagram_url" class="form-label">{{ __('labels.instagram_url') }}</label>
                        <input type="text" name="instagram_url" id="instagram_url"
                            class="form-control @error('instagram_url') is-invalid @enderror"
                            value="{{ old('instagram_url', $settingData['instagram_url'] ?? '') }}"
                            placeholder="{{ __('labels.instagram_url') }}">
                        @error('instagram_url')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="youtube_url" class="form-label">{{ __('labels.youtube_url') }}</label>
                        <input type="text" name="youtube_url" id="youtube_url"
                            class="form-control @error('youtube_url') is-invalid @enderror"
                            value="{{ old('youtube_url', $settingData['youtube_url'] ?? '') }}"
                            placeholder="{{ __('labels.youtube_url') }}">
                        @error('youtube_url')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="google_play_url" class="form-label">{{ __('labels.google_play_url') }}</label>
                        <input type="text" name="google_play_url" id="google_play_url"
                            class="form-control @error('google_play_url') is-invalid @enderror"
                            value="{{ old('google_play_url', $settingData['google_play_url'] ?? '') }}"
                            placeholder="{{ __('labels.google_play_url') }}">
                        @error('google_play_url')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="app_store_url" class="form-label">{{ __('labels.app_store_url') }}</label>
                        <input type="text" name="app_store_url" id="app_store_url"
                            class="form-control @error('app_store_url') is-invalid @enderror"
                            value="{{ old('app_store_url', $settingData['app_store_url'] ?? '') }}"
                            placeholder="{{ __('labels.app_store_url') }}">
                        @error('app_store_url')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="live_streaming_url" class="form-label">{{ __('labels.live_streaming_url') }}</label>
                        <input type="text" name="live_streaming_url" id="live_streaming_url"
                            class="form-control @error('live_streaming_url') is-invalid @enderror"
                            value="{{ old('live_streaming_url', $settingData['live_streaming_url'] ?? '') }}"
                            placeholder="{{ __('labels.live_streaming_url') }}">
                        @error('live_streaming_url')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="twitter_url" class="form-label">{{ __('labels.twitter_url') }}</label>
                        <input type="text" name="twitter_url" id="twitter_url"
                            class="form-control @error('twitter_url') is-invalid @enderror"
                            value="{{ old('twitter_url', $settingData['twitter_url'] ?? '') }}"
                            placeholder="{{ __('labels.twitter_url') }}">
                        @error('twitter_url')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="footer_copyright_text"
                            class="form-label">{{ __('labels.footer_copyright_text') }}</label>
                        <input type="text" name="footer_copyright_text" id="footer_copyright_text"
                            class="form-control @error('footer_copyright_text') is-invalid @enderror"
                            value="{{ old('footer_copyright_text', $settingData['footer_copyright_text'] ?? '') }}"
                            placeholder="{{ __('labels.footer_copyright_text') }}">
                        @error('footer_copyright_text')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="hidden" value="{{ config('constants.company_name') }}" name="company_name">

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection