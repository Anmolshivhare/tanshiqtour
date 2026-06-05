@extends('admin.layouts.app')
@section('title')
    {{ __('labels.edit_page', ['action' => __('labels.Author')]) }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h1 class="mb-0 page-title"> {{ __('labels.edit_page', ['action' => __('labels.author')]) }}</h1>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="row g-3" action="{{ route('admin.authors.update', $authorData->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="name" class="form-label required">{{ __('labels.name') }}</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $authorData->name) }}" placeholder="{{ __('labels.name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">{{ __('labels.email') }}</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $authorData->email) }}" placeholder="{{ __('labels.email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="profile_image" class="form-label">{{ __('labels.image') }}</label>
                        @if(!empty($authorData->profile_image))
                            <div class="mb-2">
                                <img src="{{ asset('storage/authors/' . $authorData->profile_image) }}" alt="Author Image" height="60">
                            </div>
                        @endif
                        <input type="file" name="profile_image" id="profile_image" class="form-control @error('profile_image') is-invalid @enderror" accept="image/*">
                        @error('profile_image')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="bio" class="form-label">{{ __('labels.description') }}</label>
                        <textarea name="bio" id="bio" rows="4" class="form-control @error('bio') is-invalid @enderror" placeholder="Bio">{{ old('bio', $authorData->bio) }}</textarea>
                        @error('bio')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="status" class="form-label required">{{ __('labels.status') }}</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">{{ __('labels.select') }}</option>
                            @foreach($status as $id => $name)
                                <option value="{{ $id }}" {{ old('status', $authorData->OriginalStatus) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.authors.index') }}" class="btn btn-primary">
                            {{ __('labels.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
