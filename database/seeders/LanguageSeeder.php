<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            ['lang_name' => 'English'],
            ['lang_name' => 'Spanish'],
            ['lang_name' => 'French'],
            ['lang_name' => 'German'],
            ['lang_name' => 'Italian'],
            ['lang_name' => 'Portuguese'],
            ['lang_name' => 'Russian'],
            ['lang_name' => 'Chinese'],
            ['lang_name' => 'Japanese'],
            ['lang_name' => 'Korean'],
            ['lang_name' => 'Uzbek'],
        ];

        foreach ($languages as $language) {
            \App\Models\AvailableLanguage::create($language);
        }
    }
}
