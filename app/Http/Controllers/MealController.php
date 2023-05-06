<?php

namespace App\Http\Controllers;

use App\Repositories\MealRepository;
use App\Http\Requests\MealsIndexRequest;
use App\Http\Resources\MealCollection;

class MealController extends Controller
{

    /**
     * Meal repository instance.
     *
     * @var App\Repositories\MealRepository
     */
    private MealRepository $mealRepository;

    public function __construct(MealRepository $mealRepository)
    {
        $this->mealRepository = $mealRepository;
    }

    /**
     * Display a listing of the resource.
     * -----------------------------------------
     * @param App\Http\Requests\MealsIndexRequest $request
     * @return Illuminate\Http\JsonResponse
     */
    public function index(MealsIndexRequest $request)
    {
        // Fiter results by query params results
        $meals = $this->mealRepository->filterMeals($request);

        // return MealCollection as response
        return MealCollection::make($meals)->response()->setStatusCode(200);
    }
}
