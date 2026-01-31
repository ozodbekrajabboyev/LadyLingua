<?php

namespace Database\Seeders;

use App\Models\Translation;
use App\Models\Work;
use App\Models\User;
use App\Models\TranslatorPortfolio;
use App\Models\AvailableLanguage;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class SampleWorkSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have some languages
        $english = AvailableLanguage::firstOrCreate(['lang_name' => 'English']);
        $uzbek = AvailableLanguage::firstOrCreate(['lang_name' => 'Uzbek']);
        $russian = AvailableLanguage::firstOrCreate(['lang_name' => 'Russian']);
        $french = AvailableLanguage::firstOrCreate(['lang_name' => 'French']);

        // Create some sample works with descriptions
        $works = [
            [
                'title' => 'The Art of Computer Programming',
                'author_name' => 'Donald Knuth',
                'original_language_id' => $english->id,
                'description' => 'Kompyuter dasturlash san\'ati bo\'yicha fundamental asarlar to\'plami. Algoritmlar va ma\'lumotlar tuzilmalari haqida chuqur ma\'lumotlar.',
            ],
            [
                'title' => 'Clean Code',
                'author_name' => 'Robert C. Martin',
                'original_language_id' => $english->id,
                'description' => 'Toza va o\'qilishi oson kod yozish bo\'yicha amaliy qo\'llanma. Dasturchilar uchun muhim tamoyillar va amaliyotlar.',
            ],
            [
                'title' => 'War and Peace',
                'author_name' => 'Leo Tolstoy',
                'original_language_id' => $russian->id,
                'description' => 'Tolstoyning eng mashhur asari. Napoleon urushi davrida rus jamiyatining hayoti va insoniy munosabatlar haqida epic roman.',
            ],
            [
                'title' => 'The Little Prince',
                'author_name' => 'Antoine de Saint-Exupéry',
                'original_language_id' => $french->id,
                'description' => 'Kichik shahzoda haqidagi falsafiy ertak. Bolalar va kattalar uchun chuqur ma\'noga ega bo\'lgan go\'zal asar.',
            ],
            [
                'title' => 'Medical Research Protocols',
                'author_name' => 'Dr. Sarah Johnson',
                'original_language_id' => $english->id,
                'description' => 'Tibbiy tadqiqotlar metodologiyasi va protokollari bo\'yicha zamonaviy qo\'llanma. Immunologiya va klinik sinovlar bo\'yicha fundamental ma\'lumotlar.',
            ],
        ];

        foreach ($works as $workData) {
            $work = Work::create($workData);

            // Create a sample user if not exists
            $user = User::firstOrCreate(
                ['email' => 'translator@example.com'],
                [
                    'name' => 'Professional Translator',
                    'password' => bcrypt('password'),
                    'role' => 'translator',
                    'status' => 'active',
                ]
            );

            // Create translator portfolio if not exists
            $translatorPortfolio = TranslatorPortfolio::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => 'Professional translator with 10+ years of experience',
                    'profile_image_url' => 'https://via.placeholder.com/150',
                    'total_earnings' => 5000.00,
                    'average_rating' => 4.8,
                ]
            );

            // Create a translation for this work
            $translation = Translation::create([
                'work_id' => $work->id,
                'translator_id' => $translatorPortfolio->id,
                'language_id' => $uzbek->id,
                'status' => 'published',
                'price' => rand(50, 300),
                'preview_pages_cnt' => rand(5, 15),
            ]);

            // Create some sample ratings
            for ($i = 0; $i < rand(3, 8); $i++) {
                Rating::create([
                    'translation_id' => $translation->id,
                    'user_id' => $user->id,
                    'stars' => rand(4, 5),
                    'comment' => 'Excellent translation quality!',
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
