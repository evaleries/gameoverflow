<?php


namespace App\Core\Middleware;

use App\Core\Request;
use Closure;

interface MiddlewareContracts
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next);

}
