<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
            // Retrieve query parameters
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $category = $request->input('category');
        $tags = $request->input('tags');
        $with = ($request->has('with')) ? explode(',', $request->input('with')) : [];
        $lang = $request->input('lang');
        $diffTime = $request->input('diff_time');

        // Build query
        $query = Meal::query()->translatedIn($lang);
        // Filter by category
        if ($category === null) {
            $query->whereNull('category_id');
        } elseif ($category === '!NULL') {
            $query->whereNotNull('category_id');
        } else {
            $query->where('category_id', $category);
        }

        // Filter by tags
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $query->whereHas('tags', function ($query) use ($tag) {
                    $query->where('id', $tag);
                });
            }
        }

        // Filter by diff_time
        if ($diffTime !== null) {
            $deletedAtColumn = (new Meal())->getDeletedAtColumn();
            $query->withTrashed()->where(function ($query) use ($diffTime, $deletedAtColumn) {
                $query->where('created_at', '>', Carbon::createFromTimestamp($diffTime))
                    ->orWhere('updated_at', '>', Carbon::createFromTimestamp($diffTime))
                    ->orWhere($deletedAtColumn, '>', Carbon::createFromTimestamp($diffTime));
            });
        }

        // Eager load related models
        if (in_array('ingredients', $with)) {
            $query->with('ingredients.translations');
        }
        if (in_array('category', $with)) {
            $query->with('category.translations');
        }
        if (in_array('tags', $with)) {
            $query->with('tags.translations');
        }

        // Paginate results
        $results = $query->paginate($perPage, ['*'], 'page', $page);
        // Transform results
        return response()->json($results,200);
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
