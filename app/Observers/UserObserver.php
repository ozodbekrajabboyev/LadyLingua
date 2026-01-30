<?php

namespace App\Observers;

use App\Models\User;
use App\Models\TranslatorPortfolio;

class UserObserver
{
    public function updated(User $user): void
    {
        if ($user->isDirty('role') && $user->role === 'translator') {

            if (!$user->translatorPortfolio) {

                TranslatorPortfolio::create([
                    'user_id' => $user->id,
                    'bio' => null,
                    'profile_image_url' => null,
                    'total_earnings' => 0.00,
                    'average_rating' => 0.00,
                ]);
            }
        }
    }
}
