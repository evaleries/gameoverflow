<?php


namespace App\Core;


/**
 * Class sederhana untuk membantu mengambil URL
 * Class Url
 * @package App\Core
 */
class Url
{

    private static function getScheme()
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http';
    }

    public static function current()
    {
        return sprintf("%s://%s%s",
            self::getScheme(),
            $_SERVER['SERVER_NAME'],
            $_SERVER['REQUEST_URI']
        );
    }

    public static function base($dir = '')
    {
        return sprintf("%s://%s/%s", self::getScheme(), $_SERVER['SERVER_NAME'], !empty($dir) || $dir != '/' ? (startsWith($dir, '/') ? substr($dir, 1, strlen($dir)) : $dir) : '');
    }

    public static function asset($file = '', $rootDir = 'assets/')
    {
        return self::base($rootDir . $file);
    }

    public static function route($to = '/', $param = [], $withCurrentQuery = false)
    {
        if (is_array($param)) {
            $queries = [];
            parse_str($_SERVER['QUERY_STRING'], $queries);
            $param = '?' . http_build_query($withCurrentQuery ? array_replace($queries, $param) : $param);
        }

        return self::base($to . $param);
    }

    public static function referer()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return $_SERVER['HTTP_REFERER'];
        }

        return null;
    }

}