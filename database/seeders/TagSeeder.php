<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {

            $tag = new Tag();

            foreach (config('translatable.locales') as $locale) {
                $tag->translateOrNew($locale)->title = strtoupper($locale) . '_' . $faker->word;
            }

            $tag->slug = 'tag-' . Str::uuid();
            $tag->save();
        }
    }
}
