@extends('admin.layouts.app')
@section('title')
    {{ __('labels.edit_page', ['action' => __('labels.permission')]) }}
@endsection
@section('content')
    <div class="px-4 container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
            <h3 class="page-title"> {{ __('labels.edit_page', ['action' => __('labels.permission')]) }}</h3>
        </div>
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="row g-3" action="{{ route('admin.permissions.update', $permission->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <label for="name" class="form-label required">{{ __('labels.name') }}</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $permission->name ?? '') }}" placeholder="{{ __('labels.name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary">
                            {{ __('labels.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection