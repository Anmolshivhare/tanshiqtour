<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class PaginateHelper
{
    /**
     * Function to get
     * @param string $dateTime Date time
     *
     * @return string
     */
    public static function getPaginateData($data, $resource) {
        // Assuming $resource is the string name of the resource, not an instance
        $resourceClass = "\\App\\Http\\Resources\\{$resource}";

        if (!class_exists($resourceClass)) {
            throw new Exception("Class {$resourceClass} not found.");
        }

        // Transform the data into a resource collection
        $resourceCollection = $resourceClass::collection($data);

        // Check if the collection is paginated
        if ($data instanceof LengthAwarePaginator) {
            $response = [
                'data' => $resourceCollection,
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total()
            ];
        } else {
            $response = [
                'data' => $resourceCollection,
                'total' => $data->count()
            ];
        }

        return $response;
    }

}
