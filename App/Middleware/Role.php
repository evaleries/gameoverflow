<?php

namespace App\Middleware;

use App\Core\Middleware\Middleware;
use App\Core\Request;
use Closure;

class Role extends Middleware
{
    public function handle(Request $request, Closure $next, $roles = [])
    {
        if (!auth()->check()) {
            return redirect('auth/login');
        }

        if (is_string($roles) && strtolower($roles) === strtolower(auth()->user()->getRoleName())) {
            return $next($request);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                $role = strtolower($role);
                if ($role === 'admin' && auth()->user()->isAdmin()) {
                    return $next($request);
                }

                if ($role === strtolower(auth()->user()->getRoleName())) {
                    return $next($request);
                }
            }
        }

        return abort(403, 'Anda tidak memiliki akses di halaman ini.');
    }
}
