<?php

namespace App\Middleware;

use App\Core\Middleware\Middleware;
use App\Core\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('__auth')) {
            return $next($request);
        }

        return redirect('auth/login');
    }
}
