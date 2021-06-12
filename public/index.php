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

const APP_URL = 'http://gameoverflow.test/';

const DS = DIRECTORY_SEPARATOR;
const FRONT_PATH = __DIR__;
define('ROOT_PATH', dirname(__DIR__));
const APP_PATH = ROOT_PATH . DS . 'App';
const CORE_PATH = APP_PATH . DS . 'Core';
const CONTROLLER_PATH = APP_PATH . DS . 'Controllers';
const VIEW_PATH = APP_PATH . DS . 'views';
const HELPER_PATH = APP_PATH . DS . 'helpers';

require_once HELPER_PATH.DS.'helpers.php';

date_default_timezone_set('Asia/Jakarta');
set_exception_handler('global_exception_handler');
spl_autoload_register('classLoader');

require_once APP_PATH.DS.'routes.php';

$services = \App\Core\ServiceContainer::getInstance();

$services->put('request', function () {
    return new \App\Core\Request();
}, \App\Core\Request::class);

$services->put('database', function () {
    return new \App\Core\DB();
}, \App\Core\DB::class);

$services->put('middleware', function () {
    return new \App\Core\Middleware\RegisteredMiddleware();
}, \App\Core\Middleware\RegisteredMiddleware::class);

$services->put('auth', function () {
    return new \App\Core\AuthManager();
}, \App\Core\AuthManager::class);

\App\Core\Route::run($services);
