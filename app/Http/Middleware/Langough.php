<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Langough
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
        if (!$request->header('Accept-Language')  or $request->header('Accept-Language')==null ) {
            $locale = $request->header('Accept-Language', 'en'); 
        }
        $locale = $request->header('Accept-Language'); 
    
        if (in_array($locale, ['en', 'ar'])) { 
            App::setLocale($locale);
        }

        return $next($request);
    }
}
