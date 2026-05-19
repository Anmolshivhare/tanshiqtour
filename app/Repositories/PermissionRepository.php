<?php

namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository extends BaseRepository
{
    protected $model;

    /**
     * constructor function
     *
     * @param Permission $model
     */
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    /**
     * function to get the data from the request
     * @param mixed $request
     */
    public function getDataFromRequest($request)
    {
        $data = $request->only(['name', 'parent', 'parent_id']);
        if (($data['parent'] ?? 'none') !== 'none') {
            $data['parent_id'] = $data['parent'];
        } else {
            $data['parent_id'] = null;
        }
        return $data;
    }
}
