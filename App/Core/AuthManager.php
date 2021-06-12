<?php


namespace App\Core;


use App\Models\User;

/**
 * Class AuthManager
 * @package App\Core
 */
class AuthManager
{
    /**
     * @var User
     */
    private $user;

    /**
     * Session key for current logged in user.
     * @var string
     */
    private $sessionKey = '__auth';

    /**
     * Session key for logout token.
     * @var string
     */
    private $sessionLogoutKey = '__logout_token';

    public function __construct()
    {
        if ($this->check()) {
            $this->loginAs($this->user());
        }
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return session()->has($this->sessionKey);
    }

    /**
     * @return User
     */
    public function user(): ?User
    {
        if ($this->user) {
            return $this->user;
        }

        if (session()->has($this->sessionKey)) {
            $this->user = session()->get($this->sessionKey);
        }

        return $this->user;
    }

    /**
     * @param $user
     * @return AuthManager
     */
    public function loginAs($user): AuthManager
    {
        if ($user instanceof User) {
            $this->user = $user;
            session()->set($this->sessionKey, $user);
            session()->set($this->sessionLogoutKey, base64_encode(md5($user)));
        }

        return $this;
    }

    /**
     * Logout user by unsetting the session.
     */
    public function logout()
    {
        session()->unset($this->sessionKey);
        session()->unset($this->sessionLogoutKey);
        session()->destroy();
        $this->user = null;
    }

    /**
     * Get logout token from session.
     * @return array|mixed|null
     */
    public function logoutToken()
    {
        return session()->get($this->sessionLogoutKey);
    }

    /**
     * @param $name
     * @return bool|int|mixed|string|null
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        if ($this->user) {
            if (property_exists($this->user, $name)) {
                return $this->user->$name;
            }

            if ($this->user->$name) {
                return $this->user->$name;
            }
        }

        return null;
    }


    /**
     * @param $name
     * @param $arguments
     * @return false|mixed|null
     */
    public function __call($name, $arguments)
    {
        if ($this->user && method_exists($this->user, $name)) {
            return call_user_func_array([$this->user, $name], $arguments);
        }

        return null;
    }
}
