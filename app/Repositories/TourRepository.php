<?php

namespace App\Repositories;

use App\Models\Tour;

class TourRepository extends BaseRepository
{
    public function __construct(Tour $model)
    {
        parent::__construct($model);
    }

    /**
     * Get data from request for tour creation/update.
     *
     * @param object $request
     * @return array
     */
    public function getDataFromRequest($request): array
    {
        return $request->only([
            'title',
            'slug',
            'location',
            'duration',
            'price_per_person',
            'description',
            'featured_image',
            'status_id'
        ]);
    }

    /**
     * Get all active tours.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveTours()
    {
        return $this->model->active()->get();
    }

    /**
     * Get tour by slug.
     *
     * @param string $slug
     * @return Tour|null
     */
    public function getBySlug(string $slug): ?Tour
    {
        return $this->model->where('slug', $slug)->first();
    }
}
