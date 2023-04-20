<?php

namespace App\Repositories;

use App\Http\Filters\MealsFilter;
use App\Http\Requests\MealsIndexRequest;
use App\Models\Meal;
use Illuminate\Pagination\LengthAwarePaginator;

class MealRepository extends ModelRepository {

    /**
     * Configure the Model
     * ------------------------------
     * @return string
    */
    public function model(): string
    {
        return Meal::class;
    }

    /**
     * Filter /meals request by parameters
     * ------------------------------
     * @param App\Http\Requests\MealsIndexRequest $request
     * @return Illuminate\Pagination\LengthAwarePaginator
    */
    public function filterMeals(MealsIndexRequest $request): LengthAwarePaginator {

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
