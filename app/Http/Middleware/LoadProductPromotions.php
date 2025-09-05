<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadProductPromotions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Load promotions for products if needed
        if ($request->route() && in_array($request->route()->getName(), [
            'products.show',
            'products.index',
            'categories.show',
            'search.index'
        ])) {
            // The promotions will be loaded through the Product model relationships
            // No additional logic needed here as it's handled in the model
        }

        return $next($request);
    }
}
