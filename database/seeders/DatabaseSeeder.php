<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\MealSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TagSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            LanguageSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            IngredientSeeder::class,
            MealSeeder::class
        ]);
    }
}
