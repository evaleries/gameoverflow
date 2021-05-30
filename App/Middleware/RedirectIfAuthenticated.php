<?php

namespace App\Middleware;

use App\Core\Middleware\MiddlewareContracts;
use App\Core\Request;
use Closure;

class RedirectIfAuthenticated implements MiddlewareContracts
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('__auth')) {
            return \App\Core\Route::back();
        }

        return $next($request);
    }
}
