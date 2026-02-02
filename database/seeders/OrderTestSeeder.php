<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Work;
use App\Models\User;
use App\Models\TranslatorPortfolio;
use App\Models\AvailableLanguage;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderTestSeeder extends Seeder
{
    public function run()
    {
        // Create test users if they don't exist
        $client = User::firstOrCreate(['email' => 'client@test.com'], [
            'name' => 'Test Client',
            'email' => 'client@test.com',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);

        $translator = User::firstOrCreate(['email' => 'translator@test.com'], [
            'name' => 'Test Translator',
            'email' => 'translator@test.com',
            'password' => bcrypt('password'),
            'role' => 'translator'
        ]);

        // Create translator portfolio
        $translatorPortfolio = TranslatorPortfolio::firstOrCreate(['user_id' => $translator->id], [
            'user_id' => $translator->id,
            'bio' => 'Professional translator with 5 years experience',
            'profile_image_url' => 'https://via.placeholder.com/100x100',
            'total_earnings' => 1500000.00,
            'average_rating' => 4.8
        ]);

        // Create languages
        $uzbek = AvailableLanguage::firstOrCreate(['lang_name' => 'Uzbek'], [
            'lang_name' => 'Uzbek'
        ]);

        $english = AvailableLanguage::firstOrCreate(['lang_name' => 'English'], [
            'lang_name' => 'English'
        ]);

        // Create works and orders
        $works = [
            [
                'title' => 'Marketing strategiyasi hujjati',
                'author_name' => 'John Smith',
                'description' => 'Comprehensive marketing strategy document for tech startup',
                'status' => 'in_progress',
                'price' => 150000,
                'has_translation' => true
            ],
            [
                'title' => 'Texnik qo\'llanma tarjimasi',
                'author_name' => 'Sarah Johnson',
                'description' => 'Technical manual for industrial equipment',
                'status' => 'pending',
                'price' => 80000,
                'has_translation' => false
            ],
            [
                'title' => 'Veb-sayt lokalizatsiyasi',
                'author_name' => 'David Miller',
                'description' => 'Website localization for e-commerce platform',
                'status' => 'completed',
                'price' => 1200000,
                'has_translation' => true
            ],
            [
                'title' => 'Mobil ilova matnlari',
                'author_name' => 'Lisa Chen',
                'description' => 'Mobile application UI/UX text localization',
                'status' => 'completed',
                'price' => 500000,
                'has_translation' => true
            ],
            [
                'title' => 'Yuridik shartnoma',
                'author_name' => 'Michael Brown',
                'description' => 'Legal contract translation',
                'status' => 'pending',
                'price' => 200000,
                'has_translation' => false
            ]
        ];

        foreach ($works as $index => $workData) {
            // Create work
            $work = Work::firstOrCreate([
                'title' => $workData['title']
            ], [
                'title' => $workData['title'],
                'original_language_id' => $english->id,
                'author_name' => $workData['author_name'],
                'description' => $workData['description']
            ]);

            // Create order
            $order = Order::firstOrCreate([
                'user_id' => $client->id,
                'work_id' => $work->id,
                'translator_id' => $translatorPortfolio->id,
                'language_id' => $uzbek->id,
            ], [
                'user_id' => $client->id,
                'translator_id' => $translatorPortfolio->id,
                'work_id' => $work->id,
                'language_id' => $uzbek->id,
                'status' => $workData['status'],
                'deadline' => Carbon::now()->addDays(rand(7, 30))
            ]);

            // Create translation if work is completed
            if ($workData['has_translation']) {
                Translation::firstOrCreate([
                    'work_id' => $work->id,
                    'translator_id' => $translatorPortfolio->id,
                    'language_id' => $uzbek->id,
                ], [
                    'work_id' => $work->id,
                    'translator_id' => $translatorPortfolio->id,
                    'language_id' => $uzbek->id,
                    'status' => 'published',
                    'price' => $workData['price'],
                    'preview_pages_cnt' => rand(3, 10)
                ]);
            }
        }
    }
}
