<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $request->has('with')  &&
        return [
            'id' => $this->id,
            'title' => $this->translate($request->lang)->title,
            'description' => $this->translate($request->lang)->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'category' => $this->when(
                ($request->has('with') && in_array('category', explode(',', $request->get('with')))),
                CategoryResource::make($this->category),
            ),
            'ingredients' => $this->when(
                ($request->has('with') && in_array('ingredients', explode(',', $request->get('with')))),
                IngredientResource::collection($this->ingredients)
            ),
            'tags' => $this->when(
                ($request->has('with') && in_array('tags', explode(',', $request->get('with')))),
                TagResource::collection($this->tags)
            )
        ];
    }
}
