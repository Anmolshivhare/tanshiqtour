@extends('admin.layouts.app')
@section('title')
    {{ __('labels.tours') }}
@endsection
@section('content')
    @can('tour-list')
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center justify-content-between">
            <h3 class="page-title">{{ __('labels.tours') }}</h3>
            @can('tour-create')
                <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-1"></i> {{ __('labels.add_new') }}
                </a>
            @endcan
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="filter-form" class="row g-3">
                    <div class="col-md-3">
                        <label for="title" class="form-label">{{ __('labels.title') }}</label>
                        <select name="title" id="title" class="form-select">
                            <option value="">All Tours</option>
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="location" class="form-label">{{ __('labels.location') }}</label>
                        <select name="location" id="location" class="form-select">
                            <option value="">All Location</option>
                            @foreach($tours as $tour)
                                <option value="{{ $tour->location }}">{{ $tour->location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="date_to" class="form-label">{{ __('labels.date_to') }}</label>

                        <input type="text" class="form-control form-select" name="created_at" id="daterange"
                            placeholder="Select Date range" autocomplete="off">
                    </div>



                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" id="apply-filter" class="btn btn-primary me-2">
                            <i class="fa-solid fa-filter"></i> Filter
                        </button>
                        <button type="button" id="reset-filter" class="btn btn-secondary">
                            <i class="fa-solid fa-times"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 divide-y-1 dashboard-card-main-col">
            <div class="row">
                <div class="col-12">
                    <div class="card no-scale">
                        @if (session('message'))
                            <div class="mx-4 mt-3 mb-0 alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush