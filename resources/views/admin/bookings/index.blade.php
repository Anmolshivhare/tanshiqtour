@extends('admin.layouts.app')
@section('title')
    {{ __('labels.bookings') }}
@endsection
@section('content')
    @can('booking-list')
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center justify-content-between">
            <h3 class="page-title">{{ __('labels.bookings') }}</h3>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form id="filter-form" class="row g-3">
                    <div class="col-md-3">
                        <label for="tour_filter" class="form-label">{{ __('labels.tour') }}</label>
                        <select name="tour_id" id="tour_filter" class="form-select">
                            <option value="">All Tours</option>
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}">{{ $tour->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status_filter" class="form-label">{{ __('labels.booking_status') }}</label>
                        <select name="booking_status_id" id="status_filter" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($bookingStatuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="date_to" class="form-label">{{ __('labels.date_to') }}</label>

                        <input type="text" class="form-control form-select" name="travel_date" id="daterange"
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

        <!-- Cancel Booking Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelModalLabel">Cancel Booking</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to cancel booking <strong id="cancel-booking-number"></strong>?</p>
                        <div class="mb-3">
                            <label for="cancel-reason" class="form-label">Reason (optional)</label>
                            <textarea class="form-control" id="cancel-reason" rows="3"
                                placeholder="Enter cancellation reason..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirm-cancel">Cancel Booking</button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="module" defer>

        $(function () {

            // Cancel booking modal
            let cancelBookingId = null;

            $(document).on("click", ".cancel-booking", function () {
                cancelBookingId = $(this).data("id");
                $("#cancel-booking-number").text($(this).data("booking"));
                $("#cancel-reason").val("");
                $("#cancelModal").modal("show");
            });

            // Confirm cancel
            $("#confirm-cancel").click(function () {
                if (!cancelBookingId) return;

                $.ajax({
                    url: "{{ url('admin/bookings') }}/" + cancelBookingId + "/cancel",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        reason: $("#cancel-reason").val(),
                    },
                    success: function (response) {
                        $("#cancelModal").modal("hide");
                        bookingTable.ajax.reload();
                        alert(response.message || "Booking cancelled successfully");
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || "Failed to cancel booking");
                    },
                });
            });

        });
    </script>
@endpush