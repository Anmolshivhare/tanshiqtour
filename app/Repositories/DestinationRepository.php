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
     * Get all active destinations matching an optional search term.
     */
    public function getActiveDestinationsFiltered(string $search = '')
    {
        return $this->model->query()
            ->active()
            ->whereNotNull('slug')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%')
                        ->orWhere('state', 'like', '%' . $search . '%')
                        ->orWhere('country', 'like', '%' . $search . '%');
                });
            })
            ->latest('id')
            ->get();
    }

    /**
     * Get paginated active destinations with an optional search term.
     */
    public function getActiveDestinationsPaginated(string $search = '', int $perPage = 6)
    {
        return $this->model->query()
            ->active()
            ->whereNotNull('slug')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%')
                        ->orWhere('state', 'like', '%' . $search . '%')
                        ->orWhere('country', 'like', '%' . $search . '%');
                });
            })
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get a destination by its slug.
     */
    public function getBySlug(string $slug): ?Destination
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Get an active destination by its slug.
     */
    public function getActiveBySlug(string $slug): Destination
    {
        return $this->model->query()
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * Get all destinations for a dropdown list.
     */
    public function getForDropdown(): array
    {
        return $this->model->active()->pluck('name', 'id')->toArray();
    }
}
