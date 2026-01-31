<?php

namespace App\Providers;

use App\Auth\CustomEloquentUserProvider;
use App\Models\User;
use App\Observers\UserObserver;
use Filament\Auth\Http\Responses\LoginResponse;
//use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Auth\Http\Responses\RegistrationResponse;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Redirect to dashboard after register for Users (role: 'user')
        $this->app->bind(RegistrationResponse::class, function () {
            return new class extends RegistrationResponse {
                public function toResponse($request): \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
                {
                    /** @var \App\Models\User|null $user */
                    $user = auth()->user();

                    if ($user && $user->role === 'user') {
                        return redirect('/');
                    }

                    return redirect()->intended(Filament::getUrl());
                }
            };
        });

        // Redirect to dashboard after login for Users (role: 'user')
        $this->app->bind(LoginResponse::class, function () {
            return new class extends LoginResponse {
                public function toResponse($request): \Illuminate\Http\RedirectResponse|\Livewire\Features\SupportRedirects\Redirector
                {
                    /** @var \App\Models\User|null $user */
                    $user = auth()->user();

                    if ($user && ($user->role === 'user' || $user->status === 'blocked')) {
                        return redirect('/');
                    }

                    return redirect()->intended(Filament::getUrl());
                }
            };
        });

        Auth::provider('custom-eloquent', function ($app, $config) {
            return new CustomEloquentUserProvider($this->app['hash'], $config['model']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
    }
}
