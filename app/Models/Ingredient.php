<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Str;

class Ingredient extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['title'];
    protected $fillable = ['title'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $category->slug = 'tag-' . Str::uuid();
        });
    }
}
