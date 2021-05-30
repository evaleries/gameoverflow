<?php

namespace App\Core;

class Request
{
    /**
     * @var array Store all requests data.
     */
    private $requestData;

    private $errors = [];

    public function __construct($data = [])
    {
        $this->requestData = $_REQUEST;

        if (!empty($data)) {
            $this->requestData = array_merge($this->requestData, $data);
        }
    }

    public function validate($params = [])
    {
        if (!empty($params)) {
            foreach ($params as $param => $rules) {
                $this->__set($param, $this->validateRule($param, $rules));
            }
        }

        return true;
    }

    private function validateRule($param, $rules, $delimiter = '|')
    {
        foreach (explode($delimiter, $rules) as $rule) {
            if ($rule === 'int') {
                $this->__set($param, intval($this->__get($param)));
            } elseif ($rule === 'float' || $rule === 'double' && is_numeric($param)) {
                $this->__set($param, floatval($this->__get($param)));
            } elseif ($rule === 'trim') {
                $this->__set($param, trim($this->__get($param)));
            } elseif ($rule == 'email') {
                if (!filter_var($param, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$param] = [
                        'field'   => $param,
                        'message' => $param.' harus email yang valid!',
                    ];
                }
            } elseif ($rule == 'numeric') {
                if (!is_numeric($this->get($param, null))) {
                    $this->__set($param, null);
                    $this->errors[$param] = [
                        'field'   => $param,
                        'message' => $param.' harus angka',
                    ];
                }
            } elseif ($rule == 'required') {
                if (!$this->__isset($param) || empty(trim($this->requestData[$param]))) {
                    $this->__set($param, null);
                    $this->errors[$param] = [
                        'field'   => $param,
                        'message' => $param.' dibutuhkan!',
                    ];
                }
            }

            return $this->get($param, null);
        }
    }

    public function isError()
    {
        return !empty($this->errors);
    }

    /**
     * @see https://stackoverflow.com/questions/18260537/how-to-check-if-the-request-is-an-ajax-request-with-php
     *
     * @return bool
     */
    public function ajax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }

        return false;
    }

    /**
     * @param string $route
     *
     * @return bool
     */
    public static function is($route)
    {
        return \App\Core\Route::is($route);
    }

    public function hasOldRequest($key, $default = null)
    {
        $oldRequest = $this->getOldRequest($key, $default);

        return is_null($key) ? count($oldRequest) > 0 : !is_null($oldRequest);
    }

    public function getOldRequest($key = null, $default = null)
    {
        return session()->has('__old_request', $key) ? session()->get('__old_request', $default)[$key] : $default;
    }

    /**
     * Get request uri.
     *
     * @param $name
     * @param null $defaultValue
     *
     * @return array|mixed
     */
    public function get($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $this->requestData;
        }

        return $this->requestData[$name] ?? $defaultValue;
    }

    public function __get($name)
    {
        return $this->__isset($name) ? $this->requestData[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->requestData[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->requestData[$name]);
    }

    public function __destruct()
    {
        if ($this->isError()) {
            session()->set('validation_errors', $this->errors);
        }

        session()->set('__old_request', $this->requestData);
    }
}
