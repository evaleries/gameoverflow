<?php

namespace App\Core;

/**
 * Class sederhana untuk membantu mengambil URL
 * Class Url.
 */
class Url
{
    private static function getScheme()
    {
        if (defined('APP_URL')) {
            return startsWith(APP_URL, 'http:') ? 'http' : 'https';
        }

        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    }

    private static function getHost()
    {
        return defined('APP_URL') ? parse_url(APP_URL, PHP_URL_HOST) : $_SERVER['SERVER_NAME'];
    }

    public static function current()
    {
        return sprintf(
            '%s://%s/%s',
            self::getScheme(),
            self::getHost(),
            $_SERVER['REQUEST_URI']
        );
    }

    public static function base($dir = '')
    {
        $dir = !empty($dir) || $dir != '/' ? (startsWith($dir, '/') ? substr($dir, 1, strlen($dir)) : $dir) : '';

        if (defined('APP_URL')) {
            return APP_URL.$dir;
        }

        return sprintf(
            '%s://%s/%s',
            self::getScheme(),
            self::getHost(),
            $dir
        );
    }

    public static function asset($file = '', $rootDir = 'assets/')
    {
        return self::base($rootDir.$file);
    }

    public static function route($to = '/', $param = [], $withCurrentQuery = false)
    {
        if (is_array($param)) {
            $queries = [];
            parse_str($_SERVER['QUERY_STRING'], $queries);
            $param = '?'.http_build_query($withCurrentQuery ? array_replace($queries, $param) : $param);
        }

        return self::base($to.$param);
    }

    public static function referer()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }

        return null;
    }
}
