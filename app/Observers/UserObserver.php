<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user)
    {
        // Check if role was changed to 'translator'
        if ($user->isDirty('role') && $user->role === 'translator') {
            // Check if translator portfolio doesn't exist
            if (!$user->translatorPortfolio) {
                // Create default translator portfolio
                $user->translatorPortfolio()->create([
                    'bio' => null,
                    'profile_image_url' => null,
                    'total_earnings' => 0.00,
                    'average_rating' => 0.00,
                ]);
            }
        }
    }


    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
