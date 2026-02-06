<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AvailableLanguage;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        // SQLite uchun
        AvailableLanguage::query()->delete();

        $languages = [
            ['lang_name' => 'O‘zbek tili'],
            ['lang_name' => 'Ingliz tili'],
            ['lang_name' => 'Rus tili'],
            ['lang_name' => 'Ispan tili'],
            ['lang_name' => 'Fransuz tili'],
            ['lang_name' => 'Nemis tili'],
            ['lang_name' => 'Arab tili'],
            ['lang_name' => 'Xitoy tili'],
            ['lang_name' => 'Yapon tili'],
            ['lang_name' => 'Koreys tili'],
            ['lang_name' => 'Turk tili'],
            ['lang_name' => 'Portugal tili'],
            ['lang_name' => 'Italyan tili'],
            ['lang_name' => 'Hindi tili'],
            ['lang_name' => 'Fors tili'],
        ];

        AvailableLanguage::insert($languages);
    }
}
