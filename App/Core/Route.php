<?php

namespace App\Core;

use App\Core\Middleware\Middleware;
use Closure;
use Exception;
use ReflectionException;

/**
 * Routing sederhana memanfaatkan RegEx dan telah dikembangkan.
 * Terinspirasi dari Laravel.
 * Class Route.
 *
 * @see https://steampixel.de/en/simple-and-elegant-url-routing-with-php/
 * @see https://stackoverflow.com/questions/11722711/url-routing-regex-php
 */
class Route
{
    /**
     * @var array
     */
    private static $routes = [];

    /**
     * @var string
     */
    private static $currentRoute;

    /**
     * @param $expression
     * @param closure|mixed $function
     * @param string        $method
     * @param null          $middleware
     */
    public static function add($expression, $function, string $method = 'GET', $middleware = null)
    {
        if (is_array($function)) {
            $function = implode('@', $function);
        }

        array_push(self::$routes, compact('expression', 'function', 'method', 'middleware'));
    }

    /**
     * @param $expression
     * @param closure|mixed $function
     * @param closure|null  $middleware
     */
    public static function get($expression, $function, $middleware = null)
    {
        self::add($expression, $function, 'GET', $middleware);
    }

    /**
     * @param $expression
     * @param $function
     * @param closure|null $middleware
     */
    public static function post($expression, $function, $middleware = null)
    {
        self::add($expression, $function, 'POST', $middleware);
    }

    /**
     * @param int|string $code
     * @param null $message
     * @return null
     */
    public static function error($code = 400, $message = null)
    {
        http_response_code($code);
        if (View::isExist('errors.'.$code)) {
            view('errors.'.$code, compact('code', 'message'))->output();
        } else {
            view('errors.error', compact('code', 'message'))->output();
        }

        return null;
    }

    /**
     * @return array
     */
    public static function routes()
    {
        return self::$routes;
    }

    public static function current()
    {
        return self::$currentRoute;
    }

    /**
     * @param $route
     *
     * @return bool
     */
    public static function is($route)
    {
        if ($route == self::$currentRoute) {
            return true;
        } elseif (endsWith($route, '*')) {
            return startsWith(self::$currentRoute, str_replace('*', '', $route));
        }

        return false;
    }

    /**
     * @param string $to
     * @return bool
     */
    public static function redirect(string $to = '/')
    {
        header('Location: '.Url::base($to));
        exit();
    }

    public static function getReferer() {
        return Url::referer() ?: false;
    }

    public static function back($fallback = '/'): bool
    {
        $referer = self::getReferer();
        if (startsWith($referer, Url::base())) {
            header('Location: '.$referer);
            exit();
        }

        self::redirect($fallback);
        exit();
    }

    /**
     * @param ServiceContainer $serviceContainer
     * @param string           $basePath
     *
     * @throws ReflectionException
     */
    public static function run(ServiceContainer $serviceContainer, string $basePath = '/')
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'] ?? '/';
        $clearPath = str_replace($basePath, '/', $path);
        $method = $_SERVER['REQUEST_METHOD'];
        $isRouteMatch = false;
        $isMethodMatch = false;

        foreach (self::$routes as $route) {
            $expression = '~^'.$route['expression'].'$~i';

            if (preg_match($expression, $clearPath, $matches)) {
                $isRouteMatch = true;
                if (strtolower($method) == strtolower($route['method'])) {
                    self::$currentRoute = $route['expression'];
                    if (isset($route['middleware'])) {
                        self::invokeMiddleware($serviceContainer, $route);
                    }
                    self::invokeController($serviceContainer, $route, $matches);
                    $isMethodMatch = true;
                    break;
                }
            }
        }

        if ($isRouteMatch && !$isMethodMatch) {
            self::error(405, 'Method not allowed!');
        } elseif (!$isRouteMatch) {
            self::error(404, 'Not found');
        }
    }

    /**
     * Memanggil method pada controller.
     *
     * @param ServiceContainer $serviceContainer
     * @param $route
     * @param $matches
     *
     * @throws ReflectionException
     * @throws Exception
     *
     * @return void
     */
    private static function invokeController(ServiceContainer $serviceContainer, $route, $matches): void
    {
        array_shift($matches);

        if (is_callable($route['function'])) {
            call_user_func_array($route['function'], $matches);

            return;
        }

        if (strpos($route['function'], '@')) {
            list($className, $methodName) = explode('@', $route['function']);

            if (!class_exists($className)) {
                throw new \BadFunctionCallException('[Route] Class tidak ditemukan: '.$className);
            }

            $class = new \ReflectionClass($className);
            $instance = $class->newInstance();

            if (!$class->hasMethod($methodName)) {
                throw new \BadMethodCallException('[Route] Method tidak ditemukan: '.$methodName);
            }

            $paramToInject = [];
            $method = $class->getMethod($methodName);

            foreach ($method->getParameters() as $index => $param) {
                if ($param->getClass()) {
                    $nameRequiredClass = $param->getClass()->getName();
                    $service = $serviceContainer->findClass($nameRequiredClass);

                    if ($service instanceof $nameRequiredClass) {
                        $paramToInject[$param->getPosition()] = $service;
                    } else {
                        throw new Exception('[Route] Service gagal di inject ke controller: '.$nameRequiredClass);
                    }
                } elseif (isset($matches[$index])) {
                    $paramToInject[$index] = $matches[$index];
                }
            }

            if (!empty($matches)) {
                foreach ($matches as $param) {
                    $paramToInject[] = $param;
                }
            }

            $method->invokeArgs($instance, $paramToInject);

            return;
        }

        throw new \Exception('[Route] Tidak ada yang menangani route ini.');
    }

    /**
     * Memanggil Middleware yang didefinisikan pada routes.
     *
     * @throws Exception
     */
    public static function invokeMiddleware(ServiceContainer $serviceContainer, $route)
    {
        if (empty($route['middleware'])) {
            return;
        }

        $middlewares = $route['middleware'];
        if (!is_array($middlewares)) {
            $middlewares = explode('|', $route['middleware']);
        }

        $layers = [];
        foreach ($middlewares as $middleware) {
            [$name, $parameters] = array_pad(explode(':', $middleware), 2, null);

            if ($parameters !== null && strpos($parameters, ',') !== false) {
                $parameters = explode(',', $parameters);
            }

            $layers[] = $serviceContainer->get('middleware')->resolve($name, $parameters);
        }

        $request = $serviceContainer->get('request');
        (new Middleware())
            ->layer($layers)
            ->handle($request, function ($request) {
                return $request;
            });
    }
}
