<?php

namespace App\Repositories;

use App\Models\Blog;

class BlogRepository extends BaseRepository
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function getDataFromRequest($request): array
    {
        return $request->only([
            'author_id',
            'category_id',
            'title',
            'slug',
            'excerpt',
            'body',
            'featured_image',
            'tags',
            'is_featured',
            'status',
            'published_at',
        ]);
    }

    public function getPublished()
    {
        return $this->model->published()->with(['author', 'category'])->latest('published_at')->get();
    }

    public function getBySlug(string $slug): ?Blog
    {
        return $this->model->where('slug', $slug)->with(['author', 'category'])->first();
    }

    public function getFeatured()
    {
        return $this->model->where('is_featured', true)->published()->with(['author', 'category'])->get();
    }
}
