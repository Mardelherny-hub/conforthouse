<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);
        
        if ($locale && in_array($locale, ['en', 'es', 'fr', 'de', 'nl'])) {
            app()->setLocale($locale);
        }
        
        return $next($request);
    }
}