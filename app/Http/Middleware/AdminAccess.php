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
        if (auth()->check()) {
            /** @var User $user */
            $user = auth()->user();

            if ($user->role === 'user') {
                return redirect('/')->with('error', 'Access denied to admin panel.');
            }
        }

        return $next($request);
    }
}
