<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository extends BaseRepository
{
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get data from request for payment creation/update.
     *
     * @param object $request
     * @return array
     */
    public function getDataFromRequest($request): array
    {
        return $request->only([
            'booking_id',
            'razorpay_order_id',
            'razorpay_payment_id',
            'razorpay_signature',
            'amount',
            'currency',
            'status_id',
            'failure_reason',
            'razorpay_response'
        ]);
    }

    /**
     * Get payment by Razorpay order ID.
     *
     * @param string $orderId
     * @return Payment|null
     */
    public function getByRazorpayOrderId(string $orderId): ?Payment
    {
        return $this->model->where('razorpay_order_id', $orderId)->first();
    }

    /**
     * Get payment by Razorpay payment ID.
     *
     * @param string $paymentId
     * @return Payment|null
     */
    public function getByRazorpayPaymentId(string $paymentId): ?Payment
    {
        return $this->model->where('razorpay_payment_id', $paymentId)->first();
    }

    /**
     * Get payments for a booking.
     *
     * @param int $bookingId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByBookingId(int $bookingId)
    {
        return $this->model->where('booking_id', $bookingId)->get();
    }
}
