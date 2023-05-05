<?php

namespace App\Http\Controllers;

use App\Repositories\MealRepository;
use Illuminate\Http\Request;
use App\Http\Requests\MealsIndexRequest;
use App\Http\Resources\MealResource;
use Illuminate\Http\JsonResponse;

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
    public function index(MealsIndexRequest $request): JsonResponse
    {
        // Fiter results by query params results
        $meals = $this->mealRepository->filterMeals($request);

        return MealResource::collection($meals)->response()->setStatusCode(200);
    }
}
