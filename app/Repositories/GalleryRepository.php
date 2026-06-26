<?php

namespace App\Repositories;

use App\Models\Gallery;

class GalleryRepository extends BaseRepository
{
    public function __construct(Gallery $model)
    {
        parent::__construct($model);
    }

    public function getDataFromRequest($request): array
    {
        return $request->only([
            'title',
            'description',
            'thumbnail_path',
            'is_featured',
            'destination_id',
            'tour_id',
            'status',
        ]);
    }

    public function getFeatured()
    {
        return $this->model->where('is_featured', true)->get();
    }

    public function getByType(string $type)
    {
        return $this->model->where('type', $type)->orderBy('sort_order')->get();
    }

    public function getActiveForFront()
    {
        return $this->model
            ->with(['destination', 'tour', 'images'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
