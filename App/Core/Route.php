<?php

namespace App\Core;

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
     * @param closure|array|string $function
     * @param string               $method
     */
    public static function add($expression, $function, $method = 'GET', $beforeMiddleware = null)
    {
        if (is_array($function)) {
            $function = implode('@', $function);
        }

        array_push(self::$routes, compact('expression', 'function', 'method', 'beforeMiddleware'));
    }

    /**
     * @param $expression
     * @param closure|array|string $function
     * @param closure|null         $beforeMiddleware
     */
    public static function get($expression, $function, $beforeMiddleware = null)
    {
        self::add($expression, $function, 'GET', $beforeMiddleware);
    }

    /**
     * @param $expression
     * @param $function
     * @param closure|null $beforeMiddleware
     */
    public static function post($expression, $function, $beforeMiddleware = null)
    {
        self::add($expression, $function, 'POST', $beforeMiddleware);
    }

    /**
     * @param int  $code
     * @param null $message
     */
    public static function error($code = 400, $message = null)
    {
        http_response_code($code);
        if (View::isExist('errors.'.$code)) {
            view('errors.'.$code, compact('code', 'message'))->output();
        } else {
            view('errors.error', compact('code', 'message'))->output();
        }

        exit();
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
     */
    public static function redirect($to = '/')
    {
        header('Location: '.Url::base($to));
        exit();
    }

    public static function back($fallback = '/')
    {
        $referer = Url::referer();
        if (startsWith($referer, Url::base())) {
            header('Location: '.$referer);
            exit();
        }

        self::redirect($fallback);
    }

    /**
     * @param ServiceContainer $serviceContainer
     * @param string           $basePath
     *
     * @throws ReflectionException
     */
    public static function run($serviceContainer, $basePath = '/')
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
                    if (isset($route['beforeMiddleware']) && is_callable($route['beforeMiddleware'])) {
                        call_user_func($route['beforeMiddleware']);
                    }
                    self::invokeMethod($serviceContainer, $route, $matches);
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
     */
    private static function invokeMethod($serviceContainer, $route, $matches)
    {
        array_shift($matches);
        if (is_callable($route['function'])) {
            call_user_func_array($route['function'], $matches);
        } elseif (strpos($route['function'], '@')) {
            list($className, $methodName) = explode('@', $route['function']);
            if (class_exists($className)) {
                $class = new \ReflectionClass($className);
                $instance = $class->newInstance();

                if ($class->hasMethod($methodName)) {
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
                } else {
                    throw new \BadMethodCallException('[Route] Method tidak ditemukan: '.$methodName);
                }

                // Jika menggunakan call_user_func, constructor parent tidak terpanggil
                // call_user_func_array([$className, $methodName], $matches);
            } else {
                throw new \BadFunctionCallException('[Route] Class tidak ditemukan: '.$className);
            }
        }
    }
}
