@extends('admin.layouts.app')
@section('title')
    {{ __('labels.create_page', ['action' => __('labels.user')]) }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h3 class="page-title">{{ __('labels.create_page', ['action' => __('labels.user')]) }}</h3>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="row g-3" action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <label for="name" class="form-label required">{{ __('labels.name') }}</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="{{ __('labels.name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label required">{{ __('labels.email') }}</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                            placeholder="{{ __('labels.email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone_no" class="form-label required">{{ __('labels.mobile_number') }}</label>
                        <input type="number" name="phone_no" id="phone_no"
                            class="form-control @error('phone_no') is-invalid @enderror" value="{{ old('phone_no') }}"
                            placeholder="{{ __('labels.mobile_number') }}">
                        @error('phone_no')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="date_of_birth" class="form-label">{{ __('labels.date_of_birth') }}</label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="form-control @error('date_of_birth') is-invalid @enderror"
                            value="{{ old('date_of_birth') }}" placeholder="{{ __('labels.date_of_birth') }}">
                        @error('date_of_birth')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label required">{{ __('labels.password') }}</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="{{ __('labels.password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="form-label required">{{ __('labels.role') }}</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">{{ __('labels.select') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="address" class="form-label">{{ __('labels.address') }}</label>
                        <textarea name="address" class="form-control" id="address" cols="10">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary mt-2 mt-sm-0">
                            {{ __('labels.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('buttons.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection