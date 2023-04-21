<?php

namespace App\Models;

use App\Enums\MealStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Meal extends Model implements TranslatableContract
{
    use HasFactory, Translatable, SoftDeletes, Filterable;

    /**
     * Translatable attributes
    */
    public $translatedAttributes = ['title', 'description'];

    protected $guarded = [];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Global scope that will display only 'created' meals
        static::addGlobalScope('created', function (Builder $builder) {
            $builder->where('status', MealStatusEnum::CREATED);
        });
    }
}
