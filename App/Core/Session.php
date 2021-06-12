<?php

namespace App\Core;

/**
 * Class untuk menghandle session.
 * Class Session.
 */
class Session
{
    /**
     * @var bool
     */
    const SESSION_STARTED = TRUE;

    /**
     * @var bool
     */
    const SESSION_NOT_STARTED = FALSE;

    /**
     * @var bool
     */
    private $sessionState = self::SESSION_NOT_STARTED;

    /**
     * @var
     */
    private static $instance;

    /**
     * Session constructor.
     */
    private function __construct() {}


    /**
     * @return Session
     */
    public static function getInstance()
    {
        if ( !isset(self::$instance))
        {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }

    /**
     * Restart the session.
     * @return bool
     */
    public function startSession()
    {
        if ( $this->sessionState == self::SESSION_NOT_STARTED )
        {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
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
     *
     * @return mixed|null
     */
    public function get($key = null, $defaultValue = null)
    {
        if ($key === null) {
            return $_SESSION ?? $defaultValue;
        }

        return $_SESSION[$key] ?? $defaultValue;
    }

    /**
     * @param $key
     * @param null $secondKey
     *
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
     *
     * @param $key
     * @param null       $secondKey
     * @param mixed|null $defaultValue
     *
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

    /**
     * @param $key
     * @return bool
     */
    public function unset($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);

            return true;
        }

        return false;
    }

    /**
     * Destroy session.
     */
    public function destroy()
    {
        if ( $this->sessionState == self::SESSION_STARTED )
        {
            $this->sessionState = !session_destroy();
            unset( $_SESSION );

            return !$this->sessionState;
        }
        return $this;
    }
}
