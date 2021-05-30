<?php

namespace App\Core\Middleware;

use App\Middleware\Authenticate;
use App\Middleware\RedirectIfAuthenticated;
use App\Middleware\Role;

class RegisteredMiddleware
{
    protected $middleware = [
        'auth'  => Authenticate::class,
        'role'  => Role::class,
        'guest' => RedirectIfAuthenticated::class,
    ];

    /**
     * @throws \Exception
     *
     * @return Middleware
     */
    public function resolve($middleware, $params = null)
    {
        if (!isset($this->middleware[$middleware])) {
            throw new \BadMethodCallException('Middleware '.$middleware.' tidak ditemukan');
        }

        if ($params !== null) {
            return new $this->middleware[$middleware]([], $params);
        }

        return new $this->middleware[$middleware]();
    }
}
