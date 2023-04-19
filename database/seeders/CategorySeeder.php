<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {

            $category = new Category();

            foreach (config('translatable.locales') as $locale) {
                $category->translateOrNew($locale)->title = strtoupper($locale) . '_' . $faker->word;
            }
            $category->slug = 'category-' . Str::uuid();
            $category->save();
        }
    }
}
