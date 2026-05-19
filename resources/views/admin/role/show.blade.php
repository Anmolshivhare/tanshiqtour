@extends('admin.layouts.app')
@section('title')
    {{ __('labels.role') }}
@endsection
@section('content')
    <div class="d-flex gap-2 align-items-center mb-4 pb-2">
        <h3 class="page-title">{{ __('labels.role') }}</h3>
    </div>
    <div class="col-md-12 divide-y-1 dashboard-card-main-col show-table">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-primary mb-3">
                    {{ __('buttons.back') }}
                </a>
                <div class="card no-scale retailer-table-main">
                    <table class="table table-striped retailer-table">
                        <tbody>
                            <tr>
                                <th class="table-head">{{ __('labels.id') }}</th>
                                <td>{{ $role->id }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.name') }}</th>
                                <td>{{ $role->name }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.created_at') }}</th>
                                <td>{{ $role->created_at }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.updated_at') }}</th>
                                <td>{{ $role->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
