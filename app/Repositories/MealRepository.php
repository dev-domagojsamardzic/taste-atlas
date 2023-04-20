<?php

namespace App\Repositories;

use App\Http\Filters\MealsFilter;
use App\Http\Requests\MealsIndexRequest;
use App\Models\Meal;
use Illuminate\Support\Carbon;

class MealRepository extends ModelRepository {


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Meal::class;
    }

    public function filterMeals(MealsIndexRequest $request) {

        // Retrieve query parameters
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        // Apply scope (app\Traits\Filterable)
        $query = $this->model->filter(new MealsFilter($request));

        // Paginate result, keep query string
        $results = $query->paginate($perPage, ['*'], 'page', $page)->withQueryString();

        return $results;
    }
}
