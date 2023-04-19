<?php

namespace App\Http\Controllers;

use App\Repositories\MealRepository;
use Illuminate\Http\Request;
use App\Http\Requests\MealsIndexRequest;
use App\Http\Resources\MealResource;

class MealController extends Controller
{

    private $mealRepository;

    public function __construct(MealRepository $mealRepository)
    {
        $this->mealRepository = $mealRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(MealsIndexRequest $request)
    {
        // Transform results
        $meals = $this->mealRepository->filterMeals($request);

        return MealResource::collection($meals)->response()->setStatusCode(200);
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
