<?php

namespace App\Repositories;

use App\Models\Meal;

class MealRepository extends ModelRepository {


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Meal::class;
    }
}
