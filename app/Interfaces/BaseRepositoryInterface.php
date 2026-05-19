<?php

namespace App\Interfaces;

interface BaseRepositoryInterface
{
    public function getAllData();

    public function getDataById(string $id);

    public function createData(array $data);

    public function updateData(string $id, array $updatedData);

    public function deleteDataById(string $id);

    public function getAllDataFromRequest($request);

    public function getDataOnBasisOfFilter(array $filters);

    public function updateOrCreateData(array $conditions, array $data);
}
