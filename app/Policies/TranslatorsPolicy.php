<?php

namespace App\Policies;

use App\Models\TranslatorPortfolio;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TranslatorsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return auth()->user()->role === 'translator';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TranslatorPortfolio $translatorPortfolio): bool
    {
        return auth()->user()->role === 'translator';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TranslatorPortfolio $translatorPortfolio): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TranslatorPortfolio $translatorPortfolio): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TranslatorPortfolio $translatorPortfolio): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TranslatorPortfolio $translatorPortfolio): bool
    {
        return false;
    }
}
