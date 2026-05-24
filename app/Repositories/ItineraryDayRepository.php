<?php

namespace App\Repositories;

use App\Models\ItineraryDay;

class ItineraryDayRepository extends BaseRepository
{
    public function __construct(ItineraryDay $model)
    {
        parent::__construct($model);
    }

    /**
     * Get data from request.
     */
    public function getDataFromRequest($request): array
    {
        return $request->only([
            'tour_id',
            'day_number',
            'title',
            'description',
            'accommodation',
            'meals_included',
            'activities',
        ]);
    }

    /**
     * Get all itinerary days for a specific tour.
     */
    public function getByTourId(int $tourId)
    {
        return $this->model->where('tour_id', $tourId)->orderBy('day_number')->get();
    }

    /**
     * Delete all itinerary days for a tour.
     */
    public function deleteByTourId(int $tourId): void
    {
        $this->model->where('tour_id', $tourId)->delete();
    }
}
