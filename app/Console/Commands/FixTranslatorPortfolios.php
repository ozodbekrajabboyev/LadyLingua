<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\TranslatorPortfolio;
use Illuminate\Console\Command;

class FixTranslatorPortfolios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:translator-portfolios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create missing translator portfolios for translator users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for translators without portfolios...');

        $translatorsWithoutPortfolio = User::where('role', 'translator')
            ->doesntHave('translatorPortfolio')
            ->get();

        if ($translatorsWithoutPortfolio->isEmpty()) {
            $this->info('✅ All translator users have portfolios.');
            return;
        }

        $this->info("Found {$translatorsWithoutPortfolio->count()} translators without portfolios:");

        foreach ($translatorsWithoutPortfolio as $user) {
            $this->line("- {$user->name} ({$user->email})");

            TranslatorPortfolio::create([
                'user_id' => $user->id,
                'bio' => null,
                'profile_image_url' => null,
                'total_earnings' => 0.00,
                'average_rating' => 0.00,
            ]);

            $this->info("✅ Created portfolio for {$user->name}");
        }

        $this->info('🎉 All translator portfolios have been created!');
    }
}
