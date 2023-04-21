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
use Illuminate\Support\Carbon;
use App\Models\Language;

class MealSeeder extends Seeder
{

    protected $model = Meal::class;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $possibleCategories = Category::pluck('id')->toArray();
        $locales = Language::pluck('code')->toArray();

        for ($i = 0; $i < 50; $i++) {

            $meal = new Meal();

            // Translate to available locales
            foreach ($locales as $locale) {
                $meal->translateOrNew($locale)->title = strtoupper($locale) . '_' . $faker->sentence();
                $meal->translateOrNew($locale)->description = strtoupper($locale) . '_' .$faker->paragraph();
            }

            // Set random category_id or NULL
            $meal->category_id = $faker->optional(0.8 , NULL)->randomElement($possibleCategories);

            // Random status
            $status = Arr::random([MealStatusEnum::CREATED, MealStatusEnum::MODIFIED, MealStatusEnum::DELETED]);
            $meal->status = $status;

            // All meals are created 7 days ago
            $meal->created_at = Carbon::now()->subDays(7);

            // If meal->status == 'modified', set datetime in range (-7days to +7days)
            if($status === MealStatusEnum::MODIFIED) {
                $meal->updated_at = $meal->updated_at = Carbon::now()->addDays(random_int(-7, 7));
            }
            // If meal->status == 'deleted', set datetime in range (-7days to +7days)
            if($status === MealStatusEnum::DELETED){
                $meal->deleted_at = Carbon::now()->addDays(random_int(-7, 7));
            }
            $meal->save();

            // Append random tags to meal (1-5)
            $meal->tags()->attach(Tag::inRandomOrder()->limit($faker->numberBetween(1, 5))->pluck('id')->toArray());
            // Append random ingredients to meal (1-10)
            $meal->ingredients()->attach(Ingredient::inRandomOrder()->limit($faker->numberBetween(1, 10))->pluck('id')->toArray());
        }
    }
}
