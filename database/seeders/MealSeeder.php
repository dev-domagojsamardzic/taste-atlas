<?php

namespace Database\Seeders;

use App\Enums\MealStatusEnum;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use App\Models\Meal;
use App\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;

class MealSeeder extends Seeder
{

    protected $model = Meal::class;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {

            $meal = new Meal();

            foreach (config('translatable.locales') as $locale) {
                $meal->translateOrNew($locale)->title = $faker->sentence();
                $meal->translateOrNew($locale)->description = $faker->paragraph();
            }

            $meal->category_id = $faker->optional()->randomElement(Category::pluck('id')->toArray());
            $meal->status = Arr::random([MealStatusEnum::CREATED, MealStatusEnum::MODIFIED, MealStatusEnum::DELETED]);
            $meal->save();

            $meal->tags()->attach(Tag::inRandomOrder()->limit($faker->numberBetween(1, 5))->pluck('id')->toArray());
            $meal->ingredients()->attach(Ingredient::inRandomOrder()->limit($faker->numberBetween(1, 10))->pluck('id')->toArray());
        }
        /* $faker = Factory::create();

        $availableLocales = config('translatable.locales');

        $meals = Meal::factory()->count(15)->create()->hasIngredients();

        $meals->each(function($meal) use ($availableLocales, $faker) {

            foreach($availableLocales as $locale) {

                $meal->translateOrNew($locale)->title = $faker->name;
                $meal->translateOrNew($locale)->description = $faker->paragraph;
                $meal->save();
            }
        }); */
    }
}
