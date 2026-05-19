<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository  implements BaseRepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * This function retrieves an All data.
     *
     */
    public function getAllData()
    {
        return $this->model->get();
    }

    /**
     * function to get the user data by id
     *
     * @param integer $dataId
     * @return object
     */
    public function getDataById(string $id)
    {
        return $this->model->find($id);
    }

    /*
    * This function create data.
    *
    * @param array dataDetails The parameter `dataDetails` is an array that create Data details in the database.
    *
    * @return array.
    */
    public function createData(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * This function get data value from dataId  and update data
     */
    public function updateData(string $id, array $updatedData)
    {
        $data = $this->model::findOrFail($id);
        $data->update($updatedData);
        return $data;
    }

    /**
     * This function get Company value from companyId  and delete Company
     */
    public function deleteDataById(string $id)
    {
        $data = $this->model->find($id);
        $data->delete();
        return $data;
    }

    /*
    * function to validate the data which is coming from the request
    *
    * @param object $requestData
    * @return array
    */
    public function getAllDataFromRequest($request)
    {
        return $request->only([]);
    }

    /**
     * function to get the data of the basis of filter passed
     *
     * @param array $filters
     * @return mixed
     */
    public function getDataOnBasisOfFilter(array $filters): Collection
    {
        $query = $this->model::query();
        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }
        return $query->get();
    }

    /**
     * Update an existing record that matches the given conditions, or create a new one.
     *
     * This method checks for a record matching the provided conditions.
     * If found, it updates it with the given data; if not found, it creates a new record.
     *
     * @param array $conditions Key-value pairs used to locate the existing record.
     * @param array $data Data to be used for updating or creating the record.
     *
     * @return \Illuminate\Database\Eloquent\Model The updated or newly created model instance.
     */
    public function updateOrCreateData(array $conditions, array $data)
    {
        return $this->model::updateOrCreate($conditions, $data);
    }
}
