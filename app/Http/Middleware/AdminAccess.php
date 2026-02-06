<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow access to registration and login pages
        if ($request->routeIs('filament.admin.auth.register') || $request->routeIs('filament.admin.auth.login')) {
            return $next($request);
        }

        try {
            if (auth()->check()) {
                /** @var User $user */
                $user = auth()->user();

                // Ensure user model is properly loaded (production safety)
                if (!$user || !$user->exists) {
                    auth()->logout();
                    return redirect('/platform/login')->with('error', 'Session expired. Please login again.');
                }

                // Block users with 'blocked' status
                if (isset($user->status) && $user->status === 'blocked') {
                    auth()->logout();
                    return redirect('/')->with('error', 'Your account has been blocked.');
                }

                // Only allow admin and translator roles to access the panel
                if (!in_array($user->role, ['admin', 'translator'])) {
                    return redirect('/')->with('error', 'Access denied to admin panel.');
                }
            } else {
                // User not authenticated, redirect to login
                return redirect('/platform/login');
            }
        } catch (\Exception $e) {
            // Production-safe error handling
            if (config('app.env') === 'production') {
                return redirect('/platform/login')->with('error', 'Authentication error. Please login again.');
            } else {
                // Re-throw in development for debugging
                throw $e;
            }
        }

        return $next($request);
    }
}
