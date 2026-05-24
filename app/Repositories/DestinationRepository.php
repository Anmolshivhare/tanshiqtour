<?php

namespace App\Repositories;

use App\Models\Destination;

class DestinationRepository extends BaseRepository
{
    public function __construct(Destination $model)
    {
        parent::__construct($model);
    }

    /**
     * Get fields from request.
     */
    public function getDataFromRequest($request): array
    {
        return $request->only([
            'name',
            'slug',
            'country',
            'state',
            'city',
            'description',
            'short_description',
            'featured_image',
            'banner_image',
            'status',
        ]);
    }

    /**
     * Get all active destinations.
     */
    public function getActiveDestinations()
    {
        return $this->model->active()->get();
    }

    /**
     * Get a destination by its slug.
     */
    public function getBySlug(string $slug): ?Destination
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Get all destinations for a dropdown list.
     */
    public function getForDropdown(): array
    {
        return $this->model->active()->pluck('name', 'id')->toArray();
    }
}
