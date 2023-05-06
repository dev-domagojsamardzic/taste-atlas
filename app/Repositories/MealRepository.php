<?php

namespace App\Repositories;

use App\Http\Filters\MealsFilter;
use App\Http\Requests\MealsIndexRequest;
use App\Models\Meal;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class MealRepository extends ModelRepository {

    /**
     * Configure the Model
     * ------------------------------
     * @return string
    */
    protected function setModelName(): string
    {
        return Meal::class;
    }

    /**
     * Filter /meals request by parameters
     * ------------------------------
     * @param App\Http\Requests\MealsIndexRequest $request
     * @return Illuminate\Pagination\LengthAwarePaginator
    */
    public function filterMeals(MealsIndexRequest $request, array $relationships): LengthAwarePaginator
    {
        // Retrieve query parameters
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        // Apply scope (app\Traits\Filterable)
        // Check app/Filter.php & app/MealsFilter.php
        $query = $this->model->with($relationships)->filter(new MealsFilter($request));

        // Paginate result, keep query string for previous & next links
        $results = $query->paginate($perPage, ['*'], 'page', $page)->withQueryString();

        return $results;
    }
}
