<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurePdfHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only apply to PDF iframe requests or pages containing PDF iframes
        if ($request->is('translations/*') || $request->is('*.pdf')) {
            // Allow iframe embedding for same origin
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

            // Content Security Policy for PDF viewing
            $csp = "frame-src 'self' data:; object-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval';";
            $response->headers->set('Content-Security-Policy', $csp);

            // Additional security headers
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }

        return $response;
    }
}
