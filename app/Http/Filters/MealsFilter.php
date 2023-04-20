<?php

namespace App\Http\Filters;

use Illuminate\Support\Carbon;

class MealsFilter extends Filter
{

    private $category;
    private $tags;
    private $with;
    private $diffTime;

    protected function setProperties(): void
    {
        $this->category = $this->request->input('category');
        $this->tags = ( $this->request->has('tags') ) ? explode(',', $this->request->input('tags') ) : [];
        $this->with = ($this->request->has('with')) ? explode(',', $this->request->input('with')) : [];
        $this->diffTime = $this->request->input('diff_time');
    }


    public function category() {
        // Filter by category
        if ($this->category === null) {
            $this->builder->whereNull('category_id');
        } elseif ($this->category === '!NULL') {
            $this->builder->whereNotNull('category_id');
        } else {
            $this->builder->where('category_id', $this->category);
        }
    }

    public function tags() {
        // Filter by tags
        if (!empty($this->tags)) {
            foreach ($this->tags as $tag) {
                $this->builder->whereHas('tags', function ($query) use ($tag) {
                    $query->where('id', $tag);
                });
            }
        }
    }

    public function diff_time() {
        // Filter by diff_time
        if ($this->diffTime !== null) {
            $this->builder->withTrashed()->where(function ($query) {
                $query->where('created_at', '>', Carbon::createFromTimestamp($this->diffTime))
                    ->orWhere('updated_at', '>', Carbon::createFromTimestamp($this->diffTime))
                    ->orWhere('deleted_at', '>', Carbon::createFromTimestamp($this->diffTime));
            });
        }
    }

    public function with() {
        // Eager load related models
        if (in_array('ingredients', $this->with)) {
            $this->builder->with('ingredients');
        }
        if (in_array('category', $this->with)) {
            $this->builder->with('category');
        }
        if (in_array('tags', $this->with)) {
            $this->builder->with('tags');
        }
    }
}
