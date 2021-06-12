<?php

namespace App\Middleware;


use App\Core\Middleware\Middleware;
use App\Core\Request;
use App\Core\Route;
use Closure;

class RedirectIfAuthenticated extends Middleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            return Route::back();
        }

        return $next($request);
    }
}
