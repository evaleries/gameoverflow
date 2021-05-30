<?php

/**
 * Mini php native application.
 *
 * @author evaleries
 *
 * @see https://github.com/evaleries
 */

/**
 * Production.
 */
// error_reporting(0);

/**
 * Development.
 */
ini_set('display_errors', E_ALL);

define('APP_URL', 'http://game-overflow.test/');

define('DS', DIRECTORY_SEPARATOR);
define('FRONT_PATH', __DIR__);
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH.DS.'App');
define('CORE_PATH', APP_PATH.DS.'Core');
define('CONTROLLER_PATH', APP_PATH.DS.'Controllers');
define('VIEW_PATH', APP_PATH.DS.'views');
define('HELPER_PATH', APP_PATH.DS.'helpers');
date_default_timezone_set('Asia/Jakarta');

set_exception_handler('global_exception_handler');

/**
 * @param Exception $exception
 */
function global_exception_handler($exception)
{
    App\Core\Route::error(empty($exception->getCode()) ? 500 : $exception->getCode(), implode(PHP_EOL, [$exception->getMessage(), $exception->getFile().':'.$exception->getLine(), $exception->getTraceAsString()]));
}

spl_autoload_register('classLoader');

/**
 * @param string $className
 *
 * @throws Exception
 */
function classLoader($className)
{
    $className = str_replace('\\', DS, $className);
    $classPath = ROOT_PATH.DS.$className.'.php';
    if (file_exists($classPath) && is_readable($classPath)) {
        include $classPath;
    } else {
        exit('Class: '.$className.' is not found! on '.$classPath);
    }
}

require_once HELPER_PATH.DS.'helpers.php';
require_once HELPER_PATH.DS.'middleware.php';
require_once APP_PATH.DS.'routes.php';

$services = \App\Core\ServiceContainer::i();

$services->put('request', function () {
    return new \App\Core\Request();
}, \App\Core\Request::class);

$services->put('session', function () {
    return new \App\Core\Session(120);
}, \App\Core\Session::class);

$services->put('database', function () {
    return new \App\Core\DB();
}, \App\Core\DB::class);

$services->put('middleware', function () {
    return new \App\Core\Middleware\RegisteredMiddleware();
}, \App\Core\Middleware\RegisteredMiddleware::class);

\App\Core\Route::run($services);
