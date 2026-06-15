<?php

namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Support\Collection;

class BannerRepository extends BaseRepository
{
    public function __construct(Banner $model)
    {
        parent::__construct($model);
    }

    public function getDataFromRequest($request): array
    {
        return $request->only([
            'title',
            'subtitle',
            'description',
            'image',
            'button_text',
            'button_url',
            'sort_order',
            'status',
        ]);
    }

    public function getActiveBanners(): Collection
    {
        return $this->model->query()
            ->active()
            ->orderBy('sort_order')
            ->latest('id')
            ->get();
    }

    public function getActiveBannersForHome(): Collection
    {
        return $this->getActiveBanners();
    }
}
