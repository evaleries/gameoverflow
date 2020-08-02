<?php

namespace App\Core;

/**
 * Service instance
 * Class ServiceInstance.
 *
 * @see https://catchmetech.com/en/post/95/implementation-of-dependency-injection-in-php
 */
class ServiceInstance
{
    private $name;
    private $loader;
    private $instance = null;

    public function __construct($name, $instance)
    {
        $this->name = $name;

        if ($instance instanceof \Closure) {
            $this->loader = $instance;
        } else {
            $this->instance = $instance;
        }
    }

    public function getService()
    {
        if ($this->instance === null) {
            $loaderClosure = $this->loader;
            $this->instance = $loaderClosure();
        }

        return $this->instance;
    }
}
