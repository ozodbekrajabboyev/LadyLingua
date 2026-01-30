<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomEloquentUserProvider extends EloquentUserProvider
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials): bool
    {
        // First check if user is blocked - if so, return false (shows "Invalid credentials")
        if (isset($user->status) && $user->status === 'blocked') {
            return false;
        }

        // If user is not blocked, validate credentials normally
        return parent::validateCredentials($user, $credentials);
    }
}
