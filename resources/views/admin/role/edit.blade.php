@extends('admin.layouts.app')
@section('title')
    {{ __('labels.edit_page', ['action' => __('labels.role')]) }}
@endsection
@section('content')
    <div class="row role-page-main-section">
        <div class="col-12">
            <div class="flex-row-reverse gap-4 pb-2 mb-3 d-flex justify-content-end align-items-center">
                <h1 class="mb-0 page-title">{{ __('labels.edit_page', ['action' => __('labels.role')]) }}</h1>
            </div>
        </div>
        <div class="mt-4 col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                        <div class="mx-4 mt-3 mb-0 alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form class="" action="{{ route('admin.roles.update', $role->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label required">{{ __('labels.name') }}</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $role->name) }}" placeholder="{{ __('labels.name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div id="category-checkboxes" class="mt-4">
                                    @foreach ($permissions as $category)
                                        @if ($category->parent_id === null)
                                            <!-- Parent Category -->
                                            <div class="roles-area mb-0">
                                                <div class="form-check mt-4">
                                                    <input type="checkbox" class="form-check-input parent-checkbox"
                                                        id="parent-{{ $category->id }}" name="parents[]" value="{{ $category->id }}"
                                                        {{ in_array($category->id, $rolePermissionIds) ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-bold text-dark"
                                                        for="parent-{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>

                                                <!-- Child Categories -->
                                                <div class="child-categories row mt-3">
                                                    @foreach ($category->children as $child)
                                                        <div class="col-12 col-xl-3 col-lg-4 col-md-6 mb-3">
                                                            <div class="form-check role-child-checkbox position-relative p-0 rounded-2">
                                                                <label
                                                                    class="form-check-label py-2 px-2 d-block text-center cursor-pointer border border-1 border-secondary rounded-2"
                                                                    for="child-{{ $child->id }}">
                                                                    <input type="checkbox"
                                                                        class="form-check-input child-checkbox rounded-2"
                                                                        id="child-{{ $child->id }}" name="children[]"
                                                                        value="{{ $child->id }}" data-parent-id="{{ $category->id }}" {{ in_array($child->id, $rolePermissionIds) ? 'checked' : '' }}>
                                                                    <span class="rol-label-text">{{ $child->name }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mt-2 mt-sm-0">
                                        {{ __('labels.cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">{{ __('buttons.update') }}</button>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection