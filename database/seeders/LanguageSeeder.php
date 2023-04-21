<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $availableLanguages = [
            [ 'name' => 'Croatian', 'code' => 'hr' ],
            [ 'name' => 'English',  'code' => 'en' ],
            [ 'name' => 'German',   'code' => 'de' ],
            [ 'name' => 'French',   'code' => 'fr' ]
        ];

        DB::table('languages')->insert($availableLanguages);
    }
}
