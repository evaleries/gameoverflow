<?php


namespace App\Core;

use Exception;

/**
 * ServiceContainer untuk me-load & register service.
 * Class ServiceContainer
 * @package App\Core
 * @see https://catchmetech.com/en/post/95/implementation-of-dependency-injection-in-php
 */
class ServiceContainer
{
    private static $instance = null;

    private $mapping = [];

    /**
     *
     * @var ServiceInstance[]
     */
    private $allocator = [];

    /**
     * @return ServiceContainer
     */
    public static function i(){
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function put($name, $service, $class = '') {
        if ($service instanceof \Closure) {
            $this->addMapping($class, $name);
        } else {
            if (is_object($service)) {
                $class = get_class($service);
                $this->addMapping($class, $name);
            }
        }
        $this->allocator[$name] = new ServiceInstance($name, $service);
    }

    /**
     * Adds a mapping class -> service alias to give ability to search over services by a class name
     * @param $class
     * @param $alias
     */
    private function addMapping($class, $alias) {
        if (!isset($this->mapping[$class])) {
            $this->mapping[$class] = [];
        }
        $this->mapping[$class][$alias] = true;
    }

    /**
     * Returns a service by a classname
     * @param $classname
     * @return mixed|null
     * @throws Exception
     */
    public function findClass($classname){
        if (isset($this->mapping[$classname])) {
            if (count($this->mapping[$classname]) > 1) {
                throw new \Exception('Terdapat lebih dari 1 instance dengan nama '. $classname);
            } else {
                return $this->get(array_keys($this->mapping[$classname])[0]);
            }
        }
    }

    /**
     * @param $name
     * @return mixed|null
     * @throws Exception
     */
    public function get($name) {
        if (!isset($this->allocator[$name])) {
            throw new \Exception('[ServiceContainer] Service tidak ditemukan: '.$name);
        }
        return $this->allocator[$name]->getService();
    }
}