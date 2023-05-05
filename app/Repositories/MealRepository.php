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
    public function setModelName(): string
    {
        return Meal::class;
    }

    /**
     * Filter /meals request by parameters
     * ------------------------------
     * @param App\Http\Requests\MealsIndexRequest $request
     * @return Illuminate\Pagination\LengthAwarePaginator
    */
    public function filterMeals(MealsIndexRequest $request): LengthAwarePaginator
    {
        // Retrieve query parameters
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        // Apply scope (app\Traits\Filterable)
        // Check app/Filter.php & app/MealsFilter.php
        $query = $this->model->with([ 'translations', 'category', 'category.translations', 'tags', 'tags.translations', 'ingredients', 'ingredients.translations' ])->filter(new MealsFilter($request));

        // Paginate result, keep query string for previous & next links
        $results = $query->paginate($perPage, ['*'], 'page', $page)->withQueryString();

        return $results;
    }
}
