<?php

namespace App\Repositories;

use App\Models\Booking;

class BookingRepository extends BaseRepository
{
    public function __construct(Booking $model)
    {
        parent::__construct($model);
    }

    /**
     * Get data from request for booking creation/update.
     *
     * @param object $request
     * @return array
     */
    public function getDataFromRequest($request): array
    {
        return $request->only([
            'tour_id',
            'user_id',
            'guest_name',
            'guest_email',
            'guest_phone',
            'travel_date',
            'number_of_persons',
            'notes'
        ]);
    }

    /**
     * Get booking by booking number.
     *
     * @param string $bookingNumber
     * @return Booking|null
     */
    public function getByBookingNumber(string $bookingNumber): ?Booking
    {
        return $this->model->where('booking_number', $bookingNumber)->first();
    }

    /**
     * Get bookings for a specific tour.
     *
     * @param int $tourId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByTourId(int $tourId)
    {
        return $this->model->where('tour_id', $tourId)->get();
    }

    /**
     * Get bookings by status.
     *
     * @param string $statusName
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByBookingStatus(string $statusName)
    {
        return $this->model->withBookingStatus($statusName)->get();
    }

    /**
     * Get bookings within date range.
     *
     * @param string $startDate
     * @param string $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByDateRange(string $startDate, string $endDate)
    {
        return $this->model->whereBetween('travel_date', [$startDate, $endDate])->get();
    }
}
