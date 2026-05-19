@extends('admin.layouts.app')
@section('title')
    {{ __('labels.view_page', ['action' => __('labels.tour')]) }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center justify-content-between">
            <h3 class="page-title">{{ __('labels.view_page', ['action' => __('labels.tour')]) }}</h3>
            <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> {{ __('labels.back') }}
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @if($tour->featured_image)
                        <div class="col-md-4 mb-4">
                            <img src="{{ asset('storage/' . config('constants.tour_image_path') . '/' . $tour->featured_image) }}"
                                alt="{{ $tour->title }}" class="img-fluid rounded">
                        </div>
                    @endif
                    <div class="col-md-{{ $tour->featured_image ? '8' : '12' }}">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="200">{{ __('labels.tour_title') }}</th>
                                    <td>{{ $tour->title }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.slug') }}</th>
                                    <td><code>{{ $tour->slug }}</code></td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.location') }}</th>
                                    <td>{{ $tour->location }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.duration') }}</th>
                                    <td>{{ $tour->duration }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.price_per_person') }}</th>
                                    <td class="text-success fw-bold">{{ $tour->formatted_price }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.status') }}</th>
                                    <td>
                                        @php
                                            $badgeClass = $tour->status?->name === config('constants.active_status_name')
                                                ? 'bg-success'
                                                : 'bg-secondary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $tour->status?->name ?? 'N/A' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.created_at') }}</th>
                                    <td>{{ $tour->created_at }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('labels.updated_at') }}</th>
                                    <td>{{ $tour->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($tour->description)
                    <div class="mt-4">
                        <h5>{{ __('labels.description') }}</h5>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($tour->description)) !!}
                        </div>
                    </div>
                @endif

                <div class="mt-4">
                    @can('tour-edit')
                        <a href="{{ route('admin.tours.edit', encrypt($tour->id)) }}" class="btn btn-primary">
                            <i class="fa-solid fa-edit me-1"></i> {{ __('labels.edit') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection