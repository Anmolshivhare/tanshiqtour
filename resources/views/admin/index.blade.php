@extends('admin.layouts.app')
@section('title')
    {{ __('labels.activity_logs') }}
@endsection
@section('content')
    <div class="gap-2 pb-2 mb-4 d-flex align-items-center">
        <h3 class="page-title">{{ __('labels.activity_logs') }}</h3>
    </div>
    <div class="col-md-12 divide-y-1 dashboard-card-main-col">
        <div class="row">
            <div class="col-12">
                <div class="card no-scale">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
