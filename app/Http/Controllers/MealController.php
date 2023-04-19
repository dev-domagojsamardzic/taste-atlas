<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Repositories\MealRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\MealsIndexRequest;
use App\Http\Resources\MealResource;
use Illuminate\Support\Facades\App;

class MealController extends Controller
{

    private $repository;

    public function __construct(MealRepository $mealRepository)
    {
        $this->repository = $mealRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(MealsIndexRequest $request)
    {
        // Transform results
        $results = $this->repository->filterMeals($request);

        return MealResource::collection($results)->additional(['meta' => [
            'total' => $results->total(),
            'per_page' => $results->perPage(),
            'current_page' => $results->currentPage(),
            'last_page' => $results->lastPage(),
            'from' => $results->firstItem(),
            'to' => $results->lastItem(),
        ]])
        ->response()
        ->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
