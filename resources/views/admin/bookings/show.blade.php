@extends('admin.layouts.app')
@section('title')
    Booking Details - {{ $booking->booking_number }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="gap-2 pb-2 mb-4 d-flex align-items-center justify-content-between">
            <h3 class="page-title">Booking Details</h3>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> {{ __('labels.back') }}
            </a>
        </div>

        <div class="row">
            <!-- Booking Information -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-ticket me-2"></i>Booking Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Booking Number:</th>
                                        <td><code class="fs-5">{{ $booking->booking_number }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Tour:</th>
                                        <td>
                                            <strong>{{ $booking->tour?->title ?? 'N/A' }}</strong>
                                            <br><small class="text-muted">{{ $booking->tour?->location }}</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Travel Date:</th>
                                        <td>{{ $booking->travel_date->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Persons:</th>
                                        <td>{{ $booking->number_of_persons }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Price per Person:</th>
                                        <td>₹{{ number_format($booking->price_per_person, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount:</th>
                                        <td class="text-success fs-4 fw-bold">{{ $booking->formatted_total }}</td>
                                    </tr>
                                    <tr>
                                        <th>Booking Status:</th>
                                        <td>
                                            @php
                                                $statusName = $booking->bookingStatus?->name ?? 'N/A';
                                                $badgeClass = match($statusName) {
                                                    config('constants.booking_paid_status') => 'bg-success',
                                                    config('constants.booking_pending_status') => 'bg-warning',
                                                    config('constants.booking_cancelled_status') => 'bg-secondary',
                                                    config('constants.booking_failed_status') => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} fs-6">{{ $statusName }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status:</th>
                                        <td>
                                            @php
                                                $paymentStatusName = $booking->paymentStatus?->name ?? 'N/A';
                                                $paymentBadgeClass = match($paymentStatusName) {
                                                    config('constants.payment_success_status') => 'bg-success',
                                                    config('constants.payment_initiated_status') => 'bg-info',
                                                    config('constants.payment_failed_status') => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $paymentBadgeClass }} fs-6">{{ $paymentStatusName }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-user me-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Name:</th>
                                <td>{{ $booking->guest_name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><a href="mailto:{{ $booking->guest_email }}">{{ $booking->guest_email }}</a></td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td><a href="tel:{{ $booking->guest_phone }}">{{ $booking->guest_phone }}</a></td>
                            </tr>
                            @if($booking->user)
                                <tr>
                                    <th>Registered User:</th>
                                    <td>{{ $booking->user->name }} ({{ $booking->user->email }})</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>

                @if($booking->notes)
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-notes me-2"></i>Notes</h5>
                        </div>
                        <div class="card-body">
                            {!! nl2br(e($booking->notes)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Payment History -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fa-solid fa-credit-card me-2"></i>Payment History</h5>
                    </div>
                    <div class="card-body">
                        @if($booking->payments->count() > 0)
                            <div class="timeline">
                                @foreach($booking->payments as $payment)
                                    <div class="timeline-item mb-3 pb-3 border-bottom">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $payment->formatted_amount }}</strong>
                                            @php
                                                $pStatusName = $payment->status?->name ?? 'N/A';
                                                $pBadgeClass = match($pStatusName) {
                                                    config('constants.payment_success_status') => 'bg-success',
                                                    config('constants.payment_initiated_status') => 'bg-info',
                                                    config('constants.payment_failed_status') => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $pBadgeClass }}">{{ $pStatusName }}</span>
                                        </div>
                                        <small class="text-muted">{{ $payment->created_at }}</small>
                                        
                                        @if($payment->razorpay_order_id)
                                            <div class="mt-2">
                                                <small><strong>Order ID:</strong> {{ $payment->razorpay_order_id }}</small>
                                            </div>
                                        @endif
                                        
                                        @if($payment->razorpay_payment_id)
                                            <div>
                                                <small><strong>Payment ID:</strong> {{ $payment->razorpay_payment_id }}</small>
                                            </div>
                                        @endif
                                        
                                        @if($payment->failure_reason)
                                            <div class="mt-2 text-danger">
                                                <small><strong>Reason:</strong> {{ $payment->failure_reason }}</small>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">No payment records found</p>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        @if($booking->isPending())
                            @can('booking-cancel')
                                <button type="button" class="btn btn-danger w-100" id="cancel-btn">
                                    <i class="fa-solid fa-times me-1"></i> Cancel Booking
                                </button>
                            @endcan
                        @endif
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <strong>Created:</strong> {{ $booking->created_at->format('d M Y, h:i A') }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <strong>Updated:</strong> {{ $booking->updated_at->format('d M Y, h:i A') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    $(document).ready(function() {
        $('#cancel-btn').click(function() {
            if (confirm('Are you sure you want to cancel this booking?')) {
                $.ajax({
                    url: "{{ route('admin.bookings.cancel', encrypt($booking->id)) }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        reason: 'Cancelled by admin'
                    },
                    success: function(response) {
                        alert(response.message || 'Booking cancelled successfully');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Failed to cancel booking');
                    }
                });
            }
        });
    });
</script>
@endpush
