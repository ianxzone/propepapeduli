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
        
        // HSTS (Strict-Transport-Security) - 1 year
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // Tighten Content Security Policy
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdn.tailwindcss.com https://cdn.tiny.cloud https://cdn.ckeditor.com https://www.youtube.com https://s.ytimg.com; ";
        $csp .= "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net https://cdn.tailwindcss.com https://cdn.tiny.cloud https://cdn.ckeditor.com; ";
        $csp .= "img-src 'self' data: https: http: https://cdn.tiny.cloud; ";
        $csp .= "font-src 'self' https://fonts.gstatic.com; ";
        $csp .= "frame-src 'self' https://www.youtube.com; ";
        $csp .= "connect-src 'self' https://cdn.ckeditor.com; ";

        // Allow local dev assets if in local environment
        if (app()->environment('local')) {
            $csp = str_replace("default-src 'self';", "default-src 'self' http: https:;", $csp);
            $csp = str_replace("script-src 'self'", "script-src 'self' http: https:", $csp);
            $csp = str_replace("style-src 'self'", "style-src 'self' http: https:", $csp);
            $csp = str_replace("connect-src 'self';", "connect-src 'self' ws: wss: http: https:;", $csp);
        }

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
