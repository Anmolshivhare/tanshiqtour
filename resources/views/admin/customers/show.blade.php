@extends('admin.layouts.app')
@section('title')
    {{ __('labels.customer') }}
@endsection
@section('content')
    <div class="d-flex gap-2 align-items-center mb-4 pb-2">
        <h3 class="page-title">{{ __('labels.customer') }} Details</h3>
    </div>
    <div class="col-md-12 divide-y-1 dashboard-card-main-col show-table">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('admin.customers.index') }}" class="btn btn-primary mb-3">
                    {{ __('buttons.back') }}
                </a>
                <div class="card no-scale">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center mb-4">
                                @if($customer->profile_pic)
                                    <img src="{{ Storage::url('profile_images/' . $customer->profile_pic) }}" 
                                        alt="Profile Picture" 
                                        class="rounded-circle img-thumbnail shadow"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center shadow mx-auto"
                                        style="width: 150px; height: 150px;">
                                        <span class="text-white fs-1 fw-bold">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <h4 class="mt-3 mb-0">{{ $customer->name }}</h4>
                                <span class="badge bg-success">Customer</span>
                            </div>
                            <div class="col-md-9">
                                <table class="table table-striped retailer-table">
                                    <tbody>
                                        <tr>
                                            <th class="table-head" width="200">{{ __('labels.id') }}</th>
                                            <td>{{ $customer->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="table-head">{{ __('labels.name') }}</th>
                                            <td>{{ $customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="table-head">{{ __('labels.email') }}</th>
                                            <td>{{ $customer->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="table-head">{{ __('labels.phone_number') }}</th>
                                            <td>{{ $customer->phone_no ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="table-head">{{ __('labels.address') }}</th>
                                            <td>{{ $customer->address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="table-head">{{ __('labels.status') }}</th>
                                            <td>
                                                @if($customer->StatusName)
                                                    <span class="badge {{ $customer->StatusName->name == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $customer->StatusName->name }}
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-head">{{ __('labels.created_at') }}</th>
                                            <td>{{ $customer->created_at ? $customer->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="table-head">{{ __('labels.updated_at') }}</th>
                                            <td>{{ $customer->updated_at ? $customer->updated_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
