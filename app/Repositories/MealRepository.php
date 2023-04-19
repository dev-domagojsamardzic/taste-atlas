<?php

namespace App\Repositories;

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
        $category = $request->input('category');
        $tags = ( $request->has('tags') ) ? explode(',', $request->input('tags') ) : [];
        $with = ($request->has('with')) ? explode(',', $request->input('with')) : [];
        $diffTime = $request->input('diff_time');

        // Build query
        $query = Meal::query();

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

            $query->withTrashed()->where(function ($query) use ($diffTime) {
                $query->where('created_at', '>', Carbon::createFromTimestamp($diffTime))
                    ->orWhere('updated_at', '>', Carbon::createFromTimestamp($diffTime))
                    ->orWhere('deleted_at', '>', Carbon::createFromTimestamp($diffTime));
            });
        }

        // Eager load related models
        if (in_array('ingredients', $with)) {
            $query->with('ingredients');
        }
        if (in_array('category', $with)) {
            $query->with('category');
        }
        if (in_array('tags', $with)) {
            $query->with('tags');
        }

        // Paginate results
        $results = $query->paginate($perPage, ['*'], 'page', $page);
        return $results;
    }
}
