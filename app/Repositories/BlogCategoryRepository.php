<?php

namespace App\Repositories;

use App\Models\BlogCategory;

class BlogCategoryRepository extends BaseRepository
{
    public function __construct(BlogCategory $model)
    {
        parent::__construct($model);
    }

    public function getDataFromRequest($request): array
    {
        return $request->only([
            'name',
            'slug',
            'description',
            'status',
        ]);
    }

    public function getActiveCategories()
    {
        return $this->model->active()->get();
    }

    public function getForDropdown(): array
    {
        return $this->model->active()->pluck('name', 'id')->toArray();
    }
}
