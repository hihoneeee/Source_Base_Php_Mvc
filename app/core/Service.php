<?php

namespace App\Core;

use Exception;

class ServiceContainer
{
    private $services = [];

    // Register a service with a given key
    public function register($name, $service)
    {
        $this->services[$name] = $service;
    }

    // Resolve a service by its key
    public function get($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name];
        }
        throw new Exception("Service '{$name}' not found.");
    }
}