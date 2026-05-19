<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    protected $model;

    public function __construct(Role $model)
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
            'parents',
            'children',
        ]);
    }
}
