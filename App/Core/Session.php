<?php


namespace App\Core;


/**
 * Class untuk menghandle session.
 * Class Session
 * @package App\Core
 */
class Session
{

    /**
     * @var bool
     */
    private $isStarted = false;

    /**
     * @param int $maxLifeTime in minutes
     * @return bool
     */
    public function __construct($maxLifeTime = 60)
    {
        if (! $this->isStarted) {
            session_set_cookie_params($maxLifeTime * 60);
            session_start();

            return $this->isStarted = true;
        }

        return false;
    }

    /**
     * @param $key
     * @param null $value
     */
    public function set($key, $value = null)
    {
        if (is_array($key) && $value == null) {
            foreach ($key as $name => $value) {
                $_SESSION[$name] = $value;
            }
        } else {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * @param null $key
     * @param null $defaultValue
     * @return mixed|null
     */
    public function get($key = null, $defaultValue = null)
    {
        if ($key === null) {
            return isset($_SESSION) ? $_SESSION : $defaultValue;
        }

        return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
    }

    /**
     * @param $key
     * @param null $secondKey
     * @return bool
     */
    public function has($key, $secondKey = null)
    {
        if ($secondKey == null) {
            return isset($_SESSION[$key]);
        }

        return isset($_SESSION[$key][$secondKey]);
    }

    /**
     * Mengambil session dan di return, lalu di hapus.
     * @param $key
     * @param null $secondKey
     * @param mixed|null $defaultValue
     * @return mixed|null
     */
    public function flash($key, $secondKey = null, $defaultValue = null)
    {
        if ($secondKey !== null && isset($_SESSION[$key][$secondKey])) {
            $val = $_SESSION[$key][$secondKey];
            unset($_SESSION[$key][$secondKey]);

            return $val;
        } elseif (isset($_SESSION[$key])) {
            $val = $_SESSION[$key];
            unset($_SESSION[$key]);

            return $val;
        }

        return $defaultValue;
    }

    /**
     * @return string
     */
    public function id()
    {
        return session_id();
    }

    /**
     * @return string
     */
    public function regenerate()
    {
        session_regenerate_id(true);

        return session_id();
    }

    public function unset($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }

        return false;
    }

    public function destroy()
    {
        if (self::$isStarted) {
            session_unset();
            session_destroy();
        }
    }
}