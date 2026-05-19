@extends('admin.layouts.app')
@section('title')
    {{ __('labels.user') }}
@endsection
@section('content')
    <div class="d-flex gap-2 align-items-center mb-4 pb-2">
        <h3 class="page-title">{{ __('labels.user') }}</h3>
    </div>
    <div class="col-md-12 divide-y-1 dashboard-card-main-col show-table">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary mb-3">
                    {{ __('buttons.back') }}
                </a>
                <div class="card no-scale retailer-table-main">
                    <table class="table table-striped retailer-table">
                        <tbody>
                            <tr>
                                <th class="table-head">{{ __('labels.id') }}</th>
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.name') }}</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.status') }}</th>
                                <td>{{ $user->StatusName->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.created_at') }}</th>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.updated_at') }}</th>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
