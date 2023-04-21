<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $locales = Language::pluck('code')->toArray();

        for ($i = 0; $i < 30; $i++) {

            $ingredient = new Ingredient();

            foreach ($locales as $locale) {
                $ingredient->translateOrNew($locale)->title = strtoupper($locale) . '_' . $faker->word;
            }

            $ingredient->slug = 'tag-' . Str::uuid();
            $ingredient->save();
        }
    }
}
