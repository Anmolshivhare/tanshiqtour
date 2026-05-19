<?php

namespace App\Repositories;

use App\Models\Author;

class AuthorRepository extends BaseRepository
{
    protected $model;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }

    /**
     * Function to get all the role from the request
     *
     * @param object $request
     * @return array
     */
    public function getDataFromRequest($request)
    {
        return $request->only([
            'name',
            'status',
        ]);
    }

    /**
     * Get all active authors using the scope
     */
    public function getActiveAuthors()
    {
        return $this->model->activeAuthors()->get();
    }
}
