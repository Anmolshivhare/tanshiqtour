@extends('admin.layouts.app')
@section('title')
    {{ __('labels.author') }}
@endsection
@section('content')
    <div class="d-flex gap-2 align-items-center mb-4 pb-2">
        <h1 class="mb-0 page-title"> {{ __('labels.show_page', ['action' => __('labels.author')]) }}</h1>
    </div>
    <div class="col-md-12 divide-y-1 dashboard-card-main-col show-table">
        <div class="row">
            <div class="col-12">
                <a href="{{ route('admin.authors.index') }}" class="btn btn-primary mb-3">
                    {{ __('buttons.back') }}
                </a>
                <div class="card no-scale retailer-table-main">
                    <table class="table table-striped retailer-table">
                        <tbody>
                            <tr>
                                <th class="table-head">{{ __('labels.id') }}</th>
                                <td>{{ $authorData->id }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.name') }}</th>
                                <td>{{ $authorData->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.email') }}</th>
                                <td>{{ $authorData->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.image') }}</th>
                                <td>
                                    @if(!empty($authorData->profile_image))
                                        <img src="{{ asset('storage/authors/' . $authorData->profile_image) }}" alt="Author Image" height="60">
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.description') }}</th>
                                <td>{{ $authorData->bio ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.status') }}</th>
                                <td>{{ $authorData->StatusName->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.created_by') }}</th>
                                <td>{{ $authorData->createdBy->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.updated_by') }}</th>
                                <td>{{ $authorData->updatedBy->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.created_at') }}</th>
                                <td>{{ $authorData->created_at }}</td>
                            </tr>
                            <tr>
                                <th class="table-head">{{ __('labels.updated_at') }}</th>
                                <td>{{ $authorData->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
