<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) {

            $ingredient = new Ingredient();

            foreach (config('translatable.locales') as $locale) {
                $ingredient->translateOrNew($locale)->title = $faker->word;
            }

            $ingredient->save();
        }
    }
}
