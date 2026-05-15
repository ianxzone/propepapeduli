<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Dynamic CSP to allow local dev (Vite, Laragon)
        $csp = "default-src 'self' https:; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https: http:; ";
        $csp .= "style-src 'self' 'unsafe-inline' https: http:; ";
        $csp .= "img-src 'self' data: https: http:; ";
        $csp .= "font-src 'self' https: data:; ";
        $csp .= "frame-src 'self' https:; ";
        $csp .= "connect-src 'self' https: http: ws: wss:;";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
