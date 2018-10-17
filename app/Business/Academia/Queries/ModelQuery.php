<?php

namespace App\Business\Academia\Queries;
// Models
use App\Business\Academia\Repositories\ModelRepository;

class ModelQuery
{
    public static function fnGetAll()
    {
        $lstModels = ModelRepository::fnGetWithCourses();
        return $lstModels;
    }
    public static function fnGetById($id)
    {
        $lstModels = ModelRepository::fnFind($id);
        return $lstModels;
    }
}