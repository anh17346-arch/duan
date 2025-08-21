<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale')) {
            $locale = session('locale');
            app()->setLocale($locale);
            \Log::info('SetLocale middleware applied: ' . $locale);
        } else {
            \Log::info('No locale in session, using default: ' . app()->getLocale());
        }
        
        return $next($request);
    }
}
