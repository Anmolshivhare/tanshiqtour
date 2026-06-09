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
            'destination_id',
            'is_featured',
            'max_persons',
            'status',
        ]);
    }

    /**
     * Get all active tours.
     */
    public function getActiveTours()
    {
        return $this->model->active()->get();
    }

    /**
     * Get active tours marked as featured for front sections.
     */
    public function getFeaturedTours(int $limit = 6)
    {
        return $this->model->query()
            ->with('destination')
            ->active()
            ->where('is_featured', true)
            ->latest('id')
            ->limit($limit)
            ->get();
    }

    /**
     * Get tour by slug.
     */
    public function getBySlug(string $slug): ?Tour
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Get all tours for a dropdown list.
     */
    public function getForDropdown(): array
    {
        return $this->model->pluck('title', 'id')->toArray();
    }

    /**
     * Get tour with its relations.
     */
    public function getWithRelations(int $id): ?Tour
    {
        return $this->model->with(['destination', 'images', 'itineraryDays', 'reviews'])->find($id);
    }
}
